<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_controller extends Front_Controller
{
	private $class = 'ALL_ACCESS';

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

		$logs = new stdClass();
		$logs = $this->rest->get('tops', 
			array(
				'sort'		   => 'admin_keys_history.user_id',
				'order'		   => 'asc',
				'limit'		   => 5,
				), 'json');	

		$logs->thumbnail_url 		= $profile->thumbnail_url;
		$logs->first_name 			= $profile->first_name;
		$logs->last_name 			= $profile->last_name;
		$logs->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/log/list/model.js');
		add_js('modules/log/list/directory_view.js');
		add_js('modules/log/list/options_view.js');
		add_js('modules/log/list/paginated_view.js');
		add_js('modules/log/list/paginated_collection.js');
		add_js('modules/log/list/router.js');
		
		$this->layout->view('log/list', $logs);
	}
}