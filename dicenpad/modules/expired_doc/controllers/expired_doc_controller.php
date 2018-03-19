<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expired_doc_controller extends Front_Controller
{
	private $class = 'CERTIFICATES';

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
				'sort'		   	=> 'vessel_name',
				'order'		   	=> 'asc',
				'limit'			=> 1000,
				), 'json');

		$documents = $this->rest->get('documents', 
			array(
				'published'		=> 1,
				'sort'		   	=> 'document ',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$signatorys = $this->rest->get('signatorys', 
			array(
				'form_id'		=> 'Expired Documents',
				'sort'		   	=> 'id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$companys = $this->rest->get('companys', 
			array(
				'sort'		   	=> 'company_id',
				'order'		   	=> 'asc'
				), 'json');

		$expired_doc = new stdClass();
		$expired_doc->clssnme 			= $this->class;
		$expired_doc->signatorys		= $signatorys->data;
		$expired_doc->thumbnail_url 	= $profile->thumbnail_url;
		$expired_doc->documents			= $documents->data;
		$expired_doc->companys			= $companys->data;
		$expired_doc->vessels			= $vessels->data;
		$expired_doc->first_name 		= $profile->first_name;
		$expired_doc->last_name 		= $profile->last_name;
		$expired_doc->user_id 			= $profile->user_id;
		$expired_doc->principal_id 		= $profile->principal_id;
		
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/expired_doc/list/model.js');
		add_js('modules/expired_doc/list/directory_view.js');
		add_js('modules/expired_doc/list/options_view.js');
		add_js('modules/expired_doc/list/paginated_view.js');
		add_js('modules/expired_doc/list/paginated_collection.js');
		add_js('modules/expired_doc/list/router.js');
		
		$this->layout->view('expired_doc/list', $expired_doc);
	}
}