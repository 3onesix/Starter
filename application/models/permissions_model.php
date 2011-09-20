<?php

class Permissions_Model extends MY_Model {
	
	function init()
	{
		$this->belongs_to('role');
		$this->belongs_to('module');
	}
	
}