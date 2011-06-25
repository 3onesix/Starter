<?php
class CreateTableSettings
{
	function up()
	{
		create_table('settings', array(
			array('name' => 'key', 'type' => 'string'),
			array('name' => 'value', 'type' => 'string'),
			MIGRATION_TIMESTAMPS
		));
	}
}