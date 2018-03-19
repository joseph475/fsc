<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/schedules']  			= 'schedule/api/schedule_controller/schedules';
$route['api/schedule']  			= 'schedule/api/schedule_controller/schedule';
$route['api/schedule/id/(:num)'] 	= 'schedule/api/schedule_controller/schedule/id/$1';
$route['api/schedule/ref/(:any)'] 	= 'schedule/api/schedule_controller/schedule/ref/$1';

$route['api/candidates']  			= 'schedule/api/candidate_controller/candidates';
$route['api/finisheds']  			= 'schedule/api/finished_controller/finisheds';
$route['api/endorses']  			= 'schedule/api/endorse_controller/endorses';
$route['api/assign_pos']  			= 'schedule/api/assign_position_controller/assign_positions';

$route['api/joinings']  			= 'schedule/api/joining_controller/joinings';
$route['api/joining']  				= 'schedule/api/joining_controller/joining';
$route['api/joining/id/(:num)'] 	= 'schedule/api/joining_controller/joining/id/$1';
$route['api/joining2/id/(:num)'] 	= 'schedule/api/joining_controller/joining2/id/$1';
$route['api/joining/ref/(:any)'] 	= 'schedule/api/joining_controller/joining/ref/$1';

$route['api/repats']  				= 'schedule/api/repat_controller/repats';
$route['api/repat']  				= 'schedule/api/repat_controller/repat';
$route['api/repat/id/(:num)'] 		= 'schedule/api/repat_controller/repat/id/$1';
$route['api/repat2/id/(:num)'] 		= 'schedule/api/repat_controller/repat2/id/$1';

$route['api/promotions']  			= 'schedule/api/promotion_controller/promotions';
$route['api/promotion']  			= 'schedule/api/promotion_controller/promotion';
$route['api/promotion/id/(:num)'] 	= 'schedule/api/promotion_controller/promotion/id/$1';
$route['api/promotion2/id/(:num)'] 	= 'schedule/api/promotion_controller/promotion2/id/$1';

// --------------------------------------------------------------------

$route['schedule-list']  				= 'schedule/schedule_controller';
$route['schedule-replacement']			= 'schedule/schedule_controller/create_schedule_header';
$route['schedule-replacement/(:any)']	= 'schedule/schedule_controller/show/$1';

$route['schedule-redirect/(:any)']  	= 'schedule/schedule_controller/schedule_redirect_url/$1';

