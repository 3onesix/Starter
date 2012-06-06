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
			$variables = array();
			
			if ($vars)
			{
				foreach ($vars as $k => $v)
				{
					$variables[$k] = $v;
				}
			}
			
			$vars = $page->variables();
			foreach ($vars as $k => $v)
			{
				$variables[$k] = $v;
			}
			
			$this->variables = $variables;
			
			$this->benchmark->mark('load_variables_end');
			
			$this->benchmark->mark('front_end');
			
			include_template($page->template->file);
		}
		else
		{
			show_404();
		}
	}
	
	function image_show($file_name)
	{
		ini_set('memory_limit', '64M');

		$check = $this->db->where(array(
			'file'   => $file_name,
			'width' => $this->input->get('width'),
			'height' => $this->input->get('height')
		))->get('cached_images');
				
		if ($check->num_rows() === 1)
		{
			$this->load_cache($check->row()->cache);
			return true;
		}
		
		$file = $this->image_model->first_by_image_file_name($file_name);
		if ($file)
		{
			$chunk = $this->create_private_chunk();
			$ext   = explode('.', $file->image->file_path);
			$ext   = $ext[count($ext) - 1];
			$cached = $chunk.'.'.$ext;
		
			list($orig_width, $orig_height) = getimagesize($file->image->file_path);
			
			$img = imagecreatefromjpeg($file->image->file_path);
			
			//resize
			$resized = imagecreatetruecolor($orig_width * $file->scale, $orig_height * $file->scale);
			imagecopyresampled($resized, $img, 0, 0, 0, 0, $orig_width * $file->scale, $orig_height * $file->scale, $orig_width, $orig_height);
			
			//position
			$crop = imagecreatetruecolor($file->width, $file->height);
			imagecopyresampled($crop, $resized, $file->x / $file->scale, $file->y / $file->scale, 0, 0, $orig_width * $file->scale, $orig_height * $file->scale, $orig_width * $file->scale, $orig_height * $file->scale);
			imagedestroy($resized);
			
			//resize
			$final = $crop;
			if ($this->input->get('width'))
			{
				$w = $this->input->get('width');
				$h = ($file->height * $this->input->get('width')) / $file->width;
				$final = imagecreatetruecolor($w, $h);
				imagecopyresampled($final, $crop, 0, 0, 0, 0, $w, $h, $file->width, $file->height);
				imagedestroy($crop);
			}
			if ($this->input->get('height'))
			{
				$h = $this->input->get('height');
				$w = ($file->width * $this->input->get('height')) / $file->height;
				$final = imagecreatetruecolor($w, $h);
				imagecopyresampled($final, $crop, 0, 0, 0, 0, $w, $h, $file->width, $file->height);
				imagedestroy($crop);
			}
			
			imagejpeg($final, FCPATH.'assets/site/cached_images/'.$cached);
			
			$this->db->insert('cached_images', array(
				'file' => $file_name,
				'width' => $this->input->get('width'),
				'height' => $this->input->get('height'),
				'chunk' => $chunk,
				'cache' => $cached,
				'created_at' => time()
			));

//			imagedestroy($crop);
//			imagedestroy($final);
			
			$this->load_cache($cached);
		}
		else
		{
			show_404();
		}
	}
	
	private function load_cache($file)
	{
		redirect('assets/site/cached_images/'.$file);
	}
	
	private function create_private_chunk()
	{
		//create random a-z0-9 private chunk
		$chunk = $this->random_character().$this->random_character().$this->random_character().$this->random_character().$this->random_character().$this->random_character().$this->random_character();

		if ($this->db->where('chunk', $chunk)->get('cached_images')->num_rows() !== 0)
		{
			return $this->create_private_chunk();
		}

		return $chunk;
	}
		
	private function random_character()
	{
		$num = rand(1, 36);

		if ($num > 26)
		{
			return $num - 27;
		}

		switch ($num)
		{
			case 1:
				return 'a';
				break;
			case 2:
				return 'b';
				break;
			case 3:
				return 'c';
				break;
			case 4:
				return 'd';
				break;
			case 5:
				return 'e';
				break;
			case 6:
				return 'f';
				break;
			case 7:
				return 'g';
				break;
			case 8:
				return 'h';
				break;
			case 9:
				return 'i';
				break;
			case 10:
				return 'j';
				break;
			case 11:
				return 'k';
				break;
			case 12:
				return 'l';
				break;
			case 13:
				return 'm';
				break;
			case 14:
				return 'n';
				break;
			case 15:
				return 'o';
				break;
			case 16:
				return 'p';
				break;
			case 17:
				return 'q';
				break;
			case 18:
				return 'r';
				break;
			case 19:
				return 's';
				break;
			case 20:
				return 't';
				break;
			case 21:
				return 'u';
				break;
			case 22:
				return 'v';
				break;
			case 23:
				return 'w';
				break;
			case 24:
				return 'x';
				break;
			case 25:
				return 'y';
				break;
			case 26:
				return 'z';
				break;
		}
		return 0;
	}
}