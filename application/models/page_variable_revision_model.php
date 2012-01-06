<?php

class Page_Variable_Revision_Model extends My_Model
{

	public $allow_api = false;
	
	public function init()
	{
		$this->validates('page_variable_id', 'required');
		$this->validates('value', 'required');
		
		$this->belongs_to('page_variable');
	}
}