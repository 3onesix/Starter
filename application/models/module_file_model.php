<?php

class Module_File_Model extends My_Model {
	
	function init()
	{
		$this->belongs_to('module');
	}
	
}