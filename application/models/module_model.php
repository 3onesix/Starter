<?php

class Module_Model extends My_Model {
	
	function init()
	{
		$this->has_many('module_screens');
		$this->has_many('module_files');
		$this->has_many('settings');
		
		$this->after_save('save_module_array');
	}
	
	function page_modules() //get all modules that can be included on a page
	{
		$query = $this->db->query('SELECT DISTINCT module_id FROM module_files WHERE include_on_page = 1');
		$ids   = array();
		if ($query->num_rows())
		{
			foreach ($query->result() as $row) $ids[] = $row->module_id;
		}
		return $this->all(array('conditions' => $ids, 'order' => 'name ASC'));
	}
	
	function save_module_array()
	{		
		$names = array();
		foreach($this->all() as $module) 
		{
			$names[] = $module->simple_name;
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
	
	function get_current_config()
	{
		$file = 'assets/site/modules/'.$this->simple_name.'/config.php';
		if (file_exists($file))
		{
			include($file);
			return isset($module) && is_array($module) ? $module : null;
		}
		return null;
	}
	
	function get_has_update()
	{
		
		if ($this->current_config && is_array($this->current_config) && $this->current_config['version'] != $this->version)
		{
			return true;
		}
		
		return false;
	}
	
}