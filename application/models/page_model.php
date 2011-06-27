<?php

class Page_Model extends My_Model
{
	public function init()
	{
		$this->validates('name', 'required');
		// $this->validates('slug', 'required');

		
		$this->belongs_to('page');
		$this->has_many('pages');
		
		$this->belongs_to('user');
		$this->has_many('page_variables');
		
		$this->before_validation('transform_slug');
	}
	
	public function transform_slug()
	{
		if ( ! $this->has_attribute('slug') )
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
}