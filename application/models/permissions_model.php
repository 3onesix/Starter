<?php

class Permissions_Model extends MY_Model {

	public $allow_api = false;
	
	function init()
	{
		$this->belongs_to('role');
		$this->belongs_to('module');
	}
	
}