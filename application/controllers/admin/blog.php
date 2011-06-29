<?php

class Blog extends My_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->module 				= array(
			'name'				=> 'Blog',
			'simple_name'		=> 'blog',
			'settings'			=> array(
				array(
					'label' 				=> 'Include Short Body Field',
					'key'					=> 'include_short',
					'type'					=> 'checkbox'
				)
			),
			'files'				=> array(
				array(
					'type'					=> 'controller',
					'name'					=> 'blog.php',
					'include_on_page'		=> 0
				),
				array(
					'type'					=> 'model',
					'name'					=> 'blog_model.php',
					'include_on_page'		=> 1
				)
			),
			'screens'			=> array(
				array(
					'name'					=> 'Blog',
					'url'					=> 'blog'
				)
			)
		);
	}
	
	function install()
	{
		//make sure module isn't installed
		if ($this->module_model->exists(array('simple_name' => $this->module['simple_name']))) {
			echo 'Already installed';
			return true;
		}
		
		//add module
		$module = $this->module_model->create(array(
			'name' => $this->module['name'],
			'simple_name' => $this->module['simple_name']
		));
		
		//add settings
		if (isset($this->module['settings']) && count($this->module['settings']))
		{
			foreach ($this->module['settings'] as $setting)
			{
				if (isset($setting['key']) && isset($setting['type']))
				{
					$this->setting_model->create(array(
						'module_id' => $module->id,
						'label' => isset($setting['label']) ? $setting['label'] : $setting['key'],
						'key' => $setting['key'],
						'type' => $setting['type']
					));
				}
			}
		}
		
		//add files
		if (isset($this->module['files']) && count($this->module['files']))
		{
			foreach ($this->module['files'] as $file)
			{
				if (isset($file['type']) && isset($file['name']))
				{
					$this->module_file_model->create(array(
						'module_id' => $module->id,
						'type' => $file['type'],
						'name' => $file['name'],
						'include_on_page' => isset($file['include_on_page']) && $file['include_on_page'] ? 1 : 0
					));
				}
			}
		}
		
		//add screens
		if (isset($this->module['screens']) && count($this->module['screens']))
		{
			foreach ($this->module['screens'] as $screen)
			{
				if (isset($screen['name']) && isset($screen['url']))
				{
					$this->module_screen_model->create(array(
						'module_id' => $module->id,
						'name' => $screen['name'],
						'url' => $screen['url']
					));
				}
			}
		}
	}
	
}