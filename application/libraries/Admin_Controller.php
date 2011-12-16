<?php

class Admin_Controller extends MY_Controller {
	
	protected $require_login 	= TRUE;

	public $module_name			= '';
	public $controller_path 	= '';
	public $content_singular 	= '';
	public $content_plural 		= '';
	public $content_table_name	= '';
	public $content_model_name	= '';
	
	public function __construct() 
	{
		parent::__construct();
		
		if ($this->module_name)
		{
			$this->module = $this->module_model->first(array('simple_name' => $this->module_name));
		}
		
		//load models
		if ($this->content_model_name) $this->load->model($this->content_model_name);
		
		//check properties
		if (!$this->content_table_name)
		{
			$this->content_table_name = $this->model()->singular_table_name();
		}
		
		//load variables
		$this->load->vars(array(
			'controller_path' 	=> $this->controller_path,
			'content_singular'	=> $this->content_singular,
			'content_plural'	=> $this->content_plural
		));
	}
	
	private function model()
	{
		eval('$model = $this->'.$this->content_model_name.';');
		return $model;
	}
	
	public function action_index($title = null, $notice = null)
	{
		//load page of items
		$per_page		= 20;
		$item_count 	= $this->model()->count();
		$pages			= $item_count / $per_page;
		$current_page	= $this->input->get('page') ? $this->input->get('page') : 1;
		$items			= $this->model()->find(array('page' => $current_page, 'limit' => $per_page));
		
		//hand to view
		$this->load->vars(array(
			'notice'		=> $notice ? $notice : flash('notice'),
			'item_count'	=> $item_count,
			'per_page'		=> $per_page,
			'pages'			=> $pages,
			'current_page'	=> $current_page,
			'title'			=> $title ? $title : ucfirst($this->content_plural),
			'items'			=> $items
		));
		
		//load view
		$this->load->view($this->controller_path.'/index');
	}
	
	public function action_new($title = null)
	{
		$this->load->view($this->controller_path.'/new', array(
			'title'	=> $title ? $title : 'New '.ucfirst($this->content_singular).' | '.ucfirst($this->content_plural),
			$this->content_singular => flash_jot($this->content_singular)
		));
	}
	
	public function action_create()
	{
		//get data and save it
		$data 		= $this->input->post($this->content_table_name);
		$item 		= $this->model()->create($data);
		
		if ( $item->errors() ) //if any error happened (validation, etc.), toss back to /new
		{
			flash($this->content_singular, $item);
			redirect($this->controller_path.'/new');
		}
		else //no errors? okay, head back to /index
		{
			flash('notice', ucfirst($this->content_singular).' was added successfully.');
			redirect($this->controller_path);
		}
	}
	
	public function action_edit($id, $title = null)
	{
		$this->load->vars(array(
			'title'	=> $title ? $title : 'Edit '.ucfirst($this->content_singular).' | '.ucfirst($this->content_plural),
			$this->content_singular => flash_jot($this->content_singular, $id)
		));
		$this->load->view($this->controller_path.'/edit');
	}
	
	public function action_update($id)
	{
		$data = $this->input->post($this->content_table_name);
		$item = $this->model()->update($id, $data);
				
		if ( $item->errors() ) //if any error happened (validation, etc.), toss back to /edit/:id
		{
			flash($this->content_singular, $item);
			redirect($this->controller_path.'/edit/'.$id);
		}
		else //no errors? okay, head back to /index
		{
			flash('notice', ucfirst($this->content_singular).' was updated successfully.');
		}
		
		redirect($this->controller_path);
	}
	
	public function action_destroy($id)
	{
		$item = $this->model()->first($id);
		
		if ( $item )
		{
			$item->destroy();
			flash('notice', ucfirst($this->content_singular).' was successfully deleted.');
		}
		redirect($this->controller_path);
	}
	
}