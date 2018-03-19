<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/divisions']  			= 'division/api/division_controller/divisions';
$route['api/division']  			= 'division/api/division_controller/division';
$route['api/division/id/(:num)'] 	= 'division/api/division_controller/division/id/$1';

// --------------------------------------------------------------------

$route['division-setup']  = 'division/division_controller';
