<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API URL
$route['api/options']  				= 'admin_options/api/options_controller/options';
$route['api/option']  				= 'admin_options/api/options_controller/option';
$route['api/option/id/(:num)']  	= 'admin_options/api/options_controller/option/id/$1';

$route['api/options2']  			= 'admin_options/api/options2_controller/options2';
$route['api/option2']  				= 'admin_options/api/options2_controller/option2';
$route['api/option2/id/(:num)']  	= 'admin_options/api/options2_controller/option2/id/$1';
$route['api/options3']  			= 'admin_options/api/options2_controller/options3';

// Frontend routes
$route['options-setup'] = 'admin_options/options_controller/index';