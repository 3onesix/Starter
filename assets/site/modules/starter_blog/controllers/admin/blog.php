<?php

class Blog extends My_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	function action_index()
	{
		echo 'hello!';
	}
	
}