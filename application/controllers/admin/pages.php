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
				if ($id != 0)
				{
					$v  = $page->page_variables->first(array('name' => $key));
					$tv = $page->template->template_variables->first(array('name' => $key));
				}
				else
				{
					$v  = $this->page_variable_model->first(array('name' => $key, 'page_id' => 0));
					$tv = $this->template_variable_model->first(array('name' => $key, 'template_id' => 0));
				}
				
				if ($tv->type == 'array') {
					if ($v)
					{
						if ($v->value != '')
						{
							$hasChanged = true;
							
							$v->value = '';
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
						$v = $this->page_variable_model->create(array(
							'page_id' => $id != 0 ? $page->id : 0,
							'name'    => $key,
							'value'   => $variable,
							'label'   => $tv->label,
							'type'    => $tv->type
						));
					}
					
					foreach ($variable as $index => $block)
					{
						
						if (isset($block['id']))
						{
							$block['id'] = explode('_', $block['id']); //block id is mashup of page_variable_id + array_index
						}
						
						foreach ($block as $v_name => $v_value)
						{
							if (!in_array($v_name, array('index', 'id')))
							{
								//check if variable is stored in block
								if ($b_v = isset($block['id']) ? $v->page_variables->first(array('page_variable_id' => $block['id'][0], 'array_index' => $block['id'][1], 'name' => $v_name)) : false )
								{
									//update variable
									if ($b_v->value != $block[$v_name])
									{
										$b_v->value       = $v_value;
										$b_v->array_index = $index;
										$b_v->save();
									}
								}
								else
								{
									//store new variable
									$this->page_variable_model->create(array(
										'page_id'          => $id != 0 ? $page->id : 0,
										'page_variable_id' => $v->id,
										'array_index'      => $index,
										'name'             => $v_name,
										'value'            => $v_value,
										'label'            => '',
										'type'             => ''
									));
								}
							}
						}
							
							
					}
				}
				else {
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
						$filename = value_for_key("name.{$key}", $_FILES['variables']);
						if ($filename)
						{
							if (!$filename) return false;
							$info   = pathinfo($filename);
							$ext 	= value_for_key('extension', $info);
											
							$this->load->helper('string');
			
							# Create file cache instance;
							
							$this->page_variable_model->set_files_cache('name', array(
								'name'  => random_string('alpha', 10).'.'.$ext,
								'type'  => value_for_key("type.{$key}", $_FILES['variables']),
								'tmp'   => value_for_key("tmp_name.{$key}", $_FILES['variables']),
								'error' => value_for_key("error.{$key}", $_FILES['variables']),
								'size'  => value_for_key("size.{$key}", $_FILES['variables']),
							));
						}
						else {
							unset($this->page_variable_model->files_cache_local);
						}
						$this->page_variable_model->create(array(
							'page_id' => $id != 0 ? $page->id : 0,
							'name'    => $key,
							'value'   => $variable,
							'label'   => $tv->label,
							'type'    => $tv->type
						));
					}
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