<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

install();