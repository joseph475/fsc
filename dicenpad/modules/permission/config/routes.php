<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/permissions']  			= 'permission/api/permission_controller/permissions';
$route['api/permission']  			= 'permission/api/permission_controller/permission';
$route['api/permission/id/(:num)'] 	= 'permission/api/permission_controller/permission/id/$1';

// --------------------------------------------------------------------

$route['user-permission']  = 'permission/permission_controller';
