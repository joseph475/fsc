<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_label_controller extends Front_Controller
{
	private $class = 'ALL_ACCESS';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}

    // --------------------------------------------------------------------

    /**
	* This is the default action, lists all employees.
	*
	* @param int $page
	*/ 
	public function index()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$admin_labels = new stdClass();
		$admin_labels->clssnme 				= $this->class;
		$admin_labels->thumbnail_url 		= $profile->thumbnail_url;
		$admin_labels->first_name 			= $profile->first_name;
		$admin_labels->last_name 			= $profile->last_name;
		$admin_labels->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/admin_label/list.js');
		add_js('modules/admin_label/router.js');
		
		$this->layout->view('admin_label/list', $admin_labels);
	}
}