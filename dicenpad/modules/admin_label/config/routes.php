<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/admin_labels']  			= 'admin_label/api/admin_label_controller/admin_labels';
$route['api/admin_label']  				= 'admin_label/api/admin_label_controller/admin_label';
$route['api/admin_label/id/(:num)'] 	= 'admin_label/api/admin_label_controller/admin_label/id/$1';

// --------------------------------------------------------------------

$route['admin-label']  					= 'admin_label/admin_label_controller';
