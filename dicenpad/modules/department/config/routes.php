<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/departments']  = 'department/api/department_controller/departments';
$route['api/department']  = 'department/api/department_controller/department';
$route['api/department/id/(:num)'] = 'department/api/department_controller/department/id/$1';

// --------------------------------------------------------------------

$route['department-setup']  = 'department/department_controller';
