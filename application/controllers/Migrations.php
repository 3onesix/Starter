<?php
class Migrations extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper(array('directory','migrations_helper'));

		// Setup Migrations
		migrations_directory_setup();
	}
	
	function index()
	{	
		migration_up();
		
		echo 'Migrations run';
	}
	
	function seed()
	{
		include(db_path().'seed.php');
	}
	
	function reset()
	{
		$query = $this->db->query("SHOW TABLES");

		foreach ($query->result_array() as $row) {
			$name = current($row);
			
			$this->db->query("DROP TABLE ".$name);
		}
		
		migration_up();
		
		$this->seed();
		
		echo 'Reset Run';
	}
	
	function created()
	{
		echo 'Migration Created';
	}
	
	function create($path)
	{
		create_migration($path);

		$CI =& get_instance();
		$CI->load->helper('url');
		redirect('migrations/created');
	}
}