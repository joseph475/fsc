<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_controller extends Front_Controller
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
		
		$options = $this->rest->get('options', 
					array(
						'option_group'	=> 'DOCUMENT-CLASSIFICATION',
						'sort'		   	=> 'sort_order',
						'order'		   	=> 'asc',
						'limit'			=> 100
						), 'json');

		$flags = $this->rest->get('flags', 
					array(
						'published'		=> TRUE,
						'sort'		   	=> 'id',
						'order'		   	=> 'asc',
						'limit'			=> 1000
						), 'json');

		$all = new stdClass();
		$all->option = 'All';
		$all->option_id = '';
		$all->id = '';

		(object) array_push( $options->data,  $all);

		$documents = new stdClass();
		$documents->clssnme 			= $this->class;
		$documents->options_record 		= $options->data;
		$documents->flags 				= $flags->data;
		$documents->thumbnail_url 		= $profile->thumbnail_url;
		$documents->first_name 			= $profile->first_name;
		$documents->last_name 			= $profile->last_name;
		$documents->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/document/list/model.js');
		add_js('modules/document/list/directory_view.js');
		add_js('modules/document/list/options_view.js');
		add_js('modules/document/list/paginated_view.js');
		add_js('modules/document/list/paginated_collection.js');
		add_js('modules/document/list/router.js');
		
		$this->layout->view('document/list', $documents);
	}
}