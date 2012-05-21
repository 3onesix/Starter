<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images extends MY_Controller
{
	public function action_upload()
	{
		$image = new Image_Model;
		$image->user_id = $this->current_user->id;
		$image->save();
		
		$size = getimagesize($image->image->file_path());
		
		$output = array(
			'id' => $image->id,
			'url' => $image->image->url(),
			'width' => $size[0],
			'height' => $size[1]
		);
		
		$this->output->set_content_type('text/json');
		$this->output->set_output(json_encode($output));
	}
	
	public function action_update($id)
	{
		$data = $this->input->post('image');		
		$image = $this->image_model->first($id);
		$image->update_attributes($data);
	}
	
	public function action_destroy($id)
	{
		$image = $this->image_model->first($id);
		unlink($image->image->file_path);
		$image->destroy();
	}
	
	public function action_show($file)
	{
		ini_set('memory_limit', '64M');
		
		$file = $this->image_model->first_by_image_file_name($file);
		if ($file)
		{
			list($orig_width, $orig_height) = getimagesize($file->image->file_path);
			
			$img = imagecreatefromjpeg($file->image->file_path);
			
			//resize
			$resized = imagecreatetruecolor($orig_width * $file->scale, $orig_height * $file->scale);
			imagecopyresampled($resized, $img, 0, 0, 0, 0, $orig_width * $file->scale, $orig_height * $file->scale, $orig_width, $orig_height);
			
			//position
			$crop = imagecreatetruecolor($file->width, $file->height);
			imagecopyresampled($crop, $resized, $file->x, $file->y, 0, 0, $orig_width * $file->scale, $orig_height * $file->scale, $orig_width * $file->scale, $orig_height * $file->scale);
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
			
			//print image
			header('Content-Type: image/jpeg');
			imagejpeg($final);
			
			imagedestroy($crop);
			imagedestroy($final);
		}
		else
		{
			show_404();
		}
	}
}