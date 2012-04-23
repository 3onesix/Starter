<?php

class MY_Controller extends CI_Controller 
{
	var $_database, $_setup, $_migrate;
	
	protected $config_pagination = array(
		'per_page' => 10,
		'full_tag_open' => '<div id="pagination">',
		'full_tag_close' => '</div>'
	);
	private $models = array();
	
	public $current_user = NULL;
	
	protected function config_pagination() {}
	
	public function __construct() 
	{
		parent::__construct();

		# I just set the timezone to Chicago. Farely important for
		# migrations to run properly
		date_default_timezone_set('America/Chicago');
		
		# Does a database config file not exist
		if ( ! file_exists(APPPATH.'config/database'.EXT) )
		{
			$this->_database = TRUE;
		}
		else
		{
			$this->load->database();
			
			# Load Helpers
			$this->load->helper('jot_migrations_helper');

			$migrations = new JotMigrations();

			# Migration Schema Info
			$schema_version = JotSchema::version();
			$migration_version = $migrations->latest_version();
							
			# Do we need an update
			if ( $schema_version < $migration_version )
			{
				$this->_migrate = TRUE;
			}
			else
			{
				$this->load->model('user_model');
		
				$peopleCount = $this->user_model->count();

				# We need to create a user
				if ( $peopleCount == 0 )
				{
					$this->_setup = TRUE;
				}
				
				# Nope, were good. Move forward!
				else
				{
					$this->_setup = FALSE;
				}
				
				# Login is required
				if ( $this->_setup == FALSE && isset($this->require_login) )
				{
					$this->load->library('session');
					
					$user = $this->session->userdata('user');
					$username = value_for_key('username', $user);
					$password = value_for_key('password', $user);
					
					if ( ! $this->user_model->authenticate($username, $password) )
					{
						$this->session->set_userdata('redirect_to', current_url());
						redirect('admin/signin');
					}
					
					$this->current_user = $username ? $this->user_model->first(array(
						'username' => $username
					)) : NULL;

					if (is_array($this->models))
					{
						foreach ($this->models as $m) $this->load->model($m);
					}
				}
			}
		}
	}
	
	public function _remap($method)
	{
		if ( isset($this->_setup) && $this->_setup == TRUE )
		{
			$this->setup();
		}
		elseif ( isset($this->_migrate) && $this->_migrate == TRUE )
		{
			$this->migration_up();
		}
		elseif ( isset($this->_database) && $this->_database == TRUE )
		{
			$this->setup_database();
		}
		else
		{
			$segments = array_slice($this->uri->rsegment_array(), 2);
			call_user_func_array(array(&$this, $method), $segments);
		}
	}
	
	public function setup()
	{
		$user = flash_jot('user');
		
		if ( $data = $this->input->post('user') )
		{
			$user->update_attributes($data);

			if ( ! $user->errors() )
			{
				redirect('admin');
			}
		}
		
		$this->load->view('admin/setup/user', array('user' => $user));
	}
	
	public function support()
	{
		$required_php_version	= '5.1.6';
		$required_mysql_version	= '5.0';
		$errors = array();

		if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'],'IIS') !== false)
		{
			$errors[] = 'Microsoft IIS is not supported.';
		}

		// Check PHP version
		if (!version_compare(PHP_VERSION, $required_php_version, 'ge'))
		{
			$errors[] = 'PHP '.$required_php_version.' or higher is required. This server is running PHP '.PHP_VERSION.'.';
		}
		
		// Check MySQL version
		$extensions = get_loaded_extensions();
		if (!in_array('mysql', $extensions))
		{
			$errors[] = 'PHP on this server does not appear to be compiled with support for MySQL. MySQL '.$required_mysql_version.' or higher is required.';
		}
		else
		{
			$mysql_version = mysql_get_client_info();
			$mysql_version = preg_replace('#(^\D*)([0-9.]+).*$#', '\2', $mysql_version); // strip extra-version cruft
			if (!version_compare($mysql_version, $required_mysql_version, 'ge'))
			{
				$errors[] = 'MySQL '.$required_mysql_version.' or higher is required. This server is running MySQL '.$mysql_version.'.';
			}
		}

		if (!in_array('gd', $extensions))
		{
			$errors[] = 'GD is required for image manipulation';
		}		
		
		return $errors;
	}
		
	public function migration_up()
	{
		if ( array_key_exists('migrate', $_GET) )
		{
			$migrations = new JotMigrations;
			$migrations->up();
			redirect('');
		}
		
		$schema_exists = JotSchema::exists();
		$this->load->view('admin/setup/migrations', array(
			'app_name' => $this->config->item('starter_product_name'),
			'schema_exists' => $schema_exists
		));
	}
	
	public function setup_database()
	{
		$error = '';
		
		if ( array_key_exists('compat', $_GET) )
		{
			$host = $this->input->post('host');
			$database = $this->input->post('database');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			
			if ( strlen($database) && strlen($username) && strlen($password) )
			{
				$link = @mysql_connect($host, $username, $password);
				
				# No connection
				if ( $link )
				{
					$db = mysql_select_db($database, $link);
				
					if ( $db )
					{
						$path = APPPATH.'config/database'.EXT;

						$data = '<?php if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');
						$active_group = "default";
						$active_record = TRUE;

						$db[\'default\'][\'hostname\'] = "'.$host.'";
						$db[\'default\'][\'username\'] = "'.$username.'";
						$db[\'default\'][\'password\'] = "'.$password.'";
						$db[\'default\'][\'database\'] = "'.$database.'";
						$db[\'default\'][\'dbdriver\'] = "mysql";
						$db[\'default\'][\'dbprefix\'] = "";
						$db[\'default\'][\'pconnect\'] = TRUE;
						$db[\'default\'][\'db_debug\'] = TRUE;
						$db[\'default\'][\'cache_on\'] = FALSE;
						$db[\'default\'][\'cachedir\'] = "";
						$db[\'default\'][\'char_set\'] = "utf8";
						$db[\'default\'][\'dbcollat\'] = "utf8_general_ci";

						?>';

						file_put_contents($path, $data);
					
						if ( file_exists($path) )
						{
							redirect('admin');
						}
						else
						{
							$data = 'Couldn\'t write database.php file. Check folder permissions.';
						}
					}
					else
					{
						$error = 'Database doesn\'t exist. (You did connect to mysql server!)';
					}
				}
				else
				{
					$error = 'Connection information incorrect';				
				}
			}
			else
			{
				$error = 'All fields are required.';
			}
			
			$this->load->view('admin/setup/database', array(
				'error' => $error
			));
		}
		else
		{
			$errors = $this->support();
			$this->load->view('admin/setup/compatability', array('errors' => $errors));
		}
	}
}