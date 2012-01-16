<?php

class Users extends MY_Controller
{
    protected $require_login = TRUE;
    
    public function __construct()
    {
    	parent::__construct();
    	$this->load->vars('section', 'users');
    }
    
    public function action_index()
    {
    	$users = $this->user_model->all(array('order' => 'last_name'));
    	
    	$this->load->view('admin/users/index', array(
    	    'users' => $users
    	));
    }
    
    public function action_new()
    {
    	$this->load->view('admin/users/new', array('user' => flash_jot('user')));
    }
    
    public function action_create()
    {
    	$data = $this->input->post('user');
    	$user = $this->user_model->create($data);
    	
    	if ( $user->errors() )
    	{
			flash('user', $user);
			redirect('admin/users/new');
    	}
    	else {
    		flash('notice', 'User successfully created.');
       		redirect('admin/users');
    	}
    }
    
    public function action_edit($id)
    {
    	$this->load->view('admin/users/edit', array(
    	    'user' => flash_jot('user', $id)
    	));
    }
    
    public function action_update($id)
    {
    	$data = $this->input->post('user');
    	$user = $this->user_model->first_by_id($id);

		$user->update_attributes($data);
		
		if ( $user->errors() )
		{
			flash('user', $user);
			redirect('admin/users/edit/'.$id);
			return;
		}
		else 
		{
			flash('notice', 'User was updated successfully.');	
		}
				
		if ( $user->is_me() )
		{
			set_current_user($user);
		}
		
		redirect('admin/users');
    }
    
    public function action_destroy($id)
    {

    }
}