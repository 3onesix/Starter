<?php

class Dashboard extends MY_Controller
{
	protected $require_login = TRUE;
	
	public function action_index()
	{
		$this->load->view('admin/dashboard');
	}
}