<?php

class Image_Model extends My_Model
{
	public function init()
	{		
		$this->belongs_to('user');
		
		$this->belongs_to('imageable', array(
			'polymorphic' => TRUE
		));

		$this->has_attached_file('image', array(
			'url' => '/assets/site/uploads/images/{filename}',
			'path' => FCPATH.'assets/site/uploads/images/{filename}'
		));
		
		$this->validates('image', array(
			'attachment_content_type' => array(
				'image/jpeg', 'image/png'
			)
		));
		
		$this->validates('user_id', 'required');
	}
}