<?php

class Module_Model extends My_Model {
	
	function init()
	{
		$this->has_many('module_screens');
		$this->has_many('module_files');
		$this->has_many('settings');
	}
	
	function item($name)
	{
		return $this->first(array('simple_name' => $name));
	}
	
	function setting($key)
	{
		$setting = $this->settings->first(array('key' => $key));
		return $setting ? $setting->value : null;
	}
	
}