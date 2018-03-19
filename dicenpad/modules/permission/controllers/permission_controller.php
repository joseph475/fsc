<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission_controller extends Front_Controller
{
	private $class = 'ALL_ACCESS';
	public function __construct()
	{
		parent::__construct();

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
		if ($this->rest->status() == '404') {
			redirect ('admin');
		}
		
		$roles = $this->rest->get('admin_roles', 
			array(
				'sort'		   	=> 'role_order',
				'order'		   	=> 'asc'
				), 'json');

		$permissions = new stdClass();
		$permissions->options_record 		= $roles->data;
		$permissions->thumbnail_url 		= $profile->thumbnail_url;
		$permissions->first_name 			= $profile->first_name;
		$permissions->last_name 			= $profile->last_name;
		$permissions->principal_id 			= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/permission/list/model.js');
		add_js('modules/permission/list/directory_view.js');
		add_js('modules/permission/list/options_view.js');
		add_js('modules/permission/list/paginated_view.js');
		add_js('modules/permission/list/paginated_collection.js');
		add_js('modules/permission/list/router.js');
		
		$this->layout->view('permission/list', $permissions);
	}
}