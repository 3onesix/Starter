<?php

class Page_Model extends My_Model
{
	public function init()
	{
		$this->validates('name', 'required');
		
		$this->belongs_to('page');
		$this->has_many('pages');
		
		$this->belongs_to('user');
		$this->has_many('page_variables');
		
		$this->before_save('transform_slug');
	}
	
	public function transform_slug()
	{
		$this->write_attribute('slug', strtolower(url_title($this->read_attribute('name'))));
	}
	
	public function get_full_slug()
	{
		$slug = $this->read_attribute('slug');

		return $this->page ? $this->page->full_slug.'/'.$slug : $slug;

	}
}