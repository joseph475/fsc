<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/checklists']  			= 'checklist/api/checklist_controller/checklists';
$route['api/checklist']  			= 'checklist/api/checklist_controller/checklist';
$route['api/checkload']  			= 'checklist/api/checklist_controller/checkload';
$route['api/checklist/id/(:num)'] 	= 'checklist/api/checklist_controller/checklist/id/$1';

// --------------------------------------------------------------------

$route['check-list']  		= 'checklist/checklist_controller';
$route['checklist-setup']  	= 'checklist/checklist_controller/document_setup';
