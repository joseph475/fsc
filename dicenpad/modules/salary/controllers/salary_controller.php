<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary_controller extends Front_Controller
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

		$positions = $this->rest->get('positions', 
					array(
						'sort'		   	=> 'sort_order ',
						'order'		   	=> 'asc',
						'limit'			=> 500
						), 'json');

		$vessels = $this->rest->get('vessels', 
					array(
						'status'		=> 'Active',
						'sort'		   	=> 'vessel_name',
						'order'		   	=> 'asc',
						'limit'			=> 1000
						), 'json');
		
		$salary = new stdClass();
		$salary->clssnme 			= $this->class;
		$salary->vessels			= $vessels->data;
		$salary->positions			= $positions->data;
		$salary->thumbnail_url 		= $profile->thumbnail_url;
		$salary->first_name 		= $profile->first_name;
		$salary->last_name 			= $profile->last_name;
		$salary->principal_id 		= $profile->principal_id;
		
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		add_js('libs/jquery.formatcurrency.js');
		
		add_js('modules/salary/list/model.js');
		add_js('modules/salary/list/directory_view.js');
		add_js('modules/salary/list/options_view.js');
		add_js('modules/salary/list/paginated_view.js');
		add_js('modules/salary/list/paginated_collection.js');
		add_js('modules/salary/list/router.js');

		$this->layout->view('salary/list', $salary);
	}
}