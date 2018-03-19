<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flight_controller extends Front_Controller
{
	private $class = 'FLIGHT';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}

	public function index()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$flight = new stdClass();
		$flight->clssnme 			= $this->class;
		$flight->thumbnail_url 		= $profile->thumbnail_url;
		$flight->first_name 		= $profile->first_name;
		$flight->last_name 			= $profile->last_name;
		$flight->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/flight/list/model.js');
		add_js('modules/flight/list/directory_view.js');
		add_js('modules/flight/list/options_view.js');
		add_js('modules/flight/list/paginated_view.js');
		add_js('modules/flight/list/paginated_collection.js');
		add_js('modules/flight/list/router.js');
		
		$this->layout->view('flight/list', $flight);
	}

    public function assignment($ref = null)
	{	
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$schedule = $this->rest->get('schedule', array('ref' => $ref), 'json');

		$agent = $this->rest->get('agents', 
			array(
				'status'		=> 'Active',
				'sort'		   	=> 'fullname',
				'order'		   	=> 'asc',
				'limit'			=> 500
				), 'json');

		$schedule->clssnme 				= $this->class;
		$schedule->thumbnail_url 		= $profile->thumbnail_url;
		$schedule->first_name 			= $profile->first_name;
		$schedule->last_name 			= $profile->last_name;
		$schedule->principal_id 		= $profile->principal_id;
		$schedule->agents				= isset($agent->data)? $agent->data : '';

		unset($schedule->about);

		//dbug($schedule);
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');		

		add_js('modules/flight/action');
		
		$this->layout->view('flight/assignment', $schedule);
	}
}
