<?php

class Template_Variable_Model extends My_Model
{

	public $allow_api = false;
	
	public function init()
	{
		$this->belongs_to('template');
		$this->has_many('template_variables');
	}
}