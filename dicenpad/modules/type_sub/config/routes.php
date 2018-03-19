<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/type_subs']  			= 'type_sub/api/type_sub_controller/type_subs';
$route['api/type_sub']  			= 'type_sub/api/type_sub_controller/type_sub';
$route['api/type_sub/id/(:num)'] 	= 'type_sub/api/type_sub_controller/type_sub/id/$1';

// --------------------------------------------------------------------

$route['sub-type-setup'] 		 	= 'type_sub/type_sub_controller';
