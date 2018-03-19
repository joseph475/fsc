<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['api/checklist_crews']  		= 'crew_checklist/api/crew_checklist_controller/checklist_crews';
$route['api/checklist_endorse_crews']  		= 'crew_checklist/api/crew_checklist_controller/checklist_endorse_crews';
$route['api/checklist_crew']  		= 'crew_checklist/api/crew_checklist_controller/checklist_crew';

// --------------------------------------------------------------------

$route['crew-checklist']  		= 'crew_checklist/crew_checklist_controller/crew_checklist';
$route['crew-checklist/(:any)'] = 'crew_checklist/crew_checklist_controller/crew_checklist/$1';