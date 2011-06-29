<?php

class Template_Model extends My_Model
{
	public function init()
	{
		$this->validates('name', 'required');
		
		$this->has_many('pages');
		$this->has_many('template_variables');
	}
	
	function check_for_new()
	{
		$templates = opendir('templates');
		while (($file = readdir($templates)) !== false) {
			if (!is_dir($file) && strrpos($file, '.config.php') == false)
			{	
				$name = str_replace('.php', '', $file);
				
				if (!$this->exists(array('name' => $name)))
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
		$config = 'templates/'.$this->file.'.config.php';
		include($config);
		
		if ($template)
		{
			$this->name = $template['name'];
			
			//check for modules
			
			//check for variables
			if (isset($template['variables']) && count($template['variables']))
			{
				//check each variable to see if it exists already
				foreach ($template['variables'] as $variable)
				{
					if (!$this->template_variables->exists(array('name' => $variable['name'])))
					{
						$this->template_variable_model->create(array(
							'template_id' => $this->id,
							'type'  => isset($variable['type']) ? $variable['type'] : 'string',
							'name'  => $variable['name'],
							'label' => isset($variable['label']) ? $variable['label'] : $variable['name']
						));
					}
				}
			}
			$this->save();
		}
	}
}