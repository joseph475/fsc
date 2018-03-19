<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_controller extends Front_Controller
{
	private $class = 'SEARCH';

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

		$arrstatus = array(
				'option_group'	=> 'APPLICATION-STATUS',
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc'
				);

		$arrstatus = ($profile->principal_id)? array_merge(array('option_code' => 'ON BOARD'), $arrstatus) : $arrstatus;

		$status = $this->rest->get('options', $arrstatus, 'json');

		if(!$profile->principal_id) 
		{			
			$all = new stdClass();
			$all->option = 'All';
			$all->option_id = '';
			$all->id = '';
			(object) array_push( $status->data,  $all);
		}

		$positions = $this->rest->get('positions', 
					array(
						'published'		=> 1,
						'sort'		   	=> 'sort_order',
						'order'		   	=> 'asc',
						'limit'			=> 1000,
						), 'json');

		$principal = $this->rest->get('principals', 
			array(
				'status'		=> 'Active',
				'sort'		   => 'fullname',
				'order'		   => 'asc',
				'limit'			=> 1000
				), 'json');

		$crew_search = new stdClass();
		$crew_search->clssnme 				= $this->class;
		$crew_search->positions				= $positions->data;
		$crew_search->principals			= $principal->data;
		$crew_search->options_record		= $status->data;
		$crew_search->thumbnail_url 		= $profile->thumbnail_url;
		$crew_search->first_name 			= $profile->first_name;
		$crew_search->last_name 			= $profile->last_name;	
		$crew_search->principal_id 			= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/crew/list/list.js');
		add_js('modules/crew/list/router.js');

		$this->layout->view('search/crew', $crew_search);
	}

    /**
	* This is the default action, lists all employees.
	*
	* @param int $page
	*/ 
	public function crew_principal()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$status = $this->rest->get('options3', 
					array(
						'option_group'	=> 'APPLICATION-STATUS',
						'sort'		   	=> 'deleted',
						'order'		   	=> 'asc'
						), 'json');

		$positions = $this->rest->get('positions', 
					array(
						'published'		=> 1,
						'sort'		   	=> 'sort_order',
						'order'		   	=> 'asc',
						'limit'			=> 1000,
						), 'json');

		$principal = $this->rest->get('principals', 
			array(
				'status'		=> 'Active',
				'sort'		   => 'fullname',
				'order'		   => 'asc',
				'limit'			=> 1000
				), 'json');

		$all = new stdClass();
		$all->option = 'All';
		$all->option_id = '';
		$all->id = '';

		(object) array_push( $status->data,  $all);

		$crew_search = new stdClass();
		$crew_search->clssnme 				= $this->class;
		$crew_search->positions				= $positions->data;
		$crew_search->principals			= $principal->data;
		$crew_search->options_record		= $status->data;
		$crew_search->thumbnail_url 		= $profile->thumbnail_url;
		$crew_search->first_name 			= $profile->first_name;
		$crew_search->last_name 			= $profile->last_name;	
		$crew_search->principal_id 			= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/crew/list/list_crew_principal.js');
		add_js('modules/crew/list/router.js');

		$this->layout->view('search/crew_principal', $crew_search);
	}

	public function vessel_search()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$arrvesselsac = array(
				'status'		=> 'Active',
				'sort'		   	=> 'vessel_name',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				);
		$arrvesselsac = ($profile->principal_id)? array_merge(array('principal_id' => $profile->principal_id), $arrvesselsac) : $arrvesselsac;
		$vessels = new stdClass();
		$vessels = $this->rest->get('vessels', $arrvesselsac, 'json');


		$arrvesselsinac = array(
				'status'		=> 'Inactive',
				'sort'		   	=> 'vessel_name',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				);
		$arrvesselsinac = ($profile->principal_id)? array_merge(array('principal_id' => $profile->principal_id), $arrvesselsinac) : $arrvesselsinac;
		$vessels2 = new stdClass();
		$vessels2 = $this->rest->get('vessels', $arrvesselsinac, 'json');

		$vessel_search = new stdClass();
		$vessel_search->vessels				= isset($vessels->data)? $vessels->data : '';
		$vessel_search->vessels2			= isset($vessels2->data)? $vessels2->data : '';
		$vessel_search->clssnme 			= $this->class;
		$vessel_search->thumbnail_url 		= $profile->thumbnail_url;
		$vessel_search->first_name 			= $profile->first_name;
		$vessel_search->last_name 			= $profile->last_name;
		$vessel_search->principal_id 		= $profile->principal_id;
		
		$this->layout->view('search/vessel', $vessel_search);
	}

	public function execute_search_vessel()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		if(!$this->input->post('vessel_id')) redirect('search-by-vessel');

		$date = $this->input->post('year') . '-' . $this->input->post('month') . '-' . $this->input->post('day');
		$date = date('Y-m-d', strtotime($date));

		$vessel = $this->rest->get('vessel', array('id' => $this->input->post('vessel_id')), 'json');

		$vessel->vessel_id			= $this->input->post('vessel_id');
		$vessel->date				= $date;
		$vessel->clssnme 			= $this->class;
		$vessel->thumbnail_url 		= $profile->thumbnail_url;
		$vessel->first_name 		= $profile->first_name;
		$vessel->last_name 			= $profile->last_name;
		$vessel->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/search/vessel/crew_list.js');

		$this->layout->view('search/crew_list', $vessel);
	}
}