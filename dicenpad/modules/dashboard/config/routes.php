<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/dashboard/login']  = 'dashboard/api/dashboard_controller/login';
$route['api/dashboard/access']  = 'dashboard/api/dashboard_controller/access';

$route['api/tops']  = 'log/api/top_controller/tops';

// --------------------------------------------------------------------

$route['admin']  = 'dashboard/dashboard_controller';
