<?php

$module		 						= array(
	'name'							=> 'Google Analytics',
	'simple_name'					=> 'starter_googleanalytics',
	'author'						=> 'Starter',
	'description'					=> 'The Google Analytics module provides a quick and easy way to install analytics on all your pages, but also to track your numbers for any page and for your site within {product_name}.',
	'version'						=> '1.0',
	'settings'						=> array(
		array(
			'label' 				=> 'Google Analytics Key',
			'key'					=> 'key',
			'type'					=> 'string'
		),
		array(
			'label' 				=> 'Google Analytics Username',
			'key'					=> 'username',
			'type'					=> 'string'
		),
		array(
			'label' 				=> 'Google Analytics Password',
			'key'					=> 'password',
			'type'					=> 'string'
		),
		array(
			'label' 				=> 'Google Analytics Profile',
			'key'					=> 'profile',
			'type'					=> 'string'
		)
	),
	/*'files'							=> array(
		array(
			'type'					=> 'widget',
			'name'					=> 'page.php',
			'include_on_page'		=> 0
		),
		array(
			'type'					=> 'helper',
			'name'					=> 'googleanalytics.php',
			'include_on_page'		=> 1
		)
	),*/
	/*'widgets'						=> array(
		array(
			'name'					=> 'Page Analytics',
			'view'					=> 'page',
			'where'					=> 'page'
		)
	)*/
);