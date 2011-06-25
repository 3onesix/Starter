<?php

class UserTestCase extends UnitTestCase
{
	public function __construct()
	{		
		
		$this->load->database();
		$this->load->dbutil();
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
		
		$this->assertTrue($user->errors(), 'User missing name.');
	}

	public function test_failed_missing_last_name_validation()
	{
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'username' => 'john_doe',
			'password' => 'test123',
			'confirm_password' => 'test123'		
		));
		
		$this->assertTrue($user->errors(), 'User missing name.');
	}
	
	public function test_failed_missing_username_validation()
	{
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'last_name' => 'Doe',
			'password' => 'test123',
			'confirm_password' => 'test123'		
		));
		
		$this->assertTrue($user->errors(), 'User missing username.');
	}

	public function test_failed_missing_password_validation()
	{
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'last_name' => 'Doe',
			'username' => 'john_doe',
		));
		
		$this->assertTrue($user->errors(), 'User missing password.');
	}

	public function test_failed_missing_password_confirm_validation()
	{
		$user = $this->user_model->create(array(
			'first_name' => 'John',
			'last_name' => 'Doe',
			'username' => 'john_doe',
			'password' => 'test123',
		));
		
		$this->assertTrue($user->errors(), 'User missing password confirm.');
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
		
		$this->assertFalse($user->errors(), 'User did validate.');		
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
		
		$this->assertEquals($encrypted_password, $user->password, 'Password should be encrypted');
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
		
		$this->assertTrue($authenticate, 'User authenticated');
	}
}