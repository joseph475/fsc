<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/types']  			= 'type/api/type_controller/types';
$route['api/type']  			= 'type/api/type_controller/type';
$route['api/type/id/(:num)'] 	= 'type/api/type_controller/type/id/$1';

// --------------------------------------------------------------------

$route['type-setup'] 		 	= 'type/type_controller';
