<?php

class Roles_Model extends MY_Model {

	public $allow_api = false;
	
	function init()
	{
		$this->has_many('users');
		$this->has_many('permissions');
	}
	
}