<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onboard_controller extends Front_Controller
{
	private $class = 'ONBOARD';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}
   
	public function embarkation_list() 
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$vessels = $this->rest->get('vessels', 
			array(
				'status'		=> 'Active',
				'sort'		   	=> 'vessel_name',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$embarkation = new stdClass();
		$embarkation->clssnme 				= $this->class;
		$embarkation->vessels 				= $vessels->data;
		$embarkation->thumbnail_url 		= $profile->thumbnail_url;
		$embarkation->first_name 			= $profile->first_name;
		$embarkation->last_name 			= $profile->last_name;
		$embarkation->principal_id 			= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/onboard/embarkation/model.js');
		add_js('modules/onboard/embarkation/directory_view.js');
		add_js('modules/onboard/embarkation/options_view.js');
		add_js('modules/onboard/embarkation/paginated_view.js');
		add_js('modules/onboard/embarkation/paginated_collection.js');
		add_js('modules/onboard/embarkation/router.js');
		
		$this->layout->view('embarkation/list', $embarkation);
	}

	public function disembarkation_list() 
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$vessels = $this->rest->get('vessels', 
			array(
				'status'		=> 'Active',
				'sort'		   	=> 'vessel_name',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$disembarkation = new stdClass();
		$disembarkation->clssnme 			= $this->class;
		$disembarkation->vessels 			= $vessels->data;		
		$disembarkation->thumbnail_url 		= $profile->thumbnail_url;
		$disembarkation->first_name 		= $profile->first_name;
		$disembarkation->last_name 			= $profile->last_name;
		$disembarkation->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/onboard/disembarkation/model.js');
		add_js('modules/onboard/disembarkation/directory_view.js');
		add_js('modules/onboard/disembarkation/options_view.js');
		add_js('modules/onboard/disembarkation/paginated_view.js');
		add_js('modules/onboard/disembarkation/paginated_collection.js');
		add_js('modules/onboard/disembarkation/router.js');
		
		$this->layout->view('disembarkation/list', $disembarkation);
	}
}