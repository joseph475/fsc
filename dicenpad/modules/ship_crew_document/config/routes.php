<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/sc_docs']  				= 'ship_crew_document/api/ship_crew_document_controller/ship_crew_documents';
$route['api/sc_doc']  				= 'ship_crew_document/api/ship_crew_document_controller/ship_crew_document';
$route['api/sc_doc/id/(:num)'] 		= 'ship_crew_document/api/ship_crew_document_controller/ship_crew_document/id/$1';

//-----------------[ FRONT ] ------------------------
$route['ship-crew-documents']  		= 'ship_crew_document/ship_crew_document_controller';