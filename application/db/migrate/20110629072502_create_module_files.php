<?php
class Create_Module_Files
{
	function up()
	{
		create_table('module_files', array(
			array('name' => 'module_id', 'type' => 'integer'),
			array('name' => 'type', 'type' => 'string'),
			array('name' => 'name', 'type' => 'string'),
			array('name' => 'include_on_page', 'type' => 'boolean'),
			MIGRATION_TIMESTAMPS
		));
	}
}