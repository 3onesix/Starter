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