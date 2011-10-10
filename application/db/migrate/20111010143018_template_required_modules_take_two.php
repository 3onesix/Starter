<?php
class Template_Required_Modules_Take_Two
{
	function up()
	{
		create_table('template_required_modules', array(
			array('name' => 'template_id', 'type' => 'integer'),
			array('name' => 'module_name', 'type' => 'string'),
			MIGRATION_TIMESTAMPS
		));

	}
}