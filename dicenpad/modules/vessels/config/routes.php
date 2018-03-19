<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/vessels']  				= 'vessels/api/vessels_controller/vessels';
$route['api/vessel'] 				= 'vessels/api/vessels_controller/vessel';
$route['api/vessel/id/(:num)'] 		= 'vessels/api/vessels_controller/vessel/id/$1';

$route['api/vessels_docs']  		= 'vessels/api/vessels_docs_controller/vessels_docs';
$route['api/vessels_doc'] 			= 'vessels/api/vessels_docs_controller/vessels_doc';
$route['api/vessels_doc/id/(:num)'] = 'vessels/api/vessels_docs_controller/vessels_doc/id/$1';

$route['api/validitys']  			= 'vessels/api/validity_controller/validitys';
$route['api/validity'] 				= 'vessels/api/validity_controller/validity';
$route['api/validity/id/(:num)'] 	= 'vessels/api/validity_controller/validity/id/$1';

// --------------------------------------------------------------------

$route['vessels-master-list']  		= 'vessels/vessels_controller';
$route['vessel-entry']  			= 'vessels/vessels_controller/vessel_setup';
$route['vessel-entry/(:any)']  		= 'vessels/vessels_controller/show/$1';

$route['vessel-specification/(:any)']  	= 'vessels/vessels_controller/view/$1';

$route['vessel-redirect/(:any)'] 	= 'vessels/vessels_controller/vessel_redirect_url/$1';
