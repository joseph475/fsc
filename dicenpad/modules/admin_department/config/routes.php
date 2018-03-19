<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/admin_departments']  			= 'admin_department/api/admin_department_controller/admin_departments';
$route['api/admin_department']  			= 'admin_department/api/admin_department_controller/admin_department';
$route['api/admin_department/id/(:num)'] 	= 'admin_department/api/admin_department_controller/admin_department/id/$1';

// --------------------------------------------------------------------

$route['admin-department']  = 'admin_department/admin_department_controller';
