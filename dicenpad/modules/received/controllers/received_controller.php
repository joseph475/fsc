<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Received_controller extends Front_Controller
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

		$receiveds = new stdClass();
		$receiveds->clssnme 			= $this->class;
		$receiveds->vessels				= $vessels->data;
		$receiveds->thumbnail_url 		= $profile->thumbnail_url;
		$receiveds->first_name 			= $profile->first_name;
		$receiveds->last_name 			= $profile->last_name;
		$receiveds->principal_id 		= $profile->principal_id;
		
		add_js('libs/input-mask/jquery.inputmask.js');
		add_js('libs/input-mask/jquery.inputmask.date.extensions.js');
		add_js('libs/input-mask/jquery.inputmask.extensions.js');

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/received/list/model.js');
		add_js('modules/received/list/crew_view.js');
		add_js('modules/received/list/directory_view.js');
		add_js('modules/received/list/options_view.js');
		add_js('modules/received/list/paginated_view.js');
		add_js('modules/received/list/paginated_collection.js');
		add_js('modules/received/list/router.js');
		
		$this->layout->view('received/list', $receiveds);
	}

    
}