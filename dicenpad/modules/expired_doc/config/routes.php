<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/expired_docs']  		= 'expired_doc/api/expired_doc_controller/expired_docs';
$route['api/expired_doc']  			= 'expired_doc/api/expired_doc_controller/expired_doc';
$route['api/expired_doc/id/(:num)'] = 'expired_doc/api/expired_doc_controller/expired_doc/id/$1';

// --------------------------------------------------------------------

$route['expiry-per-documents']  = 'expired_doc/expired_doc_controller';
$route['expiry-per-crew']  		= 'expired_doc/expired_doc_controller/crew_expiry';
