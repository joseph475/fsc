<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Division_controller extends Front_Controller
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

		$divisions = new stdClass();
		$divisions->clssnme 			= $this->class;
		$divisions->thumbnail_url 		= $profile->thumbnail_url;
		$divisions->first_name 			= $profile->first_name;
		$divisions->last_name 			= $profile->last_name;
		$divisions->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/division/list/model.js');
		add_js('modules/division/list/directory_view.js');
		add_js('modules/division/list/options_view.js');
		add_js('modules/division/list/paginated_view.js');
		add_js('modules/division/list/paginated_collection.js');
		add_js('modules/division/list/router.js');
		
		$this->layout->view('division/list', $divisions);
	}
}