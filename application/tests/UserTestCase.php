<?php

require_once APPPATH.'third_party/jot/test/JotUnitTestCase.php';

class UserTestCase extends JotUnitTestCase
{	
	public $migration_path = 'db/migrate/';

	public function __construct()
	{
		parent::__construct();
	}
	
	public function setup()
	{
		$this->db->truncate('users');
		$this->db->truncate('pages');
	}

	public function test_failed_missing_first_name_validation()
	{
		$user = $this->user_model->create(array(
			'last_name' => 'Doe',
			'username' => 'john_doe',
			'password' => 'test123',
			'confirm_password' => 'test123'		
		));
		
		$this->assertTrue($user->errors(), 'I want validation to fail because first name is missing.');
	}

	public function test_failed_missing_last_name_validation()
	{
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'username' => 'john_doe',
			'password' => 'test123',
			'confirm_password' => 'test123'		
		));
		
		$this->assertTrue($user->errors(), 'I want validation to fail because last name is missing.');
	}
	
	public function test_failed_missing_username_validation()
	{
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'last_name' => 'Doe',
			'password' => 'test123',
			'confirm_password' => 'test123'		
		));
		
		$this->assertTrue($user->errors(), 'I want validation to fail because username is missing.');
	}

	public function test_failed_missing_password_validation()
	{
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'last_name' => 'Doe',
			'username' => 'john_doe',
		));
		
		$this->assertTrue($user->errors(), 'I want validation to fail because password is missing.');
	}

	public function test_failed_missing_password_confirm_validation()
	{
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'last_name' => 'Doe',
			'username' => 'john_doe',
			'password' => 'test123',
		));
		
		$this->assertTrue($user->errors(), 'I want validation to fail because password does not confirm.');
	}
	
	public function test_pass_validation()
	{
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'last_name' => 'Doe',
			'username' => 'john_doe',
			'password' => 'test123',
			'confirm_password' => 'test123'
		));
		
		$this->assertTrue($user->errors(), 'I want validation to pass.');
	}
	
	public function test_encrypt_password()
	{
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'last_name' => 'Doe',
			'username' => 'john_doe',
			'password' => 'test123',
			'confirm_password' => 'test123'
		));

		$encrypted_password = md5('test123');
		
		$this->assertEquals($encrypted_password, $user->password, 'I want the password to be a md5 hash.');
	}
	
	public function test_authenticate()
	{	
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'last_name' => 'Doe',
			'username' => 'john_doe',
			'password' => 'test123',
			'confirm_password' => 'test123'
		));
				
		$authenticate = $this->user_model->authenticate('john_doe', md5('test123'));	
		
		$this->assertTrue($authenticate, 'I want the user to authenticate. User should exist.');
	}
}