<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/principals']  				= 'principal/api/principal_controller/principals';
$route['api/principal']  				= 'principal/api/principal_controller/principal';
$route['api/principal/hash/(:any)'] 	= 'principal/api/principal_controller/principal/hash/$1';
$route['api/principal/id/(:num)'] 		= 'principal/api/principal_controller/principal/id/$1';

// --------------------------------------------------------------------

$route['principal-master-list']  	= 'principal/principal_controller';
$route['principal-entry']  			= 'principal/principal_controller/principal_entry';
$route['principal-entry/(:any)']  	= 'principal/principal_controller/show/$1';

$route['principal-resume/(:any)']  	= 'principal/principal_controller/view/$1';

$route['principal-redirect/(:any)'] = 'principal/principal_controller/principal_redirect_url/$1';