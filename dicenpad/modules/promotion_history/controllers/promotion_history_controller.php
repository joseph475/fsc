<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promotion_history_controller extends Front_Controller
{
	private $class = 'INVENTORY_SETUP';

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
				'sort'		   	=> 'id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$promotion_history = new stdClass();
		$promotion_history->clssnme 			= $this->class;
		$promotion_history->vessels				= $vessels->data;
		$promotion_history->thumbnail_url 		= $profile->thumbnail_url;
		$promotion_history->first_name 			= $profile->first_name;
		$promotion_history->last_name 			= $profile->last_name;
		$promotion_history->principal_id 		= $profile->principal_id;
		
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/promotion_history/list/model.js');
		add_js('modules/promotion_history/list/directory_view.js');
		add_js('modules/promotion_history/list/options_view.js');
		add_js('modules/promotion_history/list/paginated_view.js');
		add_js('modules/promotion_history/list/paginated_collection.js');
		add_js('modules/promotion_history/list/router.js');
		
		$this->layout->view('promotion_history/list', $promotion_history);
	}
}