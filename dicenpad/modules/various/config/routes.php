<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//-----------------[ API ] ------------------------
$route['api/variouss']  			= 'various/api/various_controller/variouss';
$route['api/draftvariouss']  			= 'various/api/various_controller/draftvariouss';

$route['api/document_variouss']  					= 'various/api/document_various_controller/document_variouss';
$route['api/document_various']  					= 'various/api/document_various_controller/document_various';
$route['api/document_various/id/(:num)'] 			= 'various/api/document_various_controller/document_various/id/$1';

//-----------------[ FRONT ] ------------------------
$route['various-list']  			= 'various/various_controller/index';
$route['draft-various-list']  		= 'various/various_controller/draft_list';