<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/flights']  				 = 'flight/api/flight_controller/flights';
$route['api/flight']  				 = 'flight/api/flight_controller/flight';
$route['api/flight/id/(:num)'] 		 = 'flight/api/flight_controller/flight/id/$1';
$route['api/flight/sched_id/(:num)'] = 'flight/api/flight_controller/flight/sched_id/$1';

// --------------------------------------------------------------------

$route['flight-schedule-list']  	= 'flight/flight_controller';
$route['flight-schedule']			= 'flight/flight_controller/assignment';
$route['flight-schedule/(:any)']	= 'flight/flight_controller/assignment/$1';

