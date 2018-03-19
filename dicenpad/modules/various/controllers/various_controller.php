<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Various_controller extends Front_Controller
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

		$documents = $this->rest->get('documents', 
			array(
				'published'		=> 1,
				'sort'		   	=> 'document',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$column1 = new stdClass();
		$column2 = new stdClass();
		$column3 = new stdClass();

		$column1 = $this->rest->get('document_various', array('id' => 1), 'json');
		$column2 = $this->rest->get('document_various', array('id' => 2), 'json');
		$column3 = $this->rest->get('document_various', array('id' => 3), 'json');

		$various = new stdClass();
		$various->column1 				= $column1->docs_id;
		$various->column2 				= $column2->docs_id;
		$various->column3 				= $column3->docs_id;
		$various->clssnme 				= $this->class;
		$various->vessels				= $vessels->data;
		$various->documents				= $documents->data;
		$various->thumbnail_url 		= $profile->thumbnail_url;
		$various->first_name 			= $profile->first_name;
		$various->last_name 			= $profile->last_name;	
		$various->principal_id 			= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/various/list/model.js');
		add_js('modules/various/list/directory_view.js');
		add_js('modules/various/list/options_view.js');
		add_js('modules/various/list/paginated_view.js');
		add_js('modules/various/list/paginated_collection.js');
		add_js('modules/various/list/router.js');

		$this->layout->view('various/list', $various);
	}

	public function draft_list()
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

		$documents = $this->rest->get('documents', 
			array(
				'published'		=> 1,
				'sort'		   	=> 'document',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$column1 = new stdClass();
		$column2 = new stdClass();
		$column3 = new stdClass();

		$column1 = $this->rest->get('document_various', array('id' => 1), 'json');
		$column2 = $this->rest->get('document_various', array('id' => 2), 'json');
		$column3 = $this->rest->get('document_various', array('id' => 3), 'json');

		$various = new stdClass();
		$various->column1 				= $column1->docs_id;
		$various->column2 				= $column2->docs_id;
		$various->column3 				= $column3->docs_id;
		$various->clssnme 				= $this->class;
		$various->vessels				= $vessels->data;
		$various->documents				= $documents->data;
		$various->thumbnail_url 		= $profile->thumbnail_url;
		$various->first_name 			= $profile->first_name;
		$various->last_name 			= $profile->last_name;	
		$various->principal_id 			= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/various/list2/model.js');
		add_js('modules/various/list2/directory_view.js');
		add_js('modules/various/list2/options_view.js');
		add_js('modules/various/list2/paginated_view.js');
		add_js('modules/various/list2/paginated_collection.js');
		add_js('modules/various/list2/router.js');

		$this->layout->view('various/list2', $various);
	}
}