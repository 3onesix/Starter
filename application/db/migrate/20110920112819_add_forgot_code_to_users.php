<?php
class Add_Forgot_Code_To_Users
{
	function up()
	{
		create_column('users', array(
			'name' => 'forgot_code',
			'type' => 'string'
		));
	}
}