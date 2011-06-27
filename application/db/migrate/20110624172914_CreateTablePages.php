<?php
class CreateTablePages
{
	function up()
	{
		create_table('pages', array(
			array('name' => 'user_id', 'type' => 'integer'),
			array('name' => 'page_id', 'type' => 'string', 'default'=> -1),
			array('name' => 'name', 'type' => 'string'),
			array('name' => 'slug', 'type' => 'string'),
			array('name' => 'data', 'type' => 'binary'),
			MIGRATION_TIMESTAMPS
		));
	}
}