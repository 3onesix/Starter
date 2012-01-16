<?php

class User_Model extends My_Model
{
	protected $encrypt = TRUE;
	
	public function init()
	{
		$this->before_save('encrypt_password');
		
		$this->validates('first_name', 'required');
		$this->validates('last_name', 'required');
		$this->validates('username', array('required', 'uniqueness'=>array('exclude_self'=>TRUE)));
		$this->validates('password', array('confirm'));
		$this->validates('email', array('required', 'uniqueness'=>array('exclude_self'=>TRUE)));
		$this->has_one('role');
		
		$this->before_validation('check_password');
	}
	
	public function is_me()
	{
		return $this->read_attribute('id') == current_user()->read_attribute('id');
	}
	
	protected function check_password()
	{	
    	if ( ($this->is_me() && ! is_blank($this->read_attribute('password'))) || ! $this->persisted() )
		{
			$this->validates('password', array('required', 'confirm'));
		}
		else
		{
			$this->encrypt = FALSE;
    		unset($this->attributes['password'], $this->attributes['confirm_password']);
		}
	}
	
	protected function encrypt_password()
	{
		if ( $this->read_attribute('password') == $this->read_attribute('confirm_password') && $this->encrypt )
		{
			$password = md5($this->read_attribute('password'));
			$this->write_attribute('password', $password);
		}
	}
	
	public function authenticate($username, $password)
	{
		if ($username && $password) {
			return $this->first(array(
				'username' => $username,
				'password' => $password
			));
		}
		else {
			return false;
		}
	}
	
	public function permission($module, $key)
	{
		$module = $this->module_model->first(array('simple_name' => $module));
		if ($module)
		{
			$permission = $this->role->permissions->first(array(
				'module_id' => $module->id,
				'key'       => $key
			));
			return $permission ? $permission->value : false;
		}
		else
		{
			$permission = $this->role->permissions->first(array(
				'module_id' => 0,
				'key'       => $module.'_'.$key
			));
			return $permission ? $permission->value : false;
		}
		return false;
	}
}