<?php

$template = array();

$template['name'] = 'Homepage';

$template['modules'] = array(
	'blog'
);

$template['variables'] = array(
	array(
		'type' => 'binary',
		'name' => 'copy',
		'label' => 'Sidebar Copy',
		'default' => 'Lorem ipsum'
	)
);