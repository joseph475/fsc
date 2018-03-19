<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/documents']  			= 'document/api/document_controller/documents';
$route['api/document']  			= 'document/api/document_controller/document';
$route['api/document/id/(:num)'] 	= 'document/api/document_controller/document/id/$1';

// --------------------------------------------------------------------

$route['document-list']  = 'document/document_controller';
