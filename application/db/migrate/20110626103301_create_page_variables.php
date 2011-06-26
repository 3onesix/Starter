<?php
class Create_Page_Variables
{
	function up()
	{
		create_table('page_variables', array(
			array('name' => 'page_id', 'type' => 'integer'),
			array('name' => 'template_id', 'type' => 'integer'),
			array('name' => 'name', 'type' => 'string'),
			array('name' => 'value', 'type' => 'binary'),
			MIGRATION_TIMESTAMPS
		));
	}
}