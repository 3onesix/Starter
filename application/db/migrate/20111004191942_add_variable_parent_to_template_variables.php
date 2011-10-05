<?php
class Add_Variable_Parent_To_Template_Variables
{
	function up()
	{
		create_column('template_variables', array(
			'name' => 'template_variable_id',
			'type' => 'integer'
		));
	}
}