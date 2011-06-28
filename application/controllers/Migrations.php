<?php
class Migrations extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper(array('directory','jot_migrations'));	
	}
	
	function index()
	{
		$migrations = new JotMigrations();
		$migrations->up();
					
		// echo 'Migrations run';
	}
	
	function reset()
	{		
		$migrations = new JotMigrations();
		$migrations->reset(TRUE);

		// echo 'Reset Run';
	}
	
	function created()
	{
		// echo 'Migration Created';
	}
	
	function create($path)
	{
		$migrations = new JotMigrations();
		$migrations->create($path);

		$CI =& get_instance();
		$CI->load->helper('url');
		redirect('migrations/created');
	}
}