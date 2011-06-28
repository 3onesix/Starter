<?php

require_once APPPATH.'third_party/jot/test/JotUnitTestCase.php';

class PageVariableTestCase extends JotUnitTestCase
{	
	public $migration_path = 'db/migrate/';
		
	public function __construct()
	{
		parent::__construct();
	}
	
	public function setup()
	{
		$this->db->truncate('page_variables');
		$this->db->truncate('pages');
		$this->db->truncate('templates');
	}
	
	public function test_validate_name_fail()
	{
		$page_variable = new Page_Variable_Model;
		$page_variable->page_id = 1;
		$page_variable->template_id = 1;
		$this->assertFalse($page_variable->is_valid(), 'I want validation to fail because name is missing.');
	}
	
	public function test_validate_page_id_fail()
	{
		$page_variable = new Page_Variable_Model;
		$page_variable->name = 'title';
		$page_variable->template_id = 1;
		$this->assertFalse($page_variable->is_valid(), 'I want validation to fail because page_id is missing.');
	}

	public function test_validate_template_id_fail()
	{
		$page_variable = new Page_Variable_Model;
		$page_variable->name = 'title';
		$page_variable->page_id = 1;
		$this->assertFalse($page_variable->is_valid(), 'I want validation to fail because template_id is missing.');
	}
	
	public function test_validate_pass()
	{
		$page_variable = new Page_Variable_Model;
		$page_variable->name = 'title';
		$page_variable->page_id = 2;
		$page_variable->template_id = 1;
		
		$this->assertTrue($page_variable->is_valid(), 'I want validation to pass.');
	}
}