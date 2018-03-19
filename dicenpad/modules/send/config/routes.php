<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/sends']  			= 'send/api/send_controller/sends';
$route['api/send']  			= 'send/api/send_controller/send';
$route['api/send/id/(:num)'] 	= 'send/api/send_controller/send/id/$1';

// --------------------------------------------------------------------

$route['send-document']  		= 'send/send_controller';
