<?php

class Roles_Model extends MY_Model {
	
	function init()
	{
		$this->has_many('users');
		$this->has_many('permissions');
	}
	
}