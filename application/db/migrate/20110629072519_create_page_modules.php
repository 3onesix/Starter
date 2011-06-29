<?php
class Create_Page_Modules
{
	function up()
	{
		create_table('page_modules', array(
			array('name' => 'page_id', 'type' => 'integer'),
			array('name' => 'module_id', 'type' => 'integer'),
			MIGRATION_TIMESTAMPS
		));
	}
}