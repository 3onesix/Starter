<?php

class Front extends My_Controller {
	
	function index()
	{
		//$this->output->enable_profiler(TRUE);
		
		$uri = $this->uri->segment_array();
		
		if (!count($uri))
		{
			$uri[] = 'index';
		}
		
		$page = null;
		foreach ($uri as $segment)
		{
			if ($page)
			{
				if ($page->exists(array('slug' => $segment))) $page = $page->first(array('slug' => $segment));
			}
			else 
			{
				if ($this->page_model->exists(array('page_id' => -1, 'slug' => $segment))) {
					$page = $this->page_model->first(array('page_id' => -1, 'slug' => $segment));
				}
			}
			
		}
		
		if ($page && $page->template_id)
		{
			$includes = $page->includes();
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
			
			extract($page->variables());
			
			include('assets/site/templates/'.$page->template->file.'.php');
		}
		else
		{
			show_404();
		}
	}
	
}