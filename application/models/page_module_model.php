<?php

class Page_Module_Model extends My_Model
{

	public $allow_api = false;
	
	public function init()
	{
		$this->belongs_to('page');
		$this->belongs_to('module');
	}
}