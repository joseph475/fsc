<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/signatorys']  			= 'signatory/api/signatory_controller/signatorys';
$route['api/signatory']  			= 'signatory/api/signatory_controller/signatory';
$route['api/signatory/id/(:num)'] 	= 'signatory/api/signatory_controller/signatory/id/$1';

// --------------------------------------------------------------------

$route['signatory-setup']  = 'signatory/signatory_controller';
