<?php

class Module_Screen_Model extends My_Model {
	
	function init()
	{
		$this->belongs_to('module');
	}
	
}