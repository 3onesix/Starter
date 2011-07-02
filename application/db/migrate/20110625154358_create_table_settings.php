<?php
class Create_Table_Settings
{
	function up()
	{
		create_table('settings', array(
			array('name' => 'module_id', 'type' => 'integer', 'default'=>0),
			array('name' => 'type', 'type' => 'string'),
			array('name' => 'label', 'type' => 'string'),
			array('name' => 'key', 'type' => 'string'),
			array('name' => 'value', 'type' => 'string'),
			MIGRATION_TIMESTAMPS
		));
	}
}