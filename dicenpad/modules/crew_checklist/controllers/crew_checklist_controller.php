<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crew_checklist_controller extends Front_Controller
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

		$status = new stdClass();
		$status = $this->rest->get('options3', 
			array(
				'option_group'	=> 'APPLICATION-STATUS',
				'sort'		   	=> 'deleted',
				'order'		   	=> 'asc'
				), 'json');

		$positions = new stdClass();
		$positions = $this->rest->get('positions', 
			array(
				'published'		=> 1,
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc',
				'limit'			=> 1000,
				), 'json');

		$all = new stdClass();
		$all->option = 'All';
		$all->option_id = '';
		$all->id = '';

		(object) array_push( $status->data,  $all);

		$personal = new stdClass();
		$personal->clssnme 				= $this->class;
		$personal->positions			= isset($positions->data)? $positions->data : '';
		$personal->options_record		= isset($status->data)? $status->data : '';
		$personal->thumbnail_url 		= $profile->thumbnail_url;
		$personal->first_name 			= $profile->first_name;
		$personal->last_name 			= $profile->last_name;		
		$personal->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/crew/list/model.js');
		add_js('modules/crew/list/directory_view.js');
		add_js('modules/crew/list/options_view.js');
		add_js('modules/crew/list/paginated_view.js');
		add_js('modules/crew/list/paginated_collection.js');
		add_js('modules/crew/list/router.js');

		$this->layout->view('crew_checklist/crew', $personal);
    }

	/**
	* Show a user's crew.
	* 
	* @param int $user user_id
	*/
	public function crew_checklist()
	{		
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');
		
		if(count($_POST) == 0) redirect('search-by-vessel');

		$crew_id = $this->input->post('crew_id');
		$vessel_id = $this->input->post('vessel_id');

		$signatorys = new stdClass();
		$signatorys = $this->rest->get('signatorys', 
			array(
				'form_id'		=> 'Checklist',
				'sort'		   	=> 'id',
				'order'		   	=> 'asc',
				'limit'			=> 100
				), 'json');

		$companys = new stdClass();
		$companys = $this->rest->get('companys', 
			array(
				'sort'		   	=> 'company_id',
				'order'		   	=> 'asc'
				), 'json');

		$vessel = $this->rest->get('vessel', array('id' => $vessel_id), 'json');
		$personal = $this->rest->get('crew', array('id' => $crew_id), 'json');

		$personal->clssnme 				= $this->class;
		$personal->thumbnail_url 		= $profile->thumbnail_url;
		$personal->companys				= isset($companys->data)? $companys->data : '';
		$personal->signatorys			= isset($signatorys->data)? $signatorys->data : '';
		$personal->first_name 			= $profile->first_name;
		$personal->last_name 			= $profile->last_name;
		$personal->principal_id 		= $profile->principal_id;
		$personal->user_id 				= $profile->user_id;	
		$personal->date					= $this->input->post('date');	
		$personal->vessel_id			= $vessel->id;
		$personal->type_id				= $vessel->vtype_id;
		$personal->Isedit 				= ($personal->crew_id)? true : false;
		
		if(!$personal->crew_id) redirect('crew-checklist');
		
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		add_js('modules/crew/check-list/document.js');
		
		$this->layout->view('crew_checklist/resume', $personal);
	}
}