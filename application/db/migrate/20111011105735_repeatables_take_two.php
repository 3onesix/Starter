<?php
class Repeatables_Take_Two
{
	function up()
	{
		create_column('page_variables', array(
			'name' => 'page_variable_id',
			'type' => 'integer'
		));
		create_column('page_variables', array(
			'name' => 'array_index',
			'type' => 'integer'
		));
	}
}