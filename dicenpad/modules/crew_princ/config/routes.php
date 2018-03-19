<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//-----------------[ API ] ------------------------
$route['api/crew-princs'] 			= 'crew_princ/api/crew_princ_controller/crew_princs';

//-----------------[ FRONT ] ------------------------
$route['crew-princ-list']  			= 'crew_princ/crew_princ_controller/index';