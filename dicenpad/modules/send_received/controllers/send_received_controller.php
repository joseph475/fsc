<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_received_controller extends Front_Controller
{
	private $class = 'SEND_RECEIVED';

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

		$vessels = $this->rest->get('vessels', 
					array(
						'status'		=> 'Active',
						'sort'		   	=> 'id',
						'order'		   	=> 'asc',
						'limit'			=> 1000
						), 'json');

		$send_receiveds = new stdClass();
		$send_receiveds->clssnme 			= $this->class;
		$send_receiveds->vessels			= $vessels->data;
		$send_receiveds->thumbnail_url 		= $profile->thumbnail_url;
		$send_receiveds->first_name 		= $profile->first_name;
		$send_receiveds->last_name 			= $profile->last_name;
		$send_receiveds->principal_id 		= $profile->principal_id;

		add_js('libs/ajaxfileupload.js');
		
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/send_received/list/model.js');
		add_js('modules/send_received/list/crew_view.js');
		add_js('modules/send_received/list/directory_view.js');
		add_js('modules/send_received/list/options_view.js');
		add_js('modules/send_received/list/paginated_view.js');
		add_js('modules/send_received/list/paginated_collection.js');
		add_js('modules/send_received/list/router.js');

		add_css('jquery.fileupload-ui.css');
		
		$this->layout->view('send/list', $send_receiveds);
	}

    // --------------------------------------------------------------------

	public function received_docs()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$vessels = $this->rest->get('vessels', 
			array(
				'status'		=> 'Active',
				'sort'		   	=> 'id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$personal = $this->rest->get('crews', 
			array(
				'status_id'		=> 3,			
				'sort'		   	=> 'lastname',
				'order'		   	=> 'asc'
				), 'json');

		$send_receiveds = new stdClass();
		$send_receiveds->clssnme 			= $this->class;
		$send_receiveds->vessels			= $vessels->data;
		$send_receiveds->crews 				= $personal->data;
		$send_receiveds->thumbnail_url 		= $profile->thumbnail_url;
		$send_receiveds->first_name 		= $profile->first_name;
		$send_receiveds->last_name 			= $profile->last_name;
		$send_receiveds->principal_id 		= $profile->principal_id;

		add_js('libs/ajaxfileupload.js');
		
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/send_received/list/model.js');
		add_js('modules/send_received/list/directory_view.js');
		add_js('modules/send_received/list/options_view.js');
		add_js('modules/send_received/list/paginated_view.js');
		add_js('modules/send_received/list/paginated_collection2.js');
		add_js('modules/send_received/list/router.js');

		add_css('jquery.fileupload-ui.css');
		
		$this->layout->view('received/list', $send_receiveds);
	}
}