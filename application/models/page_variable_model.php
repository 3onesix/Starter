<?php

class Page_Variable_Model extends My_Model
{
	public function init()
	{
		$this->validates('page_id', 'required');
		$this->validates('template_id', 'required');
		$this->validates('name', 'required');
		
		$this->belongs_to('page');
	}
}