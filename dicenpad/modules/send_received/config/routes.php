<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/send_receiveds']  			= 'send_received/api/send_received_controller/send_receiveds';
$route['api/send_received']  			= 'send_received/api/send_received_controller/send_received';
$route['api/send_received/id/(:num)'] 	= 'send_received/api/send_received_controller/send_received/id/$1';

$route['api/sends']  					= 'send_received/api/send_controller/sends';

// --------------------------------------------------------------------

// $route['send-document']  		= 'send_received/send_received_controller';
// $route['received-document']  	= 'send_received/send_received_controller/received_docs';
