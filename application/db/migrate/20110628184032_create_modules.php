<?php
class Create_Modules
{
	function up()
	{
		create_table('modules', array(
			array('name' => 'name', 'type' => 'string'),
			MIGRATION_TIMESTAMPS
		));
	}
}