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
		$this->image_model->first($id)->destroy();
	}
}