<?php

class Template_Model extends My_Model
{
	public function init()
	{
		$this->validates('name', 'required');
		
		$this->has_many('pages');
		$this->has_many('template_variables');
	}
}