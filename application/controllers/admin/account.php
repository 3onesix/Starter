<?php

class Account extends My_Controller
{
	public function action_signin()
	{
		if ( $this->current_user )
		{
			redirect('admin'); 
		}
		
		$this->load->view('admin/account/signin');
	}
	
	public function action_authenticate()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		
		if ( $this->user_model->authenticate($username, $password) )
		{
			$user = array(
				'username' => $username,
				'password' => $password
			);
			
			$this->session->set_userdata('user', $user);
			
			$redirect_to = $this->session->userdata('redirect_to');
			
			if ( $redirect_to )
			{
				redirect($redirect_to);
			}
			else
			{
				redirect('admin');
			}
		}
		else
		{
			$this->session->unset_userdata('user');
			redirect('admin/signin');
		}
	}
	
	public function action_signout()
	{
		$this->session->unset_userdata('user');
		redirect('admin/signin');
	}
}