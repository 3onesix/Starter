<?php
class CreateTablePages
{
	function up()
	{
		create_table('pages', array(
			array('name' => 'user_id', 'type' => 'integer'),
			array('name' => 'pageable_id', 'type' => 'integer'),
			array('name' => 'pageable_type', 'type' => 'string'),
			array('name' => 'name', 'type' => 'string'),
			array('name' => 'slug', 'type' => 'string'),
			array('name' => 'data', 'type' => 'binary'),
			MIGRATION_TIMESTAMPS
		));
	}
}