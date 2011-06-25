<?php

class User_Model extends My_Model
{
	public function init()
	{
		$this->transient('confirm_password');
		$this->before_save('encrypt_password');
		
		$this->validates('first_name', 'required');
		$this->validates('last_name', 'required');
		$this->validates('username', array('required', 'uniqueness'=>array('exclude_self'=>TRUE)));
		$this->validates('password', array('required', 'confirm'));
	}
	
	protected function encrypt_password()
	{
		$password = md5($this->read_attribute('password'));
		$this->write_attribute('password', $password);
	}
	
	public function authenticate($username, $password)
	{	
		return $this->exists(array(
			'username' => $username,
			'password' => $password
		));
	}
}