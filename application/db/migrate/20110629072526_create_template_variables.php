<?php
class Create_Template_Variables
{
	function up()
	{
		create_table('template_variables', array(
			array('name' => 'template_id', 'type' => 'integer'),
			array('name' => 'type', 'type' => 'string'),
			array('name' => 'name', 'type' => 'string'),
			array('name' => 'label', 'type' => 'string'),
			array('name' => 'value', 'type' => 'binary'),
			MIGRATION_TIMESTAMPS
		));
	}
}