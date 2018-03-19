<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/admin_positions']  			= 'admin_position/api/admin_position_controller/admin_positions';
$route['api/admin_position']  			= 'admin_position/api/admin_position_controller/admin_position';
$route['api/admin_position/id/(:num)'] 	= 'admin_position/api/admin_position_controller/admin_position/id/$1';

// --------------------------------------------------------------------

$route['admin-position']  = 'admin_position/admin_position_controller';
