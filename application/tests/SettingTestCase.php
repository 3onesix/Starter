<?php

require_once APPPATH.'third_party/jot/test/JotUnitTestCase.php';

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
			
		$this->assertFalse($setting->is_valid(), 'Key is required');		
	}
	
	public function test_validation_pass()
	{
		$setting = new Setting_Model;
		$setting->key = "test";
		$setting->value = "Test";
		
		$this->assertTrue($setting->is_valid(), 'Validation Pass');		
	}
	
	public function test_helper()
	{
		$this->assertEquals(NULL, setting('test'), 'Helper did not find setting');
		
		setting('test', 'Test');
				
		$this->assertEquals('Test', setting('test'), 'Helper works');
	}
}