<?php
class Create_Page_Variable_Revisions
{
	function up()
	{
		create_table('page_variable_revisions', array(
			array('name' => 'page_variable_id', 'type' => 'integer'),
			array('name' => 'value', 'type' => 'binary'),
			MIGRATION_TIMESTAMPS
		));
	}
}