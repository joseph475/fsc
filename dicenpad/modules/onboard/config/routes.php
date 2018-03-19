<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/crew_status']  					= 'onboard/api/crew_status_controller/crew_status';
$route['api/crew_vessels']  				= 'onboard/api/onboard_controller/crew_vessels';
$route['api/onboards']  					= 'onboard/api/onboard_controller/onboards';
$route['api/onboard']  						= 'onboard/api/onboard_controller/onboard';
$route['api/onboard/cid/(:num)'] 			= 'onboard/api/onboard_controller/onboard/cid/$1';
$route['api/onboard/id/(:num)'] 			= 'onboard/api/onboard_controller/onboard/id/$1';

$route['api/onpromote']  						= 'onboard/api/onboard_controller/onpromote';

// --------------------------------------------------------------------

$route['onboard-status']  			= 'onboard/onboard_controller/index';
$route['embarkation-list']  		= 'onboard/onboard_controller/embarkation_list';
$route['disembarkation-list']  		= 'onboard/onboard_controller/disembarkation_list';
