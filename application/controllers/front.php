<?php

class Front extends My_Controller {
	
	function index()
	{
		//$this->output->enable_profiler(TRUE);
		
		$this->benchmark->mark('front_start');
		$this->load->helper('page');
		
		$uri = $this->uri->segment_array();
		
		if (!count($uri))
		{
			$uri[] = 'index';
		}
		
		$this->benchmark->mark('process_url_start');
		$page = null;
		foreach ($uri as $segment)
		{
			if ($page)
			{
				$page_temp = $page->pages->first(array('slug' => $segment));
				if ($page_temp) $page = $page_temp;
			}
			else 
			{
				$page_temp = $this->page_model->first(array('conditions' => array('page_id' => -1, 'slug' => $segment), 'include' => array('page_variables', 'page_modules')));
				if ($page_temp) $page = $page_temp;
			}
			
		}
		$this->benchmark->mark('process_url_end');
		
		if ($page && $page->template_id)
		{
			$includes = $page->includes();
			if ($i = count($includes['helper']))
			{
				while ($i--)
				{
					$helper = $includes['helper'][$i];
					$this->load->helper(str_replace('.php', '', $helper));
				}
			}
			if ($i = count($includes['model']))
			{
				while ($i--)
				{
					$model = $includes['model'][$i];
					$this->load->model(str_replace('.php', '', $model));
				}
			}
			
			$this->benchmark->mark('load_variables_start');
			
			$vars = $this->page_model->variables(0);
			if ($vars)
			{
				foreach ($vars as $k => $v)
				{
					$$k = $v;
				}
			}
			
			$vars = $page->variables();
			foreach ($vars as $k => $v)
			{
				$$k = $v;
			}
			$this->benchmark->mark('load_variables_end');
			
			$this->benchmark->mark('front_end');
			include('assets/site/templates/'.$page->template->file.'.php');
		}
		else
		{
			show_404();
		}
	}
	
}