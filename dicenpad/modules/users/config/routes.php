<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['profile'] 		 = 'users/profile_controller';
$route['profile/(:any)'] = 'users/profile_controller/show/$1';

$route['user/about'] = 'users/user_controller/about';

$route['api/users'] 	   				= 'users/api/user_controller/users';
$route['api/user'] 		   				= 'users/api/user_controller/user';
$route['api/user/id/(:num)'] 			= 'users/api/user_controller/user/id/$1';
$route['api/user/id/(:num)/about']   	= 'users/api/about_controller/about/user_id/$1';
$route['api/user/id/(:num)/contact'] 	= 'users/api/contact_controller/contact/user_id/$1';
$route['api/user/id/(:num)/photo']   	= 'users/api/photo_controller/photo/user_id/$1';
$route['api/user/id/(:num)/signature'] 	= 'users/api/signature_controller/signature/id/$1';
$route['api/signature'] 				= 'users/api/signature_controller/signature';

$route['api/user_pass/id/(:num)'] 			= 'users/api/user_controller/user_pass/id/$1';

$route['api/contact'] 		    = 'users/api/contact_controller/contact';
$route['api/contact/id/(:num)'] = 'users/api/contact_controller/contact/id/$1';

// --------------------------------------------------------------------

$route['user-manager']  			= 'users/user_controller';
$route['add-new-user']  			= 'users/user_controller/create_user';
$route['edit-user/(:num)']  		= 'users/user_controller/edit_user/$1';


$route['add-new-user2']  			= 'users/user_controller/create_principal_user';
$route['edit-user2/(:num)']  		= 'users/user_controller/edit_principal_user/$1';