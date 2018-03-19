<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/logs']  			= 'log/api/log_controller/logs';
$route['api/log']  				= 'log/api/log_controller/log';
$route['api/log/id/(:num)'] 	= 'log/api/log_controller/log/id/$1';

// --------------------------------------------------------------------

$route['log-history']  			= 'log/log_controller';
