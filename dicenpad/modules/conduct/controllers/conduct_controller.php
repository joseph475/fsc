<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conduct_controller extends Front_Controller
{
	private $class = 'CONDUCT';

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

		$vessels = $this->rest->get('vessels', 
					array(
						'status'		=> 'Active',
						'sort'		   	=> 'id',
						'order'		   	=> 'asc',
						'limit'			=> 1000
						), 'json');

		$conducts = new stdClass();
		$conducts->clssnme 				= $this->class;
		$conducts->vessels				= $vessels->data;
		$conducts->thumbnail_url 		= $profile->thumbnail_url;
		$conducts->first_name 			= $profile->first_name;
		$conducts->last_name 			= $profile->last_name;
		$conducts->principal_id 		= $profile->principal_id;

		add_js('libs/ajaxfileupload.js');
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/conduct/list.js');
		add_js('modules/conduct/router.js');

		add_css('jquery.fileupload-ui.css');
		
		$this->layout->view('conduct/list', $conducts);
	}
}