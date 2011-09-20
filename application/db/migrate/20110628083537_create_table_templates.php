<?php
class Create_Table_Templates
{
	function up()
	{
		create_table('templates', array(
			array('name' => 'name', 'type' => 'string'),
			array('name' => 'file', 'type' => 'string'),
			MIGRATION_TIMESTAMPS
		));
	}
}