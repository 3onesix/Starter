<?php

$this->module 						= array(
	'name'							=> 'Blog',
	'simple_name'					=> 'starter_blog',
	'version'						=> '1.2',
	'settings'						=> array(
		array(
			'label' 				=> 'Include Short Body Field',
			'key'					=> 'include_short',
			'type'					=> 'checkbox'
		)
	),
	'files'							=> array(
		array(
			'type'					=> 'controller',
			'name'					=> 'blog.php',
			'include_on_page'		=> 0
		),
		array(
			'type'					=> 'model',
			'name'					=> 'blog_model.php',
			'include_on_page'		=> 1
		),
		array(
			'type'					=> 'model',
			'name'					=> 'article_model.php',
			'include_on_page'		=> 1
		),
		array(
			'type'					=> 'helper',
			'name'					=> 'blog_helper.php',
			'include_on_page'		=> 1
		),
		array(
			'type'					=> 'library',
			'name'					=> 'mkdn.php',
			'include_on_page'		=> 1
		)
	),
	'screens'						=> array(
		array(
			'name'					=> 'Blog',
			'url'					=> 'blog'
		)
	)
);