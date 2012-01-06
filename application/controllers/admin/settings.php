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
         
        $this->load->vars('title', 'Settings');
        $this->load->view('admin/settings/index');
    }
     
    public function action_modules_index()
    {
        $this->load->vars(array(
            'title'  => 'Manage Modules',
            'modules' => $this->module_model->find()
        ));
        $this->load->view('admin/settings/modules/manage');
    }
     
    public function action_modules_install($folder = null)
    {
        $folder = FCPATH.'assets/site/modules/'.$folder;
        if (file_exists($folder.'/config.php'))
        {
            include($folder.'/config.php');
            if (isset($module) && is_array($module))
            {
                //make sure module isn't installed
                if ($this->module_model->exists(array('simple_name' => $module['simple_name']))) {
                    flash('notice', $module['name'].' has already been installed.');
                    redirect('admin/settings/modules');
                }
                if ($this->input->get('install') == 'true')
                {
                    //add module
                    $m = $this->module_model->create(array(
                        'name' => $module['name'],
                        'simple_name' => $module['simple_name'],
                        'version' => $module['version'],
                        'description' => isset($module['description']) ? $module['description'] : ''
                    ));
             
                    //add settings
                    if (isset($module['settings']) && count($module['settings']))
                    {
                        foreach ($module['settings'] as $setting)
                        {
                            if (isset($setting['key']) && isset($setting['type']))
                            {
                                $this->setting_model->create(array(
                                    'module_id' => $m->id,
                                    'label' => isset($setting['label']) ? $setting['label'] : $setting['key'],
                                    'key' => $setting['key'],
                                    'type' => $setting['type']
                                ));
                            }
                        }
                    }
             
                    //add files
                    if (isset($module['files']) && count($module['files']))
                    {
                        foreach ($module['files'] as $file)
                        {
                            if (isset($file['type']) && isset($file['name']))
                            {
                                $this->module_file_model->create(array(
                                    'module_id' => $m->id,
                                    'type' => $file['type'],
                                    'name' => $file['name'],
                                    'include_on_page' => isset($file['include_on_page']) && $file['include_on_page'] ? 1 : 0
                                ));
                            }
                        }
                    }
             
                    //add screens
                    if (isset($module['screens']) && count($module['screens']))
                    {
                        foreach ($module['screens'] as $screen)
                        {
                            if (isset($screen['name']) && isset($screen['url']))
                            {
                                $this->module_screen_model->create(array(
                                    'module_id' => $m->id,
                                    'name' => $screen['name'],
                                    'url' => $screen['url']
                                ));
                            }
                        }
                    }
                    
                   //add widgets
					if (isset($module['widgets']) && count($module['widgets']))
					{
						foreach ($module['widgets'] as $widget)
						{
							if (isset($widget['name']) && isset($widget['view']))
							{
								if (!isset($widget['where'])) $widget['where'] = 'dashboard';
								
								$this->module_widget_model->create(array(
									'module_id' => $m->id,
									'name' => $widget['name'],
									'view' => $widget['view'],
									'where' => $widget['where']
								));
							}
						}
					}
                     
                    if (isset($module['install']))
                    {
                        $this->load->helper('jot_migrations');
                        ob_start();
                        include($folder.'/'.$module['install']);
                        ob_clean();
                    }
                     
                    flash('notice', $module['name'].' has been installed.');
                     
                    if (isset($module['settings']) && count($module['settings']))
                    {
                        redirect('admin/settings/modules/'.$m->simple_name);
                    }
                    else
                    {
                        redirect('admin/settings/modules');
                    }
                }
                else
                {
                    $this->load->vars(array(
                        'title'  => 'Install Module : '.$module['name'],
                        'module' => $module
                    ));
                    $this->load->view('admin/settings/modules/install');
                }
            }
        }
    }
    
    public function action_modules_update($module = null)
    {
    	$module = $this->module_model->first_by_simple_name($module);
		$folder = 'assets/site/modules/'.$module->simple_name;
		
		if (!$module->has_update) redirect('admin/settings/modules');
		
    	if (isset($module->current_config['update']) && file_exists($folder.'/'.$module->current_config['update']))
    	{
		    $this->load->helper('jot_migrations');
		    ob_start();
		    include($folder.'/'.$module->current_config['update']);
		    ob_clean();
    	}
    	
		//update module
		$m = $this->module_model->update($module->id, array(
		   'name' => $module->current_config['name'],
		   'simple_name' => $module->current_config['simple_name'],
		   'version' => $module->current_config['version'],
		   'description' => isset($module->current_config['description']) ? $module->current_config['description'] : ''
		));
		
		//update settings
		if (isset($module->current_config['settings']) && count($module->current_config['settings']))
		{
			$settings = array();
			foreach ($module->current_config['settings'] as $setting)
			{
				if (isset($setting['key']) && isset($setting['type']))
				{
					//check to see if setting exists
					if ($pre = $this->setting_model->first(array(
						'module_id' => $m->id,
						'key' => $setting['key']
					)))
					{
						$pre->label = isset($setting['label']) ? $setting['label'] : $setting['key'];
						$pre->type  = $setting['type'];
						$pre->save();
						
						$settings[] = $setting['key'];
					}
					else
					{
						$this->setting_model->create(array(
						   'module_id' => $m->id,
						   'label' => isset($setting['label']) ? $setting['label'] : $setting['key'],
						   'key' => $setting['key'],
						   'type' => $setting['type']
						));
						
						$settings[] = $setting['key'];
					}
				}
			}
			$stored = $this->setting_model->all(array('module_id' => $m->id));
			foreach ($stored as $s)
			{
				if (!in_array($s->key, $settings))
				{
					$s->destroy();
				}
			}
		}
		
		//update files
		$this->db->where('module_id', $m->id)->delete('module_files');
		if (isset($module->current_config['files']) && count($module->current_config['files']))
		{
		   foreach ($module->current_config['files'] as $file)
		   {
		       if (isset($file['type']) && isset($file['name']))
		       {
		           $this->module_file_model->create(array(
		               'module_id' => $m->id,
		               'type' => $file['type'],
		               'name' => $file['name'],
		               'include_on_page' => isset($file['include_on_page']) && $file['include_on_page'] ? 1 : 0
		           ));
		       }
		   }
		}
		 
		//update widgets
		$this->db->where('module_id', $m->id)->delete('module_widgets');
		if (isset($module->current_config['widgets']) && count($module->current_config['widgets']))
		{
			foreach ($module->current_config['widgets'] as $widget)
			{
				if (isset($widget['name']) && isset($widget['view']))
				{
					if (!isset($widget['where'])) $widget['where'] = 'dashboard';
					
					$this->module_widget_model->create(array(
						'module_id' => $m->id,
						'name' => $widget['name'],
						'view' => $widget['view'],
						'where' => $widget['where']
					));
				}
			}
		}
		
		//update screens
		if (isset($module->current_config['screens']) && count($module->current_config['screens']))
		{
		   foreach ($module->current_config['screens'] as $screen)
		   {
		       if (isset($screen['name']) && isset($screen['url']))
		       {
		           /*$this->module_screen_model->create(array(
		               'module_id' => $m->id,
		               'name' => $screen['name'],
		               'url' => $screen['url']
		           ));*/
		       }
		   }
		}
    	
    	flash('notice', $module->name.' has been updated.');
    	redirect('admin/settings/modules');
    }
     
    public function action_modules($id = null)
    {
        if ($id === null) $this->action_modules_index();
        elseif ($id == 'install' && $this->uri->segment(5)) $this->action_modules_install($this->uri->segment(5));
        elseif ($id == 'update' && $this->uri->segment(5)) $this->action_modules_update($this->uri->segment(5));
        else {
            $module = $this->module_model->first(array('simple_name' => $id));
            if ($module->settings->count() == 0) redirect('admin/settings');
             
            $data = $this->input->post('setting');
             
            if ($data) {
                foreach ($data as $key => $value) {
                    $setting = $this->setting_model->first($key);
                    $setting->value = $value;
                    $setting->save();
                }
                flash('notice', 'Settings have been saved.');
                redirect('admin/settings/modules/'.$module->simple_name);
            }
             
            $this->load->vars(array(
                'module' => $module,
                'title'  => 'Module Settings : '.$module->name
            ));
            $this->load->view('admin/settings/module');
        }
    }
     
    public function action_users($id = null) {
        if ($id == null)
        {
            $users = $this->user_model->all(array('order' => 'last_name'));
            $this->load->view('admin/settings/users', array(
                'users' => $users
            ));
        }
        elseif ($id == 'new')
        {
        	if ($userinfo = $this->input->post('user'))
        	{
				$data = array(
				    'first_name' => $userinfo['first_name'],
				    'last_name'  => $userinfo['last_name'],
				    'username'   => $userinfo['username'],
				    'email'      => $userinfo['email'],
				    'password'   => md5($userinfo['password'])
				);
				$this->db->insert('users', $data);
				
				flash('notice', 'User successfully created.');
				redirect('admin/settings/users');
        	}
	        $this->load->view('admin/settings/new_user');
        }
        else
        {
            $user = $this->user_model->first_by_id($id);
            if (!$user) {
                redirect('admin/settings/users');
            }
             
            if ($userinfo = $this->input->post('user'))
            {
                $password_reset = false;
                 
                $data = array(
                    'first_name' => $userinfo['first_name'],
                    'last_name'  => $userinfo['last_name'],
                    'username'   => $userinfo['username'],
                    'email'      => $userinfo['email']
                );
                 
                if (isset($userinfo['password']) && isset($userinfo['confirm_password']) && $userinfo['password'] == $userinfo['confirm_password'] && $userinfo['password'])
                {
                    $data['password'] = md5($userinfo['password']);
                    $password_reset = true;
                }
                 
                $this->db->update('users', $data, array(
                    'id' => $user->id
                ));
                 
                if ($password_reset) {
                    $this->session->set_flashdata('notice', 'Password changed.');
                    $this->session->unset_userdata('user');
                }
                redirect($password_reset ? 'admin/signin' : 'admin/settings/users');
            }
             
            $this->load->view('admin/settings/edit_user', array(
                'user' => $user
            ));
        }
    }
}