<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API URL
$route['api/message']  = 'message/api/message_controller/message';
$route['api/message/id/(:num)']  = 'message/api/message_controller/message/id/$1';
$route['api/messages']  = 'message/api/message_controller/messages';
$route['api/user/id/(:num)/messages']  = 'message/api/user_controller/message/user_id/$1';
$route['api/user/id/(:num)/message']  = 'message/api/user_controller/message/user_id/$1';