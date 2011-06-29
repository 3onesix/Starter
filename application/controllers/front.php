<?php

class Front extends My_Controller {
	
	function index()
	{
		$uri = $this->uri->segment_array();
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
		
		$includes = $page->includes();
		print_r($includes);
		if (count($includes['helper']))
		{
			foreach ($includes['helper'] as $helper)
			{
				$this->load->helper($helper);
			}
		}
		if (count($includes['model']))
		{
			foreach ($includes['model'] as $model)
			{
				$this->load->model($model);
			}
		}
		
		extract($page->variables());
		
		include('templates/'.$page->template->file.'.php');
	}
	
}