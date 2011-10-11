<?php

class Page_Model extends My_Model
{
	public function init()
	{
		$this->validates('name', 'required');
		$this->validates('slug', 'required');
		
		$this->belongs_to('page');
		$this->has_many('pages');
		
		$this->belongs_to('user');
		$this->has_many('page_variables');
		$this->has_many('page_modules');
		$this->belongs_to('template');
		
		$this->before_validation('generate_slug');
	}
	
	public function generate_slug()
	{
		if ( ! $this->read_attribute('slug') )
		{
			$this->set_slug('slug', $this->read_attribute('name'));
		}
	}
	
	function variable($name, $value = null)
	{
		if ($value === null)
		{
			if ($this->template_id && $this->page_variables->exists(array('name' => $name)))
			{
				$variable = $this->page_variables->first(array('name' => $name));
				
				if ($variable->type == 'array' && $variable->value == '')
				{
					$blocks = $variable->page_variables->all(array('order' => 'array_index'));
					$array = array();
					foreach ($blocks as $block)
					{
						if (!isset($array[$block->array_index])) $array[$block->array_index] = array();
						$array[$block->array_index][$block->name] = $block->value;
					}
					return serialize($array);
				}
				else
				{
					return $variable->value;
				}
			}
			return null;
		}
		else
		{
			if ($this->template_id)
			{
				if ($this->page_variables->exists(array('name' => $name)))
				{
					$variable = $this->page_variables->first(array('name' => $name));
					$variable->value = $value;
					$variable->save();
				}
				else
				{
					$this->page_variable_model->create(array(
						'page_id' => $this->id,
						'name' => $name,
						'value' => $value
					));
				}
			}
		}
	}
	
	public function set_slug($key, $value)
	{
		$this->write_attribute($key, strtolower(url_title($value)));
	}
	
	public function get_full_slug()
	{
		$slug = $this->read_attribute('slug');

		return $this->page && $this->page_id > 0 ? $this->page->full_slug.'/'.$slug : $slug;
	}
	
	public function has_module($module)
	{
		$module = $this->module_model->first(array('simple_name' => $module));
		
		if (!$module) return false;
		return $this->page_modules->exists(array('module_id' => $module->id));
	}
	
	public function includes()
	{
		$includes = array('helper' => array(), 'stylesheet' => array(), 'model' => array());
		
		foreach ($this->page_modules->all() as $module)
		{
			$module = $module->module;
			foreach ($module->module_files->all(array('include_on_page' => 1)) as $file)
			{
				switch ($file->type)
				{
					case 'helper':
						$includes['helper'][] = $file->name;
					break;
					case 'stylesheet':
						$includes['stylesheet'][] = $file->name;
					break;
					case 'model':
						$includes['model'][] = $file->name;
					break;
				}
			}
		}
		
		return $includes;
	}
	
	public function variables()
	{
		$variables = $this->page_variables->all(array('page_variable_id' => null));
		$array = array();
		foreach ($variables as $variable)
		{
			$array[$variable->name] = $variable->type == 'array' ? serialize($this->variable($variable->name)) : $this->variable($variable->name);
		}
		return $array;
	}
}