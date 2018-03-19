<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checklist_controller extends Front_Controller
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
				'sort'		   	=> 'id',
				'order'		   	=> 'asc',
				'limit'			=> 500
				), 'json');

		$checklists = new stdClass();
		$checklists->clssnme 			= $this->class;
		$checklists->types 				= $types->data;
		$checklists->thumbnail_url 		= $profile->thumbnail_url;
		$checklists->first_name 		= $profile->first_name;
		$checklists->last_name 			= $profile->last_name;
		$checklists->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/checklist/list/model.js');
		add_js('modules/checklist/list/directory_view.js');
		add_js('modules/checklist/list/options_view.js');
		add_js('modules/checklist/list/paginated_view.js');
		add_js('modules/checklist/list/paginated_collection.js');
		add_js('modules/checklist/list/router.js');
		
		$this->layout->view('checklist/list', $checklists);
	}

	public function document_setup()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');
	}
}