<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/admin_roles']  			= 'admin_role/api/admin_role_controller/admin_roles';
$route['api/admin_role']  			= 'admin_role/api/admin_role_controller/admin_role';
$route['api/admin_role/id/(:num)'] 	= 'admin_role/api/admin_role_controller/admin_role/id/$1';

// --------------------------------------------------------------------

$route['admin-role']  = 'admin_role/admin_role_controller';
