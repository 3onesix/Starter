<?php

class Dashboard extends MY_Controller
{
	protected $require_login = TRUE;
	
	public function action_index()
	{
		$widgets = $this->module_widget_model->find_by_where('dashboard');
		$this->load->vars('widgets', $widgets);
		$this->load->view('admin/dashboard');
	}
}