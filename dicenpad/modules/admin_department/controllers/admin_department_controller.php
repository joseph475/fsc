<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_department_controller extends Front_Controller
{
	private $class = 'ALL_ACCESS';

	public function __construct()
	{
		parent::__construct();
		
		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}

    /**
	* This is the default action, lists all employees.
	*
	* @param int $page
	*/ 
	public function index()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');
		
		$admin_departments = new stdClass();
		$admin_departments->clssnme 			= $this->class;
		$admin_departments->thumbnail_url 		= $profile->thumbnail_url;
		$admin_departments->first_name 			= $profile->first_name;
		$admin_departments->last_name 			= $profile->last_name;
		$admin_departments->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/admin_department/list.js');
		add_js('modules/admin_department/router.js');
		
		$this->layout->view('admin_department/list', $admin_departments);
	}
}