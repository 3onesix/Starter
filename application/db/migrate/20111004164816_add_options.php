<?php
class Add_Options
{
	function up()
	{
		create_column('template_variables', array(
			'name' => 'options',
			'type' => 'binary'
		));
	}
}