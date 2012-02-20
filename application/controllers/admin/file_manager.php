<?php

class File_Manager extends MY_Controller
{
	protected $require_login = TRUE;
	
	function action_index()
	{
		//create handle
		$base_path = $this->config->item('starter_files_path');
		$path = $this->input->get('path') ? $this->input->get('path') : '';
		$handle = opendir($base_path.$path);
		
		//determine parent folder (if any)
		$folders = explode('/', $path);
			$current = array_pop($folders);
			$parent  = implode('/', $folders);
		
		//read directory
		$files = array();
		while ($pointer = readdir($handle))
		{
			if ($pointer == '.' || $pointer == '..') continue;
			
			$files[] = (object) array(
				'path' 		=> ($path ? $path.'/' : '').$pointer,
				'url' 		=> $this->config->item('starter_files_url').($path ? $path.'/' : '').$pointer,
				'pointer' 	=> $pointer,
				'is_dir' 	=> (boolean) !!is_dir($base_path.$path.'/'.$pointer),
				'is_file' 	=> (boolean) !is_dir($base_path.$path.'/'.$pointer)
			);
		}
		
		$this->load->view('admin/file_manager/index', array(
			'path' 		=> $path,
			'parent' 	=> $parent,
			'current'	=> $current,
			'files' 	=> $files
		));
	}
	
	function action_new_directory()
	{
		$path = $this->input->get('path');
		
		$this->load->view('admin/file_manager/new_directory', array(
			'path' => $path
		));
	}
	
	function action_create_directory()
	{
		$base_path 	= $this->config->item('starter_files_path');
		
		$directory 	= $this->input->post('directory');
		$path 		= $directory['path'];
		$name 		= $directory['name'];
		
		mkdir($base_path.$path.'/'.$name);
		flash('notice', 'Successfully added folder.');
		redirect('admin/file_manager?path='.$path.'/'.$name);
	}
	
	function action_destroy()
	{
		$path = $this->input->get('path');
		
		//determine parent folder (if any)
		$folders = explode('/', $path);
			array_pop($folders);
			$parent = implode('/', $folders);
		
		if ($path)
		{
			$base_path = $this->config->item('starter_files_path');
			unlink($base_path.$path);
			flash('notice', 'Successfully deleted file.');
			redirect('admin/file_manager?path='.$parent);
		}
	}
	
	function action_destroy_directory()
	{
		$base_path = $this->config->item('starter_files_path');
		$path = $this->input->get('path');
		$handle = opendir($base_path.$path);
		
		//determine parent folder (if any)
		$folders = explode('/', $path);
			array_pop($folders);
			$parent = implode('/', $folders);
			
		//check for any subfolders or files
		$files = array();
		while ($pointer = readdir($handle))
		{
			if ($pointer == '.' || $pointer == '..') continue;
			
			$files[] = (object) array(
				'path' 		=> ($path ? $path.'/' : '').$pointer,
				'url' 		=> $this->config->item('starter_files_url').$path.'/'.$pointer,
				'pointer' 	=> $pointer,
				'is_dir' 	=> (boolean) !!is_dir($base_path.$path.'/'.$pointer),
				'is_file' 	=> (boolean) !is_dir($base_path.$path.'/'.$pointer)
			);
		}
		if (count($files))
		{
			flash('error', 'You are not able to delete this folder because it contains other folders and/or files.');
			redirect('admin/file_manager?path='.$parent);
		}
		else
		{
			rmdir($base_path.$path);
			flash('notice', 'Successfully deleted folder.');
			redirect('admin/file_manager?path='.$parent);
		}
	}
	
	function action_upload_file()
	{
		$path = $this->input->get('path');
		$this->load->view('admin/file_manager/upload', array('path' => $path));
	}
	
	function action_do_upload()
	{
		$base_path = $this->config->item('starter_files_path');
		$path = $this->input->post('path');
		
		move_uploaded_file($_FILES["file"]["tmp_name"], $base_path.$path.'/'.$_FILES["file"]["name"]);
		flash('notice', 'Successfully uploaded file.');
		redirect('admin/file_manager?path='.$path);
	}
	
}