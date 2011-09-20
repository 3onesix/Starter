<?php

require_once APPPATH.'third_party/jot/classes/jot_unit_test_case.php';

class PageTestCase extends JotUnitTestCase
{	
	public $migration_path = 'db/migrate/';
		
	public function __construct()
	{
		parent::__construct();
	}
	
	public function setup()
	{
		$this->db->truncate('pages');
		$this->db->truncate('users');
	}
	
	public function test_slug_generate()
	{
		$page = new Page_Model;
		$page->name = "Title";
		$page->save();
		
		$this->assertEquals('title', $page->slug, 'I want the slug to be created automatically because the name exists.');		
	}	
	
	public function test_slug_attribute_function()
	{
		$page = new Page_Model;
		$page->slug = 'This is a title';
		
		$this->assertEquals('this-is-a-title', $page->slug, 'I want the slug to be lower case and with url formatting.');		
	}
	
	public function test_validate_name_fail()
	{
		$page = new Page_Model;
		$this->assertFalse($page->is_valid(), 'I want validation to fail because name is missing.');
	}
	
	public function test_validate_pass()
	{
		$page = new Page_Model;
		$page->name = 'Home';
		
		$this->assertTrue($page->is_valid(), 'I want validation to pass.');
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
		
		$this->assertEquals('John', $page->user->first_name, 'I want the page to belong to a user');
	}
}