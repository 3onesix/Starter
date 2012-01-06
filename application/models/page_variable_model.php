<?php

class Page_Variable_Model extends My_Model
{

	public $allow_api = false;
	
	public function init()
	{
		//$this->validates('page_id', 'required');
		$this->validates('name', 'required');
		
		$this->belongs_to('page');
		$this->has_many('page_variables');
		
		$this->before_update('store_revision');
		
		$this->has_attached_file('file', array(
			'url'  => 'assets/site/uploads/{filename}',
			'path' => 'assets/site/uploads/{filename}'
		));
	}
	
	public function store_revision()
	{
		$this->page_variable_revision_model->create(array(
			'page_variable_id' => $this->id,
			'value' => $this->value
		));
	}
	
	# Return files // overrides Jot
	/*public function set_files_cache($name, $cache) {
		$this->files_cache_local = array(
			$name => $cache
		);
	}
	
	public function _files($attachment_name)
	{
		if ( ! is_array($this->files_cache_local) ) $this->files_cache_local = array();
			
		# Return file attachment from file cache
		$_cache = value_for_key($attachment_name, $this->files_cache_local);
		unset($this->files_cache_local);
		return $_cache;
	}*/
}