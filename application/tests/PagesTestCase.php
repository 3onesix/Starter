<?php

class PagesTestCase extends UnitTestCase
{
	public function __construct()
	{		
		$this->load->database();
		$this->load->dbutil();
	}
	
	public function setup()
	{
		$this->db->truncate('pages');
		$this->db->truncate('users');
	}
	
	public function test_validate_name_fail()
	{
		$page = new Page_Model;
		$this->assertFalse($page->is_valid(), 'Name is required');
	}
	
	public function test_validate_pass()
	{
		$page = new Page_Model;
		$page->name = 'Home';
		
		$this->assertTrue($page->is_valid(), 'Validation Pass');
	}
	
	public function test_belongs_to_user()
	{
		$page = new Page_Model;
		$page->name = 'Home';
		$page->user = $this->user_model->create(array(
			'first_name' => 'John',
			'last_name' => 'Doe',
			'username' => 'johndoe',
			'password' => 'test',
			'confirm_password' => 'test'
		));
		$page->save();
		
		$this->assertEquals('John', $page->user->first_name, 'Page belongs to user');
	}
}