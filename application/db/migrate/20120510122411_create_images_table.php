<?php
class Create_Images_Table
{
	function up()
	{
		create_table('images', array(
			// User that created 
			array('name' => 'user_id', 'type' => 'integer'),
			
			// Polymorphic Relationship
			array('name' => 'imageable_id', 'type' => 'integer'),
			array('name' => 'imageable_type', 'type' => 'string'),
			
			// Image Attachment
			array('name'=> 'image_file_name', 'type'=>'string'),
			array('name'=> 'image_content_type', 'type'=>'string'),
			array('name'=> 'image_file_size', 'type'=>'integer'),
			array('name'=> 'image_updated_at', 'type'=>'integer'),
			
			// Crop & Scale
			array('name' => 'x', 'type' => 'integer'),
			array('name' => 'y', 'type' => 'integer'),
			array('name' => 'width', 'type' => 'integer'),
			array('name' => 'height', 'type' => 'integer'),
			array('name' => 'scale', 'type' => 'float'),
			
			// Namespace
			array('name' => 'namespace', 'type' => 'string'),
			
			// Default
			MIGRATION_TIMESTAMPS
		));
	}
}