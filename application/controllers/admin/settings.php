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
	
	public function action_modules($id = null)
	{
		if ($id === null) $this->action_modules_index();
		elseif ($id == 'install' && $this->uri->segment(5)) $this->action_modules_install($this->uri->segment(5));
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
}