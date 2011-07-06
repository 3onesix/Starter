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
		$files = $this->backup_model->all();
		
		$this->load->view('admin/backup/index', array('files' => $files));
	}
	
	function action_backup()
	{
		$this->backup_model->run();
		
		redirect('admin/backup');
	}
	
	function action_destroy($id)
	{
		$this->backup_model->destroy($id);
		redirect('admin/backup');
	}
	
}