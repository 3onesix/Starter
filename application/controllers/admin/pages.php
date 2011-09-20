<?php

class Pages extends MY_Controller
{
	protected $require_login = TRUE;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('pages');
	}
	
	public function action_index($page = 0)
	{		
		$this->db->order_by('name');
		$pages = $this->page_model->find(array('page_id'=>-1), 0, 0);
		
		$templates = array('');
		foreach($this->template_model->all() as $template) $templates[$template->id] = $template->name;		
		$this->load->vars('templates', $templates);
		
		$this->load->vars('notice', flash('notice'));
		$this->load->vars('pages', $pages);
		$this->load->vars('title', 'Pages');
		$this->load->view('admin/pages/index');
	}
	
	public function action_new()
	{
		$templates = array('');
		foreach($this->template_model->all() as $template) $templates[$template->id] = $template->name;
		$this->load->vars('templates', $templates);	
				
		$parents = page_hierarchal_spaces($this->page_model->find(array('page_id'=>-1), 0, 0));
				
		$this->load->vars('parents', $parents);
		$this->load->vars('title', 'New Page');
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
			redirect('admin/pages/edit/'.$page->id);
		}
	}

	public function action_edit($id)
	{	
		if ($this->page_model->first($id)->template_id)
		{
			$this->page_model->first($id)->template->check_for_updates();
		}
		
		$templates = array('');
		foreach($this->template_model->all() as $template) $templates[$template->id] = $template->name;
		$this->load->vars('templates', $templates);
				
		$this->load->vars('page', flash_jot('page', $id));
				
		$this->load->vars('title', 'Edit Page : '.flash_jot('page', $id)->name.'');	
		$this->load->view('admin/pages/edit');
	}
	
	public function action_update($id)
	{
		$data = $this->input->post('page');
		$data['user_id'] = $this->current_user->id;
		$page = $this->page_model->update($id, $data);
		
		//update modules
		$modules = $this->input->post('modules');
		$this->db->where('page_id', $page->id)->delete('page_modules');
		if ($modules)
		{
			foreach ($modules as $key=>$value)
			{
				$this->page_module_model->create(array(
					'page_id' => $page->id,
					'module_id' => $key
				));
			}
		}
		
		//update variables
		$variables = $this->input->post('variables');
		if ($variables)
		{
			foreach ($variables as $key=>$variable)
			{
				$hasChanged = false;
				$v  = $page->page_variables->first(array('name' => $key));
				$tv = $page->template->template_variables->first(array('name' => $key));
				if ($v)
				{
					if ($v->value != $variable)
					{
						$hasChanged = true;
						
						$v->value = $variable;
					}
					if ($tv->label != $v->label || $tv->type != $v->type)
					{
						$hasChanged = true;
						
						$v->label = $tv->label;
						$v->type  = $tv->type;
					}
					if ($hasChanged)
					{
						$v->save();
					}
				}
				else
				{
					$this->page_variable_model->create(array(
						'page_id' => $page->id,
						'name'    => $key,
						'value'   => $variable,
						'label'   => $tv->label,
						'type'    => $tv->type
					));
				}
			}
		}
				
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