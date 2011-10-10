<?php

function install()
{
	create_table('starter_blogs', array(
		array('name' => 'name', 'type' => 'string'),
		array('name' => 'url', 'type' => 'string'),
		MIGRATION_TIMESTAMPS
	));
	create_table('starter_articles', array(
		array('name' => 'blog_id', 'type' => 'integer'),
		array('name' => 'user_id', 'type' => 'integer'), //added in 1.2
		array('name' => 'subject', 'type' => 'string'),
		array('name' => 'slug', 'type' => 'string'),
		array('name' => 'short', 'type' => 'binary'), //added in 1.1
		array('name' => 'body', 'type' => 'binary'),
		array('name' => 'is_published', 'type' => 'boolean'),
		MIGRATION_TIMESTAMPS
	));
}

function update($version)
{
	if ($version == '1.0') { //update to 1.1
		create_column('articles', array('name' => 'short', 'type' => 'binary')); //short didn't exist before 1.1
		
		$version = '1.1';
	}
	if ($version == '1.1') { //update to 1.2
		create_column('articles', array('name' => 'user_id', 'type' => 'integer')); //user_id didn't exist before 1.2
		
		$version = '1.2';
	}
}

install();

//$this->load->model('blog_model');
//$this->blog_model->create(array('name' => 'Blog', 'url' => 'blog'));

/*

So the idea here is that the update function would be called and given the current version anytime that the module is loaded. It would autoupdate tables, add items to the data, or whatever else needs to be done.

*/