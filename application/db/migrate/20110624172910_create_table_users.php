<?php
class Create_Table_Users
{
	function up()
	{
		create_table('users', array(
			array('name' => 'first_name', 'type' => 'string'),
			array('name' => 'last_name', 'type' => 'string'),
			array('name' => 'username', 'type' => 'string'),
			array('name' => 'password', 'type' => 'string'),
			MIGRATION_TIMESTAMPS
		));
	}
}