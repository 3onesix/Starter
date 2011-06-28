<?php

class Modules_Model extends My_Model {
	
	function init()
	{
		$this->has_many('module_screens');
	}
	
}