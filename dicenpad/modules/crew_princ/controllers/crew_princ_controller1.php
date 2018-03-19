<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crew_princ_controller extends Front_Controller
{
	private $class = 'SEARCH';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}
	
    /**
	* This is the default action, lists all crew.
	*
	* @param int $page
	*/ 
	public function index()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$arrvessels = array(
				'status'		=> 'Active',
				'sort'		   	=> 'vessel_name',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				);

		$arrvessels = ($profile->principal_id)? array_merge(array('principal_id' => $profile->principal_id), $arrvessels) : $arrvessels;

		$vessels = $this->rest->get('vessels', $arrvessels, 'json');


		$crew_princ = new stdClass();
		$crew_princ->clssnme 				= $this->class;
		$crew_princ->vessels				= $vessels->data;
		$crew_princ->thumbnail_url 		= $profile->thumbnail_url;
		$crew_princ->first_name 			= $profile->first_name;
		$crew_princ->last_name 			= $profile->last_name;	
		$crew_princ->principal_id 			= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/crew_princ/list/model.js');
		add_js('modules/crew_princ/list/directory_view.js');
		add_js('modules/crew_princ/list/options_view.js');
		add_js('modules/crew_princ/list/paginated_view.js');
		add_js('modules/crew_princ/list/paginated_collection.js');
		add_js('modules/crew_princ/list/router.js');

		$this->layout->view('crew_princ/list', $crew_princ);
	}
}