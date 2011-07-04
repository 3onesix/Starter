<?php

$this->module 						= array(
	'name'							=> 'Google Analytics',
	'simple_name'					=> 'starter_googleanalytics',
	'description'					=> 'The Google Analytics module provides a quick and easy way to install analytics on all your pages, but also to track your numbers for any page and for your site within Starter.',
	'version'						=> '1.0',
	'settings'						=> array(
		array(
			'label' 				=> 'Google Analytics Key',
			'key'					=> 'key'
		)
	),
	'files'							=> array(
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
	),
	'widgets'						=> array(
		array(
			'name'					=> 'Page Analytics',
			'view'					=> 'page',
			'where'					=> 'page'
		)
	)
);