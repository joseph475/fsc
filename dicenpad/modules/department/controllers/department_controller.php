<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_controller extends Front_Controller
{
	private $class = 'ADMINISTRATIVE';

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

		$departments = new stdClass(); 
		$departments->clssnme 				= $this->class;
		$departments->thumbnail_url 		= $profile->thumbnail_url;
		$departments->first_name 			= $profile->first_name;
		$departments->last_name 			= $profile->last_name;
		$departments->principal_id 			= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/department/list/model.js');
		add_js('modules/department/list/directory_view.js');
		add_js('modules/department/list/options_view.js');
		add_js('modules/department/list/paginated_view.js');
		add_js('modules/department/list/paginated_collection.js');
		add_js('modules/department/list/router.js');
		
		$this->layout->view('department/list', $departments);
	}
}