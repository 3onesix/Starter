<?php

class Module_Screen_Model extends My_Model {

	public $allow_api = false;
	
	function init()
	{
		$this->belongs_to('module');
	}
	
}