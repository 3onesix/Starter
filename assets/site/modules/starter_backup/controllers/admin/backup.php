<?php

class Backup extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('backup_model');
	}
	
	function action_index()
	{
	}
	
	function action_backup()
	{
		$this->backup_model->run();
	}
	
}