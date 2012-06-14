<?php

class Page_Variable_Model extends My_Model
{
	public function init()
	{
		//$this->validates('page_id', 'required');
		$this->validates('name', 'required');
		
		$this->belongs_to('page');
		$this->has_many('page_variables');
		
		$this->before_update('store_revision');
		
		$this->has_attached_file('file', array(
			'url'  => 'assets/site/uploads/{filename}',
			'path' => 'assets/site/uploads/{filename}'
		));
	}
	
	public function store_revision()
	{
		if ( ! $this->page_variable_id )
		{
			$this->page_variable_revision_model->create(array(
				'page_variable_id' => $this->id,
				'value' => $this->value
			));
		}
	}
	
	protected function _can_send_action()
	{
		return $this->read_attribute('page_id') == '0';
	}
}