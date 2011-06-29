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
		$this->has_one('template');
		
		$this->before_validation('generate_slug');
	}
	
	public function generate_slug()
	{
		if ( ! $this->read_attribute('slug') )
		{
			$this->set_slug('slug', $this->read_attribute('name'));
		}
	}
	
	public function set_slug($key, $value)
	{
		$this->write_attribute($key, strtolower(url_title($value)));
	}
	
	public function get_full_slug()
	{
		$slug = $this->read_attribute('slug');

		return $this->page && $this->page->page_id > 0 ? $this->page->full_slug.'/'.$slug : $slug;
	}
	
	public function includes()
	{
		$includes = array('helper' => array(), 'stylesheet' => array(), 'model' => array());
		
		foreach ($this->page_modules->all() as $module)
		{
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
}