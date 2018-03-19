<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/flags']  			= 'flag/api/flag_controller/flags';
$route['api/flag']  			= 'flag/api/flag_controller/flag';
$route['api/flag/id/(:num)'] 	= 'flag/api/flag_controller/flag/id/$1';

// --------------------------------------------------------------------

$route['flag-setup']  = 'flag/flag_controller';
