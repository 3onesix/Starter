<?php
class Create_Modules_Screens
{
	function up()
	{
		create_table('module_screens', array(
			array('name' => 'name', 'type' => 'string'),
			array('name' => 'url', 'type' => 'string'),
			MIGRATION_TIMESTAMPS
		));
	}
}