<?php
class Create_Permissions_Table
{
	function up()
	{
		create_table('permissions', array(
			array('name' => 'role_id', 'type' => 'integer'),
			array('name' => 'module_id', 'type' => 'integer'),
			array('name' => 'key', 'type' => 'string'),
			array('name' => 'value', 'type' => 'boolean'),
			MIGRATION_TIMESTAMPS
		));
	}
}