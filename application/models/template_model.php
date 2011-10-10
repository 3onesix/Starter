<?php

class Template_Model extends My_Model
{
	public function init()
	{
		$this->validates('name', 'required');
		
		$this->has_many('pages');
		$this->has_many('template_variables');
	}
	
	public function find($conditions, $offset = 0, $limit = 10)
	{
		if ( ! $this->scan_complete )
		{
			// Load all new template information
			$this->check_for_new();
		
			$this->scan_complete = TRUE;
		}
		
		return parent::find($conditions, $offset, $limit);
	}
	
	function check_for_new()
	{
		$templates = opendir(FCPATH.'assets/site/templates');
		while (($file = readdir($templates)) !== false) {
			if (!is_dir(FCPATH.'assets/site/templates/'.$file) && strrpos($file, '.config.php') == false && (strrpos($file, '_') === false || substr($file, 1) != '_'))
			{	
				$name = str_replace('.php', '', $file);
				
				if (!$this->exists(array('file' => $name)))
				{
					$template = $this->create(array(
						'name' => str_replace('.php', '', $file),
						'file' => str_replace('.php', '', $file)
					));
					$template->check_for_updates();
				}
			}
		}
	}
	
	function check_for_updates()
	{
		//get config
		$config = FCPATH.'assets/site/templates/'.$this->file.'.config.php';
		include($config);
		
		if (isset($template))
		{
			$this->name = $template['name'];
			$this->save();
			
			//check for modules
			
			//check for variables
			$variables = array();
			if (isset($template['variables']) && count($template['variables']))
			{
				//check each variable to see if it exists already
				foreach ($template['variables'] as $variable)
				{
					if (!$this->template_variables->exists(array('name' => $variable['name'], 'template_variable_id' => null)))
					{
						//create variable
						$var = $this->template_variable_model->create(array(
							'template_id' => $this->id,
							'type'  => isset($variable['type']) ? $variable['type'] : 'string',
							'name'  => $variable['name'],
							'label' => isset($variable['label']) ? $variable['label'] : $variable['name'],
							'value' => isset($variable['default']) ? $variable['default'] : '',
							'options' => isset($variable['options']) ? serialize($variable['options']) : ''
						));
						
						if ($variable['type'] == 'array' && $variable['variables'])
						{
							foreach ($variable['variables'] as $sub_variable) {
								$this->template_variable_model->create(array(
									'template_id' => $this->id,
									'template_variable_id' => $var->id,
									'type'  => isset($sub_variable['type']) ? $sub_variable['type'] : 'string',
									'name'  => $sub_variable['name'],
									'label' => isset($sub_variable['label']) ? $sub_variable['label'] : $sub_variable['name'],
									'value' => isset($sub_variable['default']) ? $sub_variable['default'] : '',
									'options' => isset($sub_variable['options']) ? serialize($sub_variable['options']) : ''
								));
							}
						}
					}
					else
					{
						//update variable
						$var = $this->template_variables->first(array('name' => $variable['name'], 'template_variable_id' => null));
						$var->type    = $variable['type'];
						$var->label   = isset($variable['label']) ? $variable['label'] : $variable['name'];
						$var->value   = isset($variable['default']) ? $variable['default'] : '';
						$var->options = isset($variable['options']) ? serialize($variable['options']) : '';
						$var->save();
						
						if ($variable['type'] == 'array' && $variable['variables'])
						{
							foreach ($variable['variables'] as $sub_variable) {
								
								/*$this->template_variable_model->create(array(
									'template_id' => $this->id,
									'template_variable_id' => $var->id,
									'type'  => isset($sub_variable['type']) ? $sub_variable['type'] : 'string',
									'name'  => $sub_variable['name'],
									'label' => isset($sub_variable['label']) ? $sub_variable['label'] : $sub_variable['name'],
									'value' => isset($sub_variable['default']) ? $sub_variable['default'] : '',
									'options' => isset($sub_variable['options']) ? serialize($sub_variable['options']) : ''
								));*/
							}
						}
					}
					$variables[] = $variable['name'];
				}
			}
			
			//delete any variables that have been removed
			foreach ($this->template_variables->all() as $tv) {
				if (!in_array($tv->name, $variables) && !$tv->template_variable_id) {
					$tv->destroy();
				}
			}
		}
	}
	
	function variable($name)
	{
		$variable = $this->template_variables->first(array('name' => $name));
		if ($variable->options) $variable->options = unserialize($variable->options);
		return $variable;
	}
}