<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['api/search_vessel']  					= 'search/api/search_vessel_controller/search_vessel';
$route['api/drop_crewlists']  					= 'search/api/search_vessel_controller/drop_crewlists';
// $route['api/crew_lists']						= 'search/api/crew_list_controller/crew_lists';
// $route['api/crew_list'] 						= 'search/api/crew_list_controller/crew_list';
// $route['api/crew_list/id/(:num)'] 			= 'search/api/crew_list_controller/crew_list/id/$1';

// --------------------------------------------------------------------

$route['search-by-crew']  				= 'search/search_controller';
$route['search-by-crew-principal']  	= 'search/search_controller/crew_principal';
$route['search-by-vessel']  			= 'search/search_controller/vessel_search';
$route['crew-list']  					= 'search/search_controller/execute_search_vessel';
$route['crew-history-card']  			= 'search/search_controller/execute_search_crew';
$route['crew-history-card/(:num)']  	= 'search/search_controller/execute_search_crew/$1';