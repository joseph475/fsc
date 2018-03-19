<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/master_forms']  			= 'master_form/api/master_form_controller/master_forms';
$route['api/master_form']  				= 'master_form/api/master_form_controller/master_form';
$route['api/master_form/id/(:num)'] 	= 'master_form/api/master_form_controller/master_form/id/$1';

// --------------------------------------------------------------------

$route['master-form-setup']  = 'master_form/master_form_controller';
