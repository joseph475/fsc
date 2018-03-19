<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/uat/login']  = 'uat/api/uat_controller/login';
$route['api/uat/access']  = 'uat/api/uat_controller/access';

// --------------------------------------------------------------------

$route['uat/login']  = 'uat/uat_controller/login';
$route['uat/get_redirect_url']  = 'uat/uat_controller/get_redirect_url';
$route['logout']  = 'uat/uat_controller/logout';
$route['uat/client_login']  = 'uat/uat_controller/client_login';
