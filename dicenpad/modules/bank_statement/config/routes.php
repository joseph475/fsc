<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//-----------------[ API ] ------------------------

$route['api/bank_statements']					= 'bank_statement/api/bank_statement_controller/bank_statements';
$route['api/bank_statement'] 					= 'bank_statement/api/bank_statement_controller/bank_statement';
$route['api/bank_statement/id/(:num)'] 			= 'bank_statement/api/bank_statement_controller/bank_statement/id/$1';

$route['api/bank_statement_details']			= 'bank_statement/api/bank_statement_detail_controller/bank_statement_details';
$route['api/bank_statement_detail'] 			= 'bank_statement/api/bank_statement_detail_controller/bank_statement_detail';
$route['api/bank_statement_detail/id/(:num)'] 	= 'bank_statement/api/bank_statement_detail_controller/bank_statement_detail/id/$1';

//-----------------[ FRONT ] ------------------------
$route['bank-statement']  						= 'bank_statement/bank_statement_controller';
$route['bank-statement-details/(:any)']  		= 'bank_statement/bank_statement_controller/bank_statement_details/$1';