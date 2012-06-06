<?php

function include_template($template, $data = array())
{
	if (file_exists('assets/site/templates/'.$template.'.php'))
	{		
		$CI =& get_instance();
	
		if ( is_array($CI->variables) )
		{
			foreach ($CI->variables as $k => $v)
			{
				$$k = $v;
			}
		}
		
		foreach ($data as $k => $v)
		{
			$$k = $v;
		}
		
		include('assets/site/templates/'.$template.'.php');
	}
}

function include_partial($template, $data = array())
{
	include_template('_'.$template, $data = array());
}