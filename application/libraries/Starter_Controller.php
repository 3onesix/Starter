<?php

class Starter_Controller extends MY_Controller {
	
	public function __construct() 
	{
		parent::__construct();
		
		$this->load->model('page_model');
		$this->load->model('module_model');
		
		if (isset($this->modules))
		{
			foreach ($this->modules as $module)
			{
				$module = $this->module_model->first_by_simple_name($module);
				if ($module)
				{
					foreach ($module->module_files->all(array('type' => 'model')) as $model)
					{
						$this->load->model(str_replace('.php', '', $model->name));
					}
					foreach ($module->module_files->all(array('type' => 'helper')) as $helper)
					{
						$this->load->helper(str_replace('.php', '', $helper->name));
					}
				}
			}
		}
		
		if (isset($this->page))
		{
			$this->page = $this->page_model->first_by_slug('driver-application');
			
			$includes = $this->page->includes();
			if (count($includes['helper']))
			{
				foreach ($includes['helper'] as $helper)
				{
					$this->load->helper(str_replace('.php', '', $helper));
				}
			}
			if (count($includes['model']))
			{
				foreach ($includes['model'] as $model)
				{
					$this->load->model(str_replace('.php', '', $model));
				}
			}
			
			if ($this->page)
			{
				$this->load->vars('page', $this->page);
				$this->load->vars($this->page->variables);
			}
		}
		
		if ($this->page_variable_model->exists(array('page_id' => 0)))
		{
			$vars = $this->page_model->variables(0);
			
			$this->load->vars($vars);
		}
	}
	
}