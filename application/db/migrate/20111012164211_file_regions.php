<?php
class File_Regions
{
	function up()
	{
		create_column('page_variables', array(
			'name' => 'file_file_name',
			'type' => 'string'
		));
		create_column('page_variables', array(
			'name' => 'file_content_type',
			'type' => 'string'
		));
		create_column('page_variables', array(
			'name' => 'file_file_size',
			'type' => 'string'
		));
		create_column('page_variables', array(
			'name' => 'file_updated_at',
			'type' => 'integer'
		));
	}
}