<?php

class Settings extends MY_Controller
{
	protected $require_login = TRUE;
	
	public function action_index($page = 0)
	{
		$data = $this->input->post('settings');
		
		if ($data) {
			foreach ($data as $key => $value) {
				setting($key, $value);
			}
			flash('notice', 'Settings have been saved.');
			redirect('admin/settings');
		}
		
		$this->load->view('admin/settings/index');
	}
}