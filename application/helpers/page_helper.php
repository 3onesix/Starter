<?php

function include_template($template)
{
	if (file_exists('assets/site/templates/'.$template.'.php'))
	{
		include('assets/site/templates/'.$template.'.php');
	}
}

function include_partial($template)
{
	include_template('_'.$template);
}

function image($path, $settings = array())
{
	//dissect $path
	if (!value_for_key('path', $settings))
	{
		if (strpos($path, 'http://', 0))
		{
			
		}
		if (strpos($path, '/') === false) //path is just file name
		{
			$ci &= get_instance();
			$path = base_url().'assets/site/images/'.$path;
		}
	}
	else $path = value_for_key('path', $settings).'/'.$path;
	
	//handle settings
	$styles = array();
	$alt 	= '';
	foreach ($settings as $key => $value)
	{
		if (preg_match('/^[0-9]*$/', $key) && (preg_match('/^[0-9]*$/', $value) || preg_match('/^[0-9]*x[0-9]*$/', $value)))
		{
			$styles[] = 'data-'.$key.'="'.$value.'"';
		}
		elseif ($key == 'alt')
		{
			$alt = $value;
		}
	}
	
	return '<noscript '.implode($styles, ' ').'><img src="'.$path.'" alt="'.$alt.'" /></noscript>';
}