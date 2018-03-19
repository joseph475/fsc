<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//-----------------[ API ] ------------------------
$route['api/crews']  					= 'crew/api/crew_controller/crews';
$route['api/crew_principals']  			= 'crew/api/crew_controller/crew_principals';
$route['api/crew']  					= 'crew/api/crew_controller/crew';
$route['api/crew/hash/(:any)'] 			= 'crew/api/crew_controller/crew/hash/$1';
$route['api/crew/id/(:num)'] 			= 'crew/api/crew_controller/crew/id/$1';
$route['api/crew/id/(:num)/photo']   	= 'crew/api/crew_photo_controller/crew_photo/crew_id/$1';
$route['api/language/id/(:num)'] 		= 'crew/api/crew_controller/language/id/$1';
$route['api/assessment/id/(:num)'] 		= 'crew/api/crew_controller/assessment/id/$1';
$route['api/interview/id/(:num)'] 		= 'crew/api/crew_interview_controller/interview/id/$1';
$route['api/remarks/id/(:num)'] 		= 'crew/api/crew_controller/remarks/id/$1';

$route['api/crew_docs']						= 'crew/api/crew_docs_controller/crew_docs';
$route['api/crew_doc'] 						= 'crew/api/crew_docs_controller/crew_doc';
$route['api/crew_doc/id/(:num)/documents'] 	= 'crew/api/crew_docs_controller/crew_doc';
$route['api/crew_doc/id/(:num)'] 			= 'crew/api/crew_docs_controller/crew_doc/id/$1';

$route['api/crew_childs']						= 'crew/api/crew_children_controller/crew_childrens';
$route['api/crew_child'] 						= 'crew/api/crew_children_controller/crew_children';
$route['api/crew_child/id/(:num)/childrens'] 	= 'crew/api/crew_children_controller/crew_children';
$route['api/crew_child/id/(:num)'] 				= 'crew/api/crew_children_controller/crew_children/id/$1';

$route['api/crew_banks']						= 'crew/api/crew_bank_controller/crew_banks';
$route['api/crew_bank'] 						= 'crew/api/crew_bank_controller/crew_bank';
$route['api/crew_bank/id/(:num)/transaction'] 	= 'crew/api/crew_bank_controller/crew_bank';
$route['api/crew_bank/id/(:num)'] 				= 'crew/api/crew_bank_controller/crew_bank/id/$1';

$route['api/crew_comments']						= 'crew/api/crew_comment_controller/crew_comments';
$route['api/crew_comment'] 						= 'crew/api/crew_comment_controller/crew_comment';
$route['api/crew_comment/id/(:num)/comments'] 	= 'crew/api/crew_comment_controller/crew_comment';
$route['api/crew_comment/id/(:num)'] 			= 'crew/api/crew_comment_controller/crew_comment/id/$1';

$route['api/crew_works']						= 'crew/api/crew_works_controller/crew_works';
$route['api/crew_work']							= 'crew/api/crew_works_controller/crew_work';
$route['api/crew_work/id/(:num)/works']			= 'crew/api/crew_works_controller/crew_work';
$route['api/crew_work/id/(:num)']				= 'crew/api/crew_works_controller/crew_work/id/$1';

$route['api/crew_work_historys']						= 'crew/api/crew_work_history_controller/crew_work_historys';
$route['api/crew_work_history']							= 'crew/api/crew_work_history_controller/crew_work_history';
$route['api/crew_work_history/id/(:num)/work_historys']	= 'crew/api/crew_work_history_controller/crew_work_history';
$route['api/crew_work_history/id/(:num)']				= 'crew/api/crew_work_history_controller/crew_work_history/id/$1';

$route['api/crew_educs/id/(:num)/educs']		= 'crew/api/crew_education_controller/crew_education';
$route['api/crew_educs']						= 'crew/api/crew_education_controller/crew_education';
$route['api/crew_educs/id/(:num)']				= 'crew/api/crew_education_controller/crew_education/id/$1';
$route['api/crew_educations']					= 'crew/api/crew_education_controller/crew_educations';

$route['api/crew_remarks/id/(:num)/remarks']	= 'crew/api/crew_remarks_controller/crew_remarks';
$route['api/crew_remarks']						= 'crew/api/crew_remarks_controller/crew_remarks';
$route['api/crew_remarks/id/(:num)']			= 'crew/api/crew_remarks_controller/crew_remarks/id/$1';
$route['api/crew_remarkss']						= 'crew/api/crew_remarks_controller/crew_remarkss';

$route['api/crew_attachments']						= 'crew/api/crew_attachment_controller/crew_attachments';
$route['api/crew_attachment'] 						= 'crew/api/crew_attachment_controller/crew_attachment';
$route['api/crew_attachment/id/(:num)/attachments'] = 'crew/api/crew_attachment_controller/crew_attachment';
$route['api/crew_attachment/id/(:num)'] 			= 'crew/api/crew_attachment_controller/crew_attachment/id/$1';

$route['api/crew_validate']  					= 'crew/api/crew_controller/validate';
// --------------------------------------------------------------------
$route['crew-applicant-validation']  			= 'crew/crew_controller/validate_entry';


$route['crew-master-list']  		= 'crew/crew_controller';
$route['crew-master/no-position']   = 'crew/crew_controller/no_position';
$route['crew-applicant']  			= 'crew/crew_controller/crew_registration';
$route['crew-applicant/(:any)']  	= 'crew/crew_controller/show/$1';
$route['resume'] 		 			= 'crew/crew_controller/crew_resume';
$route['resume/(:any)']				= 'crew/crew_controller/view/$1';
$route['report/load-position']  	= 'crew/crew_controller/load_position';

$route['crew-redirect/(:any)']  	= 'crew/crew_controller/crew_redirect_url/$1';
$route['crew-upload-file']  		= 'crew/crew_controller/upload_file';