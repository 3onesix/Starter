<?php

class Pages extends MY_Controller
{
	protected $require_login = TRUE;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('pages');
		
		$ga = $this->module_model->first(array('simple_name' => 'starter_googleanalytics'));
		if ($ga)
		{
			$this->load->helper('googleanalytics');
			$this->load->vars(array('ga' => $ga));
		}
	}
	
	public function action_index($page = 0)
	{		
		$this->db->order_by('name');
		$pages = $this->page_model->find(array('page_id'=>-1), 0, 0);
		$this->load->vars(array('has_site_variables' => $this->template_variable_model->exists(array('template_id' => 0))));
		
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
		if ($id != 0)
		{
			if ($this->page_model->first($id)->template_id)
			{
				$this->page_model->first($id)->template->check_for_updates();
			}
		}
		else
		{
			$this->template_model->check_for_site_updates();
		}
		
		$templates = array('');
		foreach($this->template_model->all() as $template) $templates[$template->id] = $template->name;
		$this->load->vars('templates', $templates);
		
		if ($id != 0)
		{
			$this->load->vars('page', flash_jot('page', $id));
			$this->load->vars(array('is_site_variables' => false));
			$this->load->vars('title', 'Edit Page : '.flash_jot('page', $id)->name.'');
		}
		else {
			$this->load->vars('page', flash_jot('page', $id));
			$this->load->vars('is_site_variables', true);
			$this->load->vars('title', 'Edit Site Variables');
		}
		$this->load->view('admin/pages/edit');
	}
	
	public function action_update($id)
	{
		if ($id != 0)
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
			foreach ($page->template->required_modules as $module)
			{
				$module = $this->module_model->first_by_simple_name($module);
				if ($module && !$this->page_module_model->exists(array('page_id' => $page->id, 'module_id' => $module->id)))
				{
					$this->page_module_model->create(array(
						'page_id' => $page->id,
						'module_id' => $module->id
					));
				}
			}
		}
		
		//update variables
		$variables = $this->input->post('variables');
		if ($variables)
		{
			foreach ($variables as $key=>$variable)
			{
				$hasChanged = false;
				
				//getVariableObject
				if ($id != 0)
				{
					$tv = $page->template->template_variables->first(array('name' => $key, 'template_variable_id' => null));
				}
				else
				{
					$tv = $this->template_variable_model->first(array('name' => $key, 'template_id' => 0, 'template_variable_id' => null));
				}
				
				$variableInstance = getVariableObject($tv->type, $tv, 'variables['.$tv->name.']', $id);
				if ($variableInstance)
				{
					$variableInstance->save();
				}
			}
		}
				
		if ( $id != 0 && $page->errors() )
		{
			flash('page', $page);
			redirect('admin/pages/edit/'.$id);
		}
		else
		{
			flash('notice', ($id != 0 ? 'Page was' : 'Site variables were').' updated successfully.');
		}
		
		redirect('admin/pages');
	}
	
	public function action_destroy($id)
	{
		$page = $this->page_model->first($id);
		
		if ( $page )
		{
			$page->destroy();
			flash('notice', 'Page was successfully deleted.');
			redirect('admin/pages');
		}
	}
}