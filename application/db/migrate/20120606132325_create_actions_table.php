<?php
class Create_Actions_Table
{
	function up()
	{
		create_table('actions', array(
			array('name' => 'type', 'type' => 'string'),
			array('name' => 'actionable_id', 'type' => 'integer'),
			array('name' => 'actionable_type', 'type' => 'string'),
			array('name' => 'user_id', 'type' => 'integer'),
			array('name' => 'ip_address', 'type' => 'string'),
			array('name' => 'user_agent', 'type' => 'string'),
			MIGRATION_TIMESTAMPS
		));
	}
}