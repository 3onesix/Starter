<?php
class Widgets
{
	function up()
	{
		create_table('module_widgets', array(
			array('name' => 'module_id', 'type' => 'integer'),
			array('name' => 'name', 'type' => 'string'),
			array('name' => 'view', 'type' => 'string'),
			array('name' => 'where', 'type' => 'string'),
			array('name' => 'size', 'type' => 'string'),
			MIGRATION_TIMESTAMPS
		));
	}
}