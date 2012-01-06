<?php

require_once APPPATH."third_party/jot/jot.php";

class MY_Model extends JotRecord {
	
	public $api_permissions = array();
	public $allow_api = true;
	public $api_include = array();
	
}