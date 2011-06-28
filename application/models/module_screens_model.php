<?php

class Module_Screens_Model extends My_Model {
	
	function init()
	{
		$this->belongs_to('module');
	}
	
}