<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//----------------------------- [ REPORT PDF ] ------------------------------------//
$route['report-generator']							= 'report/report_generator_controller/generate_report';
$route['report-generator2']							= 'report/report_generator_controller/generate_report2';
$route['report-generator3']							= 'report/report_generator_controller/generate_report3';


$route['poea-contract/(:any)']  					= 'report/document_report_controller/poea_contract/$1';
$route['poea-info-sheet/(:any)']  					= 'report/document_report_controller/poea_information_sheet/$1';
$route['rps-regular/(:any)']  						= 'report/document_report_controller/rps_regular/$1';
$route['rps-verification/(:any)']  					= 'report/document_report_controller/rps_verification/$1';
$route['table-content-document/(:any)']   			= 'report/document_report_controller/table_content/$1';
$route['expired-docs-report/(:any)']   				= 'report/document_report_controller/expired_document/$1';
$route['report/seafarer-employment-contract/(:any)']= 'report/document_report_controller/seafarer_document/$1';

$route['checklist-list-type/(:num)']  				= 'report/document_report_controller/checklist_list/$1';
$route['checklist/grid-type']  						= 'report/document_report_controller/crew_checklist';
$route['checklist/grid-type-endorse']  				= 'report/document_report_controller/crew_checklist_endorse';
$route['checklist/list-type']  						= 'report/document_report_controller/crew_checklist_list';
$route['checklist/memo-type/(:num)']  				= 'report/document_report_controller/crew_checklist_memo/$1';

$route['schedule-for-crew-replacement/(:any)']  		= 'report/schedule_report_controller/schedule_replacement/$1';
$route['schedule-for-crew-replacement-santoku/(:any)']  	= 'report/schedule_report_santoku_controller/schedule_replacement/$1';

$route['report/contract-review-replacement-plan/(:any)']  	= 'report/schedule_report_controller/contract_review/$1';
$route['daily-replacement-plan/(:any)']  			= 'report/schedule_report_controller/daily_replacement_plan/$1';
$route['ammended-list-of-candidates/(:any)']  		= 'report/schedule_report_controller/ammended_list/$1';
$route['report/embarkation-list/(:any)']  			= 'report/schedule_report_controller/embarkation_list/$1';
$route['report/disembarkation-list/(:any)']  		= 'report/schedule_report_controller/disembarkation_list/$1';

$route['crew-certification/(:num)']  				= 'report/history_card_controller/crew_certification/$1';
$route['crew-interview/(:any)']  					= 'report/history_card_controller/crew_interview/$1';
$route['crew-information-sheet/(:any)']  			= 'report/history_card_controller/crew_resume/$1';
$route['crew-list-report']  						= 'report/history_card_controller/crew_list';
$route['crew-list-report1']  						= 'report/history_card_controller/crew_list1';
$route['drop-crew-list-report']  					= 'report/history_card_controller/drop_crew_list';
$route['memo-list-report']  						= 'report/history_card_controller/memo_list';
$route['drop-memo-list-report']  					= 'report/history_card_controller/drop_memo_list';
$route['various-list-report-pdf/(:any)']  			= 'report/history_card_controller/various_list/$1';

$route['report/history-card/ecl/(:any)']   			= 'report/history_card_controller/ecl_hc/$1';
$route['report/history-card/janfield/(:any)']  		= 'report/history_card_controller/janfield_hc/$1';
$route['report/history-card/excel/(:any)']   		= 'report/history_card_controller/excel_hc/$1';
$route['report/history-card/fukunaga/(:any)']  		= 'report/history_card_controller/fukunaga_hc/$1';
$route['report/history-card/standard/(:any)']  		= 'report/history_card_controller/standard_hc/$1';

$route['report/principal-list/(:any)']  			= 'report/principal_report_controller/master_list/$1';
$route['report/vessels-list/(:any)']  				= 'report/vessels_report_controller/master_list/$1';
$route['report/promotion-list/(:any)']  			= 'report/crew_report_controller/promotion_list/$1';

//----------------------------- [ REPORT EXCEL ] ------------------------------------//
$route['crew-principal/(:any)']  					= 'report/excel_report_controller/crew_principal/$1';
$route['vessel-list-report/(:any)']  				= 'report/excel_report_controller/vessel_list/$1';
$route['principal-list-report/(:any)']  			= 'report/excel_report_controller/principal_list/$1';
$route['various-list-report-excel/(:any)']  		= 'report/excel_report_controller/various_list/$1';
$route['check-list-report/(:num)']  				= 'report/excel_report_controller/check_list/$1';
//$route['expired-docs-report/(:any)']  				= 'report/excel_report_controller/expired_list/$1';
$route['disembarkation-docs-report/(:any)']  		= 'report/excel_report_controller/disembarkation_list/$1';
$route['embarkation-docs-report/(:any)']  			= 'report/excel_report_controller/embarkation_list/$1';

$route['conduct-report/(:any)']  					= 'report/excel_report_controller/conduct_report/$1';
$route['send-docs/(:any)']  						= 'report/excel_report_controller/sending_docs_report/$1';
$route['received-docs/(:any)']  					= 'report/excel_report_controller/received_docs_report/$1';
