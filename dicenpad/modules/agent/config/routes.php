<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/agents']  				= 'agent/api/agent_controller/agents';
$route['api/agent']  				= 'agent/api/agent_controller/agent';
$route['api/agent/hash/(:any)'] 	= 'agent/api/agent_controller/agent/hash/$1';
$route['api/agent/id/(:num)'] 		= 'agent/api/agent_controller/agent/id/$1';

// --------------------------------------------------------------------

$route['agent-master-list']  		= 'agent/agent_controller';
$route['agent-entry']  				= 'agent/agent_controller/agent_entry';
$route['agent-entry/(:any)']  		= 'agent/agent_controller/show/$1';
$route['agent-resume/(:any)']  		= 'agent/agent_controller/view/$1';
$route['agent-redirect/(:any)'] 	= 'agent/agent_controller/agent_redirect_url/$1';
