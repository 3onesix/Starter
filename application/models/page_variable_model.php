<?php

class Page_Variable_Model extends My_Model
{
	public function init()
	{
		//$this->validates('page_id', 'required');
		$this->validates('name', 'required');
		
		$this->belongs_to('page');
		
		$this->before_update('store_revision');
	}
	
	public function store_revision()
	{
		$this->page_variable_revision_model->create(array(
			'page_variable_id' => $this->id,
			'value' => $this->value
		));
	}
}