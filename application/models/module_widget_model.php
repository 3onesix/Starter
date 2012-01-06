<?php

class Module_Widget_Model extends My_Model {
	
	function init()
	{
		$this->belongs_to('module');
	}
	
}