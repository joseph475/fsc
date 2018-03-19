<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Table_content_controller extends Front_Controller
{
	private $class = 'ADMINISTRATIVE';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}

    public function table_contents()
    {
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$vessels = $this->rest->get('vessels', 
					array(
						'status'		=> 'active',
						'sort'		   	=> 'vessel_name',
						'order'		   	=> 'asc',
						'limit'			=> 1000
						), 'json');

		$departments = $this->rest->get('departments', 
					array(
						'published'		=> 1,
						'sort'		   	=> 'id',
						'order'		   	=> 'asc',
						'limit'			=> 1000
						), 'json');

		$crews = new stdClass();
		$crews->clssnme 			= $this->class;
		$crews->options_record 		= $departments->data;
		$crews->vessels				= $vessels->data;
		$crews->thumbnail_url 		= $profile->thumbnail_url;
		$crews->first_name 			= $profile->first_name;
		$crews->last_name 			= $profile->last_name;	
		$crews->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/table_content/list/model.js');
		add_js('modules/table_content/list/directory_view.js');
		add_js('modules/table_content/list/options_view.js');
		add_js('modules/table_content/list/paginated_view.js');
		add_js('modules/table_content/list/paginated_collection.js');
		add_js('modules/table_content/list/router.js');

		$this->layout->view('table_content/list', $crews);
    }
}