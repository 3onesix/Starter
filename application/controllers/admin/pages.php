<?php

class Pages extends MY_Controller
{
	protected $require_login = TRUE;
	
	public function action_index($page = 0)
	{
		$this->pagination->base_url = site_url('admin/pages');
		$this->pagination->total_rows = $this->page_model->count();
								
		$this->db->order_by('updated_at', 'desc');
		$pages = $this->page_model->find(NULL, $page);
		
		$this->load->vars('notice', flash('notice'));
		$this->load->vars('pages', $pages);
		$this->load->view('admin/pages/index');
	}
	
	public function action_new()
	{				
		$this->load->view('admin/pages/new', array('page' => flash_jot('page')));
	}
	
	public function action_create()
	{
		$data = $this->input->post('page');
		$data['user_id'] = $this->current_user->id;
		$page = $this->page_model->create($data);	
				
		if ( $page->errors() )
		{
			flash('page', $page);
			redirect('admin/pages/new');
		}
		else
		{
			flash('notice', 'Page was created successfully.');
			redirect('admin/pages');
		}
	}

	public function action_edit($id)
	{
		$this->load->vars('page', flash_jot('page', $id));	
		$this->load->view('admin/pages/edit');
	}
	
	public function action_update($id)
	{
		$data = $this->input->post('page');
		$data['user_id'] = $this->current_user->id;
		$page = $this->page_model->update($id, $data);
				
		if ( $page->errors() )
		{
			flash('page', $page);
			redirect('admin/pages/edit/'.$id);
		}
		else
		{
			flash('notice', 'Page was updated successfully.');
		}
		
		redirect('admin/pages');
	}
	
	public function action_destroy($id)
	{
		$page = $this->page_model->first($id);
		
		if ( $page )
		{
			$page->destroy();
			flash('notice', 'Page was successfully destroy');
			redirect('admin/pages');
		}
	}
}