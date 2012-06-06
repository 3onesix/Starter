<?php

class Page_Variable_Revision_Model extends My_Model
{
	public function init()
	{
		$this->enable_actions = false;
	
		$this->validates('page_variable_id', 'required');
		$this->validates('value', 'required');
		
		$this->belongs_to('page_variable');
	}
}