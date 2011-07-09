<?php

class Module_Model extends My_Model {
	
	function init()
	{
		$this->has_many('module_screens');
		$this->has_many('module_files');
		$this->has_many('settings');
		
		$this->after_save('save_module_array');
	}
	
	function save_module_array()
	{		
		$names = array();
		foreach($this->all() as $module) 
		{
			$names[] = $module->name;
		}
		
		$string =  "<?php\n"; 
		$string .= "\$modules = array(\n";
		$string .= "\tMODPATH.'".implode("',\n\tMODPATH.'", $names)."'\n);\n";
	
		file_put_contents(MODPATH.'modules.php', $string);
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