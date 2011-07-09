<?php
class Create_Roles_Table
{
	function up()
	{
		create_table('roles', array(
			array('name' => 'name', 'type' => 'string'),
			array('name' => 'description', 'type' => 'binary'),
			MIGRATION_TIMESTAMPS
		));
	}
}