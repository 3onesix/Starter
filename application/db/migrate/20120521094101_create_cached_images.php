<?php
class Create_Cached_Images
{
	function up()
	{
		create_table('cached_images', array(
			array('name' => 'file', 'type' => 'string'),
			array('name' => 'width', 'type' => 'integer'),
			array('name' => 'height', 'type' => 'integer'),
			array('name' => 'chunk', 'type' => 'string'),
			array('name' => 'cache', 'type' => 'string'),
			MIGRATION_TIMESTAMPS
		));
	}
}