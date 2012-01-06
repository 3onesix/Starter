<?php

class Module_File_Model extends My_Model {

	public $allow_api = false;
	
	function init()
	{
		$this->belongs_to('module');
	}
	
}