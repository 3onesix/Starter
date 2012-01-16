<?php

class MY_Controller extends CI_Controller 
{
	protected $config_pagination = array(
		'per_page' => 10,
		'full_tag_open' => '<div id="pagination">',
		'full_tag_close' => '</div>'
	);
	private $models = array();
	
	public $current_user = NULL;
	
	protected function config_pagination() {}
	
	public function __construct() 
	{		
		parent::__construct();
		
		if (is_array($this->models))
		{
			foreach ($this->models as $m) $this->load->model($m);
		}
				
		$this->load->database();
		$this->load->library('session');
		
		save_filters();	
		
		$user = $this->session->userdata('user');
		$username = value_for_key('username', $user);
		$password = value_for_key('password', $user);
					
		if ( isset($this->require_login) && ! $this->user_model->authenticate($username, $password) )
		{
			$this->session->set_userdata('redirect_to', current_url());
			redirect('admin/signin');
		}
		
		$this->current_user = $username ? $this->user_model->first(array(
			'username' => $username
		)) : NULL;
		
		$config['per_page'] = '10'; 
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
	}
}