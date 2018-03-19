<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_sub_controller extends Front_Controller
{
	private $class = 'ADMINISTRATIVE';

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

		$types = $this->rest->get('types', 
			array(
				'sort'		   => 'id',
				'order'		   => 'asc',
				'limit'		   => 1000
				), 'json');		

		$type_subs = new stdClass();
		$type_subs->clssnme 			= $this->class;
		$type_subs->options_record 		= $types->data;
		$type_subs->thumbnail_url 		= $profile->thumbnail_url;
		$type_subs->first_name 			= $profile->first_name;
		$type_subs->last_name 			= $profile->last_name;
		$type_subs->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/type_sub/list/model.js');
		add_js('modules/type_sub/list/directory_view.js');
		add_js('modules/type_sub/list/options_view.js');
		add_js('modules/type_sub/list/paginated_view.js');
		add_js('modules/type_sub/list/paginated_collection.js');
		add_js('modules/type_sub/list/router.js');

		$this->layout->view('type_sub/list', $type_subs);
	}
}