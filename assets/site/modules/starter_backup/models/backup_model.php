<?php

class Backup_Model extends MY_Model {

	function init()
	{
		$this->tablename('starter_backup');
	}
	
	function all()
	{
		if (!is_dir(FCPATH.'assets/site/backups')) return array();
		
		$folder = FCPATH.'assets/site/backups/';
		$files = array();
		
		$r = opendir($folder);
		
		while (($file = readdir($r)) !== false) {
			if (!is_dir($folder.$file))
			{	
				array_push($files, str_replace('.backup', '', $file));
			}
		}
		
		rsort($files);
		return $files;
	}
	
	function run()
	{
		$data = array(
			'pages' 	=> array(),
			'templates' => array(),
			'modules' 	=> array()
		);
		
		$pages = $this->page_model->all();
		
		foreach($pages as $page)
		{
			$tmp = array(
				'id'				=> $page->id,
				'template_id' 		=> $page->template_id,
				'user_id' 			=> $page->user_id,
				'page_id' 			=> $page->page_id,
				'name' 				=> $page->name,
				'slug'				=> $page->slug,
				'created_at'		=> $page->created_at,
				'updated_at'		=> $page->updated_at,
				'variables'			=> array(),
				'modules'			=> array()
			);
			
			$variables = $page->page_variables->all();
			foreach ($variables as $variable)
			{
				$tmp['variables'][] = array(
					'label' 		=> $variable->label,
					'type'			=> $variable->type,
					'name'			=> $variable->name,
					'value'			=> $variable->value,
					'created_at'	=> $variable->created_at,
					'updated_at'	=> $variable->updated_at
				);
			}
			
			$modules = $page->page_modules->all();
			foreach ($modules as $module)
			{
				$tmp['modules'][] = array(
					'module_id'		=> $module->module_id,
					'created_at'	=> $module->created_at,
					'updated_at'	=> $module->updated_at
				);
			}
			
			$data['pages'][] = $tmp;
		}
		
		$templates = $this->template_model->all();
		
		foreach($templates as $template)
		{
			$tmp = array(
				'id' 			=> $template->id,
				'name' 			=> $template->name,
				'file'			=> $template->file,
				'created_at' 	=> $template->created_at,
				'updated_at' 	=> $template->updated_at,
				'variables'		=> array()
			);
			
			$variables = $template->template_variables->all();
			foreach ($variables as $variable)
			{
				$tmp['variables'][] = array(
					'label' 		=> $variable->label,
					'type'			=> $variable->type,
					'name'			=> $variable->name,
					'value'			=> $variable->value,
					'created_at'	=> $variable->created_at,
					'updated_at'	=> $variable->updated_at
				);
			}
			
			$data['templates'][] = $tmp;
		}
		
		$modules = $this->module_model->all();
		foreach ($modules as $module)
		{
			$tmp = array(
				'id' 			=> $module->id,
				'name'			=> $module->name,
				'simple_name'	=> $module->simple_name,
				'version'		=> $module->version,
				'description'	=> $module->description,
				'created_at'	=> $module->created_at,
				'updated_at'	=> $module->updated_at,
				'screens'		=> array(),
				'files'			=> array()
			);
			
			$screens = $module->module_screens->all();
			foreach ($screens as $screen)
			{
				$tmp['screens'][] 	= array(
					'name'			=> $screen->name,
					'url'			=> $screen->url,
					'created_at'	=> $screen->created_at,
					'updated_at'	=> $screen->updated_at
				);
			}
			
			$files = $module->module_files->all();
			foreach ($files as $file)
			{
				$tmp['files'][] 		= array(
					'type'				=> $file->type,
					'name'				=> $file->name,
					'include_on_page'	=> $file->include_on_page,
					'created_at'		=> $file->created_at,
					'updated_at'		=> $file->updated_at
				);
			}
			
			$data['modules'][] = $tmp;
		}
		
		$fp = fopen('assets/site/backups/'.time().'.backup', 'w');
		fwrite($fp, serialize($data));
		fclose($fp);
	}
	
	function destroy($id)
	{
		unlink(FCPATH.'assets/site/backups/'.$id.'.backup');
	}
	
}