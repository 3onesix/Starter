<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Admin Routes */
$route['admin/authenticate']			= "admin/account/action_authenticate";
$route['admin/signout']					= "admin/account/action_signout";
$route['admin/signin']					= "admin/account/action_signin";
$route['admin/forgot_password']			= "admin/account/action_forgot";
$route['admin/forgot_password/([^\/]*)']	= "admin/account/action_forgot/$1";
$route['admin/forgot_password_process'] = "admin/account/action_forgot_process";
$route['admin/reset_password_process/([^\/]*)'] = "admin/account/action_reset_process/$1";

$route['admin/([^\/]*)/destroy/([^\/]*)']	= "admin/$1/action_destroy/$2";
$route['admin/([^\/]*)/update/(:num)']	= "admin/$1/action_update/$2";
$route['admin/([^\/]*)/edit/(:num)']		= "admin/$1/action_edit/$2";
$route['admin/([^\/]*)/create']	 		= "admin/$1/action_create";
$route['admin/([^\/]*)/new']	 			= "admin/$1/action_new";
$route['admin/([^\/]*)/([^\/]*)/([^\/]*)/([^\/]*)/([^\/]*)']	= "admin/$1/action_$2/$3/$4/$5";
$route['admin/([^\/]*)/([^\/]*)/([^\/]*)/([^\/]*)']	= "admin/$1/action_$2/$3/$4";
$route['admin/([^\/]*)/([^\/]*)/([^\/]*)']	= "admin/$1/action_$2/$3";
$route['admin/([^\/]*)/([^\/]*)']			= "admin/$1/action_$2";
$route['admin/([^\/]*)']					= "admin/$1/action_index";
$route['admin']							= "admin/dashboard/action_index";

$route['migrations/create/([^\/]*)']		= "migrations/create/$1";
$route['migrations/seed']				= "migrations/seed";
$route['migrations/reset']				= "migrations/reset";
$route['migrations'] 					= 'migrations/index';

$route['([^\/]*)'] = "front";

$route['default_controller'] = "front";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */