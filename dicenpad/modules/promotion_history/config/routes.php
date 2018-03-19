<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/promotion_historys']  			= 'promotion_history/api/promotion_history_controller/promotion_historys';
$route['api/promotion_history']  			= 'promotion_history/api/promotion_history_controller/promotion_history';
$route['api/promotion_history/id/(:num)'] 	= 'promotion_history/api/promotion_history_controller/promotion_history/id/$1';

// --------------------------------------------------------------------

$route['promotion-history']  = 'promotion_history/promotion_history_controller';
