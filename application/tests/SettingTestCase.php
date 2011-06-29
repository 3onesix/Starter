<?php

require_once APPPATH.'third_party/jot/classes/jot_unit_test_case.php';

class SettingTestCase extends JotUnitTestCase
{	
	public $migration_path = 'db/migrate/';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function test_validate_key_fail()
	{
		$setting = new Setting_Model;
			
		$this->assertFalse($setting->is_valid(), 'I want validation to fail because the key is missing.');		
	}
	
	public function test_validation_pass()
	{
		$setting = new Setting_Model;
		$setting->key = "test";
		$setting->value = "Test";
		
		$this->assertTrue($setting->is_valid(), 'I want validation to pass.');		
	}
	
	public function test_helper()
	{
		$this->assertEquals(NULL, setting('test'), 'I want to return NULL because setting was not found.');
		
		setting('test', 'Test');
				
		$this->assertEquals('Test', setting('test'), 'I want to return a value because a value should exist.');
	}
}