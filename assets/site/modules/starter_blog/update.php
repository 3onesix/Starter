<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function update($module)
{
	if ($module->version == '1.2.1')
	{
		//create_column('starter_articles', array('name' => 'short2', 'type' => 'binary')); //short didn't exist before 1.2.1
	}
}

update($module);