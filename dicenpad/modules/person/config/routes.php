<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API URL
// Work experience
$route['api/workexperience/id/(:num)']  = 'person/api/workexperience_controller/work';
$route['api/person/id/(:num)/workexperiences']  = 'person/api/person_controller/work';
// References
$route['api/references/id/(:num)']  = 'person/api/references_controller/references';
$route['api/person/id/(:num)/references']  = 'person/api/person_controller/references';
// Affiliation
$route['api/affiliation/id/(:num)']  = 'person/api/affiliation_controller/affiliation';
$route['api/person/id/(:num)/affiliations']  = 'person/api/person_controller/affiliations';
// Skills
$route['api/skill/id/(:num)']  = 'person/api/skills_controller/skill';
$route['api/person/id/(:num)/skills']  = 'person/api/person_controller/skills';
// Trainings
$route['api/training/id/(:num)']  = 'person/api/trainings_controller/training';
$route['api/person/id/(:num)/trainings']  = 'person/api/person_controller/trainings';
// Test Profile
$route['api/test/id/(:num)']  = 'person/api/tests_controller/test';
$route['api/person/id/(:num)/tests']  = 'person/api/person_controller/tests';
// Details
$route['api/detail/id/(:num)']  = 'person/api/details_controller/detail';
$route['api/person/id/(:num)/detail']  = 'person/api/person_controller/detail';
// Education
$route['api/education/id/(:num)']  = 'person/api/education_controller/education';
$route['api/person/id/(:num)/education']  = 'person/api/person_controller/education';