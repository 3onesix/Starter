<?php

class Account extends My_Controller
{
	public function action_signin()
	{
		if ( $this->current_user )
		{
			redirect('admin'); 
		}
		
		$this->load->view('admin/account/signin', array(
			'notice' => $this->session->flashdata('notice'), 
			'error' => $this->session->flashdata('error')
		));
	}
	
	public function action_authenticate()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		
		if ( $user = $this->user_model->authenticate($username, $password) )
		{
			set_current_user($user);
			
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
			flash('error', 'Username and/or password is incorrect.');
			redirect('admin/signin');
		}
	}
	
	public function action_signout()
	{
		$this->session->unset_userdata('user');
		redirect('admin/signin');
	}
	
	public function action_forgot($code = null)
	{
		if ($code)
		{
			$user = $this->user_model->first_by_forgot_code($code);
			
			if ($user)
			{
				$this->load->view('admin/account/reset', array(
					'notice' => $this->session->flashdata('notice'), 
					'error' => $this->session->flashdata('error'), 
					'user' => $user
				));
			}
			else
			{
				$this->session->set_flashdata('error', 'Invalid reset code.');
				redirect('admin/signin');
			}
		}
		else
		{
			$this->load->view('admin/account/forgot', array(
				'notice' => $this->session->flashdata('notice'), 
				'error' => $this->session->flashdata('error')
			));
		}
	}
	
	public function action_forgot_process() 
	{
		$email = $this->input->post('email');
		
		if ( $user = $this->user_model->first_by_email($email) )
		{
			//create code
			$code = md5($this->config->item('starter_product_name').time());
			$this->db->update('users', array('forgot_code' => $code), array('id' => $user->id));
			
			//create url
			$url  = site_url('admin/forgot_password/'.$code);
			
			//email
			mail($user->email, 'Password reset from '.$this->config->item('starter_product_name'), 'Your username is '.$user->username.'. To reset your password, click the link below: '."\n".$url);
			
			flash('notice', 'Check your email for a reset link.');
			redirect('admin/forgot_password');
		}
		else
		{
			flash('error', 'Email address not found.');
			redirect('admin/forgot_password');
		}
	}
	
	public function action_reset_process($code) 
	{
		$user = $this->user_model->first_by_forgot_code($code);
		
		if ($user)
		{
			$password         = $this->input->post('password');
			$confirm_password = $this->input->post('confirm');
			
			if ($password == $confirm_password)
			{
				$this->db->update('users', array('password' => md5($password)), array('id' => $user->id));
				
				flash('notice', 'Your password has been reset.');
				redirect('admin/signin');
			}
			else
			{
				flash('error', 'Password and confirm password must match');
				redirect('admin/forgot_password/'.$code);
			}
		}
		else
		{
			flash('error', 'Invalid reset code.');
			redirect('admin/signin');
		}
	}
}