<?php

function include_template($template, $data = array())
{
	if (file_exists('assets/site/templates/'.$template.'.php'))
	{
		extract($data);
		
		include('assets/site/templates/'.$template.'.php');
	}
}

function include_partial($template, $data)
{
	include_template('_'.$template, $data = array());
}