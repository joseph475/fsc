<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/memos']  				= 'memo/api/memo_controller/memos';
$route['api/memo']  				= 'memo/api/memo_controller/memo';
$route['api/memo/id/(:num)'] 		= 'memo/api/memo_controller/memo/id/$1';

$route['api/memo_users']  			= 'memo/api/memo_user_controller/memo_users';
$route['api/memo_user']  			= 'memo/api/memo_user_controller/memo_user';
$route['api/memo_user/id/(:num)']	= 'memo/api/memo_user_controller/memo_user/id/$1';
// --------------------------------------------------------------------

$route['upload-manager']  			= 'memo/memo_controller';
$route['create-upload']   			= 'memo/memo_controller/new_memo';
$route['edit-upload/(:num)']   		= 'memo/memo_controller/edit_memo/$1';
$route['download-manager']  		= 'memo/memo_controller/download';
$route['view-download/(:num)']   	= 'memo/memo_controller/view_memo/$1';

$route['save-memo']  				= 'memo/memo_controller/save_memo';
$route['update-memo']  				= 'memo/memo_controller/update_memo';
