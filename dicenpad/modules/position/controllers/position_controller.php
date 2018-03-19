<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position_controller extends Front_Controller
{
	private $class = 'INVENTORY_SETUP';

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
		
		$departments = $this->rest->get('departments', 
			array(
				'sort'		   => 'id',
				'order'		   => 'asc',
				'limit'		   => 100
				), 'json');

		$divisions = $this->rest->get('divisions', 
			array(
				'sort'		   => 'id',
				'order'		   => 'asc',
				'limit'		   => 100
				), 'json');

		$position = new stdClass();
		$position->clssnme 				= $this->class;
		$position->division_record 		= $divisions->data;
		$position->options_record 		= $departments->data;
		$position->thumbnail_url 		= $profile->thumbnail_url;
		$position->first_name 			= $profile->first_name;
		$position->last_name 			= $profile->last_name;
		$position->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/position/list/model.js');
		add_js('modules/position/list/directory_view.js');
		add_js('modules/position/list/options_view.js');
		add_js('modules/position/list/paginated_view.js');
		add_js('modules/position/list/paginated_collection.js');
		add_js('modules/position/list/router.js');
		
		$this->layout->view('position/list', $position);
	}
}