<?php
class Create_Modules
{
	function up()
	{
		create_table('modules', array(
			array('name' => 'name', 'type' => 'string'),
			array('name' => 'simple_name', 'type' => 'string'),
			array('name' => 'version', 'type' => 'string'),
			array('name' => 'description', 'type' => 'binary'),
			MIGRATION_TIMESTAMPS
		));
	}
}