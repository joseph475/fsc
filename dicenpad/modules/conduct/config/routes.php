<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/conducts']  			= 'conduct/api/conduct_controller/conducts';
$route['api/conduct']  				= 'conduct/api/conduct_controller/conduct';
$route['api/conduct/id/(:num)'] 	= 'conduct/api/conduct_controller/conduct/id/$1';

$route['api/conduct_rep1s']  		= 'conduct/api/conduct_rep1_controller/conduct_rep1s';
$route['api/conduct_rep2s']  		= 'conduct/api/conduct_rep1_controller/conduct_rep2s';
// --------------------------------------------------------------------

$route['conduct-setup']  = 'conduct/conduct_controller';
