<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/positions']  			= 'position/api/position_controller/positions';
$route['api/position']  			= 'position/api/position_controller/position';
$route['api/position/id/(:num)'] 	= 'position/api/position_controller/position/id/$1';

// --------------------------------------------------------------------

$route['position-setup']  = 'position/position_controller';
