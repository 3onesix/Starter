<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Admin Routes */
$route['admin/authenticate']			= "admin/account/action_authenticate";
$route['admin/signout']					= "admin/account/action_signout";
$route['admin/signin']					= "admin/account/action_signin";

$route['admin/(:any)/destroy/(:any)']	= "admin/$1/action_destroy/$2";
$route['admin/(:any)/update/(:num)']	= "admin/$1/action_update/$2";
$route['admin/(:any)/edit/(:num)']		= "admin/$1/action_edit/$2";
$route['admin/(:any)/create']	 		= "admin/$1/action_create";
$route['admin/(:any)/new']	 			= "admin/$1/action_new";
$route['admin/(:any)']					= "admin/$1/action_index";
$route['admin']							= "admin/dashboard/action_index";

if ( ENVIRONMENT == 'development' )
{
	$route['migrations/created']			= 'migrations/created';
	$route['migrations/create/(:any)']		= "migrations/create/$1";
	$route['migrations/seed']				= "migrations/seed";
	$route['migrations/reset']				= "migrations/reset";
	$route['migrations'] 					= 'migrations/index';
}

$route['default_controller'] = "home";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */