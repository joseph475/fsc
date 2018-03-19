<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/receiveds']  			= 'received/api/received_controller/receiveds';
$route['api/received']  			= 'received/api/received_controller/received';
$route['api/received/id/(:num)'] 	= 'received/api/received_controller/received/id/$1';

// --------------------------------------------------------------------

$route['received-document']  		= 'received/received_controller';
