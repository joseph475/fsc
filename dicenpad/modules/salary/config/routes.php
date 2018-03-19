<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/salarys']  = 'salary/api/salary_controller/salarys';
$route['api/salary']  = 'salary/api/salary_controller/salary';
$route['api/salary/id/(:num)'] = 'salary/api/salary_controller/salary/id/$1';

// --------------------------------------------------------------------

$route['salary-breakdown']  = 'salary/salary_controller';
