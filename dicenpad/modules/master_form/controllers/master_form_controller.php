<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_form_controller extends Front_Controller
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
		
		$master_forms = new stdClass();
		$master_forms->clssnme 				= $this->class;
		$master_forms->thumbnail_url 		= $profile->thumbnail_url;
		$master_forms->first_name 			= $profile->first_name;
		$master_forms->last_name 			= $profile->last_name;
		$master_forms->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		add_js('modules/master_form/list');

		add_js('modules/master_form/list/model.js');
		add_js('modules/master_form/list/directory_view.js');
		add_js('modules/master_form/list/options_view.js');
		add_js('modules/master_form/list/paginated_view.js');
		add_js('modules/master_form/list/paginated_collection.js');
		add_js('modules/master_form/list/router.js');
		
		$this->layout->view('master_form/list', $master_forms);
	}
}