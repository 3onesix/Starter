<?php
class Create_Page_Hidden_Column
{
	function up()
	{
		create_column('pages', array(
			'name' => 'status',
			'type' => 'string',
			'default' => 'public'
		));
	}
}