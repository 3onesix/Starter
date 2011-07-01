<?php

class Articles extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function action_index()
	{
		echo 'Article!!!!';
	}
}