<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_controller extends Front_Controller
{
	private $class = 'SCHEDULE';

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

		$schedule = new stdClass();
		$schedule->clssnme 				= $this->class;
		$schedule->thumbnail_url 		= $profile->thumbnail_url;
		$schedule->first_name 			= $profile->first_name;
		$schedule->last_name 			= $profile->last_name;
		$schedule->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/schedule/list/model.js');
		add_js('modules/schedule/list/directory_view.js');
		add_js('modules/schedule/list/options_view.js');
		add_js('modules/schedule/list/paginated_view.js');
		add_js('modules/schedule/list/paginated_collection.js');
		add_js('modules/schedule/list/router.js');
		
		$this->layout->view('schedule/list', $schedule);
	}

    public function create_schedule_header($ref = null)
	{	
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$schedule = new stdClass();
		$schedule = $this->rest->get('schedule', array('ref' => $ref), 'json');
		$schedule = ($schedule->id)? $schedule : '';

		//dbug($schedule);

		$reason = $this->rest->get('options', 
			array(
				'option_group'	=> 'REASON',
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc'
				), 'json');

		$vessels = $this->rest->get('vessels', 
			array(
				'status'		=> 'Active',
				'sort'		   	=> 'vessel_name',
				'order'		   	=> 'asc',
				'limit'			=> 500
				), 'json');

		$positions = $this->rest->get('positions', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc',
				'limit'			=> 500
				), 'json');

		$agent = $this->rest->get('agents', 
			array(
				'status'		=> 'Active',
				'sort'		   	=> 'fullname',
				'order'		   	=> 'asc',
				'limit'			=> 500
				), 'json');

		$join_flight = $this->rest->get('flights', 
					array(
						'type'		   => 'join',	
						'sched_id'	   => ($schedule)? $schedule->id : 0,
						'sort'		   => 'flight_date',
						'order'		   => 'asc',
						'limit'		   => 50
						), 'json');	

		$repat_flight = $this->rest->get('flights', 
					array(
						'type'		   => 'repat',	
						'sched_id'	   => ($schedule)? $schedule->id : 0,
						'sort'		   => 'flight_date',
						'order'		   => 'asc',
						'limit'		   => 50
						), 'json');	
		
		if(!$schedule){
			$schedule = new stdClass();
	        $schedule->control_message = '<p><small>Reference Nos will be generated upon saving.</small></p>';
		}        

		$schedule->clssnme 				= $this->class;
		$schedule->thumbnail_url 		= $profile->thumbnail_url;
		$schedule->first_name 			= $profile->first_name;
		$schedule->last_name 			= $profile->last_name;
		$schedule->principal_id 		= $profile->principal_id;
		$schedule->vessels				= isset($vessels->data)? $vessels->data : '';
		$schedule->reasons				= isset($reason->data)? $reason->data : '';
		$schedule->agents				= isset($agent->data)? $agent->data : '';
		$schedule->join_flight			= isset($join_flight->data)? $join_flight->data : ''; 
		$schedule->repat_flight 		= isset($repat_flight->data)? $repat_flight->data : ''; 
		//$schedule->positions			= $positions->data;
		
		$position = $this->rest->get('assign_pos', 
			array(
				'vessel_id' 	=> isset($schedule->vessel_id)? $schedule->vessel_id : 0,
				'end_date'		=> isset($schedule->vessel_id)? date('Y-m', strtotime($schedule->repat_date)) : '0000-00-00',
				'sort'		   	=> 'jd_position.sort_order',
				'order'		   	=> 'asc'
				), 'json');

		if($position->_count != 0){
			$schedule->positions = ($position)? $position->data : false;
		} else {
			$schedule->positions = false;
		}
		
		add_js('libs/input-mask/jquery.inputmask.js');
		add_js('libs/input-mask/jquery.inputmask.date.extensions.js');
		add_js('libs/input-mask/jquery.inputmask.extensions.js');

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		add_js('modules/onboard/action/onboard.js');	

		//dbug($schedule);		

		if(!isset($schedule->id)){
			$schedule->about 			= null;
			add_js('modules/schedule/action/schedule.js');
		}else {
			add_js('modules/schedule/action');
		}

		$this->layout->view('action/schedule_d', $schedule);
	}

	function schedule_redirect_url($key=null)
	{
		$this->session->set_userdata('redirect_url', (($key)? 'schedule-replacement/' . $key : 'admin'));
		if($this->session->userdata('redirect_url')){
			$redirect_url = $this->session->userdata('redirect_url');
			$this->session->unset_userdata('redirect_url');
        }

		$this->load->view('ajax', array('html' => $redirect_url));
	}

	public function show($ref)
	{			
		$this->create_schedule_header($ref);
	}
}
