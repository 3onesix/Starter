<?php

$module		 						= array(
	'name'							=> 'Backup',
	'simple_name'					=> 'starter_backup',
	'author'						=> 'Starter',
	'description'					=> 'Backup your import data in {product_name}.',
	'version'						=> '1.0',
	'files'							=> array(
		array(
			'type'					=> 'controller',
			'name'					=> 'backup.php',
			'include_on_page'		=> 0
		),
		array(
			'type'					=> 'model',
			'name'					=> 'backup_model.php',
			'include_on_page'		=> 1
		)
	),
	'screens'						=> array(
		array(
			'name'					=> 'Backup Site',
			'url'					=> 'backup'
		)
	),
	'install'						=> 'install.php'
);