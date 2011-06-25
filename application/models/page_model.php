<?php

class Page_Model extends My_Model
{
	public function init()
	{
		$this->validates('name', 'required');
		
		$this->belongs_to('user');
	}
}