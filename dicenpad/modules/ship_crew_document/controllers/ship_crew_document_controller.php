<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ship_crew_document_controller extends Front_Controller
{
	private $class = 'ADMINISTRATIVE';

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

		$vessels = $this->rest->get('vessels', 
					array(
						'status'		=> 'active',
						'sort'		   	=> 'vessel_name',
						'order'		   	=> 'asc',
						'limit'			=> 1000
						), 'json');

		$signatorys = $this->rest->get('signatorys', 
					array(
						'form_id'		=> 'POEA or RPS',
						'sort'		   	=> 'id',
						'order'		   	=> 'asc'
						), 'json');
		
		$crews = new stdClass();
		$crews->clssnme 			= $this->class;
		$crews->vessels				= $vessels->data;
		$crews->signatorys			= $signatorys->data;
		$crews->thumbnail_url 		= $profile->thumbnail_url;
		$crews->first_name 			= $profile->first_name;
		$crews->last_name 			= $profile->last_name;	
		$crews->user_id 			= $profile->user_id;
		$crews->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/ship_crew_document/list/model.js');
		add_js('modules/ship_crew_document/list/directory_view.js');
		add_js('modules/ship_crew_document/list/paginated_view.js');
		add_js('modules/ship_crew_document/list/paginated_collection.js');
		add_js('modules/ship_crew_document/list/router.js');

		$this->layout->view('ship_crew_document/list', $crews);
    }
}