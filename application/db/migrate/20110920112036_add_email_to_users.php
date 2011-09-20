<?php
class Add_Email_To_Users
{
	function up()
	{
		create_column('users', array(
			'name' => 'email',
			'type' => 'string'
		));
	}
}