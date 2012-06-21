<?php

function include_template($name, $data = array())
{
	$template = new Template($name, $data);
	$template->render();
}

function include_partial($name, $data = array())
{
	include_template('_'.$name, $data);
}

class Template
{
	protected $name = '';
	protected $data = array();
	
	public function __construct($name, $data = array())
	{
		$this->name = $name;
		$this->data = $data;
	}
	
	public function path()
	{
		return 'assets/site/templates/'.$this->name.'.php';
	}
	
	public function render()
	{
		if (file_exists($this->path()))
		{		
			$CI =& get_instance();
		
			if ( is_array($CI->variables) )
			{
				foreach ($CI->variables as $k => $v)
				{
					$$k = $v;
				}
			}
			
			foreach ($this->data as $k => $v)
			{
				$$k = $v;
			}
			
			include($this->path());
		}
	}
	
	public function __get($key)
	{
		$CI =& get_instance();
		
		if ( property_exists($CI, $key) )
		{
			return $CI->$key;
		}
		
		return false;
	}
}