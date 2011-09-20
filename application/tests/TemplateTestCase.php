<?php

require_once APPPATH.'third_party/jot/classes/jot_unit_test_case.php';

class TemplateTestCase extends JotUnitTestCase
{	
	public $migration_path = 'db/migrate/';
		
	public function __construct()
	{
		parent::__construct();
	}
	
	public function setup()
	{
		$this->db->truncate('templates');
	}

	public function test_validate_name_fail()
	{
		$template = new Template_Model;
		$this->assertFalse($template->is_valid(), 'I want validation to fail because name is missing.');
	}
	
	public function test_validate_pass()
	{
		$template = new Template_Model;
		$template->name = 'homepage';
		
		$this->assertTrue($template->is_valid(), 'I want validation to pass.');
	}
}