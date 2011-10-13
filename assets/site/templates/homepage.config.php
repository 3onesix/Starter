<?php

$template = array();

$template['name'] = 'Homepage';

$template['modules'] = array(
	'starter_blog'
);

$template['variables'] = array(
	array(
		'type' => 'binary',
		'name' => 'copy',
		'label' => 'Sidebar Copy',
		'default' => 'Lorem ipsum'
	),
	array(
		'type' => 'html',
		'name' => 'html',
		'label' => 'Sidebar Copy',
		'default' => 'Lorem ipsum'
	),
	array(
		'type'  => 'string',
		'name'  => 'title',
		'label' => 'Title',
		'options' => array('Mr.', 'Mrs.', 'Ms.')
	),
	array(
		'type' => 'array',
		'name' => 'contacts',
		'label' => 'Contacts',
		'limit' => 20,
		'variables' => array(
			array(
				'type'  => 'string',
				'name'  => 'title',
				'label' => 'Title',
				'options' => array('Mr.', 'Mrs.', 'Ms.')
			),
			array(
				'type'  => 'string',
				'name'  => 'name',
				'label' => 'Name'
			)
		)
	),
	array(
		'type'  => 'file',
		'name'  => 'upload',
		'label' => 'upload'
	)
);