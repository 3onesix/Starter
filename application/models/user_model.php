<?php

class User_Model extends My_Model
{
	public function init()
	{
		$this->before_save('encrypt_password');
		
		$this->validates('first_name', 'required');
		$this->validates('last_name', 'required');
		$this->validates('username', array('required', 'uniqueness'=>array('exclude_self'=>TRUE)));
		$this->validates('password', array('required', 'confirm'));
		$this->has_one('role');
	}
	
	protected function encrypt_password()
	{
		if ( $this->read_attribute('password') == $this->read_attribute('confirm_password') )
		{
			$password = md5($this->read_attribute('password'));
			$this->write_attribute('password', $password);
		}
	}
	
	public function authenticate($username, $password)
	{
		if ($username && $password) {
			return $this->exists(array(
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