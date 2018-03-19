<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for user management
 */
class User_controller extends Front_Controller
{
	private $class = 'ALL_ACCESS';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}

    /**
	* This is the default action, lists all users.
	*
	* @param int $page
	*/	
	public function index()
	{          
        $profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$users = new stdClass();
		$users->clssnme 			= $this->class;
		$users->thumbnail_url 		= $profile->thumbnail_url;
		$users->first_name 			= $profile->first_name;
		$users->last_name 			= $profile->last_name;
		$users->principal_id 		= $profile->principal_id;

		add_css('validationEngine.jquery.css');
		add_js('libs/jquery.validationEngine.js');
		add_js('libs/jquery.validationEngine-en.js');

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/users/list/model.js');
		add_js('modules/users/list/directory_view.js');
		add_js('modules/users/list/options_view.js');
		add_js('modules/users/list/paginated_view.js');
		add_js('modules/users/list/paginated_collection.js');
		add_js('modules/users/list/router.js');
		
		$this->layout->view('users/list', $users);
	}

	public function create_user()
	{          
        $profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$position = $this->rest->get('admin_positions', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$department = $this->rest->get('admin_departments', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'department_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$role = $this->rest->get('admin_roles', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'role_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$company = $this->rest->get('companys', 
			array(
				'inactive'		=> '0',
				'sort'		   	=> 'company_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$users = new stdClass();
		$users->clssnme 			= $this->class;
		$users->roles 				= isset($role->data)? $role->data : '';
		$users->companys 			= isset($company->data)? $company->data : '';
		$users->positions 			= isset($position->data)? $position->data : '';
		$users->departments 		= isset($department->data)? $department->data : '';
		$users->thumbnail_url 		= $profile->thumbnail_url;
		$users->first_name 			= $profile->first_name;
		$users->last_name 			= $profile->last_name;
		$users->principal_id 		= $profile->principal_id;
		add_css('validationEngine.jquery.css');
		add_js('libs/jquery.validationEngine.js');
		add_js('libs/jquery.validationEngine-en.js');

		add_js('modules/users/entry.js');

		$this->layout->view('users/new_user', $users);
	}

	public function edit_user($user_id=0)
	{         
        $profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$position = $this->rest->get('admin_positions', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$department = $this->rest->get('admin_departments', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'department_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$role = $this->rest->get('admin_roles', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'role_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$company = $this->rest->get('companys', 
			array(
				'inactive'		=> '0',
				'sort'		   	=> 'company_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$users = new stdClass();
		$users = $this->rest->get('user', array('id' => $user_id), 'json');

		$users->clssnme 			= $this->class;
		$users->roles 				= isset($role->data)? $role->data : '';
		$users->positions 			= isset($position->data)? $position->data : '';
		$users->companys 			= isset($company->data)? $company->data : '';
		$users->departments 		= isset($department->data)? $department->data : '';
		$users->thumbnail_url 		= $profile->thumbnail_url;
		$users->firstname 			= $users->first_name;
		$users->lastname 			= $users->last_name;
		$users->middlename 			= $users->middle_name;
		$users->first_name 			= $profile->first_name;
		$users->last_name 			= $profile->last_name;
		$users->principal_id 		= $profile->principal_id;

		add_css('validationEngine.jquery.css');
		add_js('libs/jquery.validationEngine.js');
		add_js('libs/jquery.validationEngine-en.js');

		add_js('modules/users/entry.js');

		$this->layout->view('users/update_user', $users);
	}

	public function create_principal_user()
	{          
        $profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$position = $this->rest->get('admin_positions', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$department = $this->rest->get('admin_departments', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'department_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$principal = $this->rest->get('principals', 
			array(
				'status'		=> 'Active',
				'sort'		   => 'id',
				'order'		   => 'asc',
				'limit'			=> 1000
				), 'json');

		$role = $this->rest->get('admin_roles', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'role_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$company = $this->rest->get('companys', 
			array(
				'inactive'		=> '0',
				'sort'		   	=> 'company_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$users = new stdClass();
		$users->clssnme 			= $this->class;
		$users->roles 				= isset($role->data)? $role->data : '';
		$users->companys 			= isset($company->data)? $company->data : '';
		$users->positions 			= isset($position->data)? $position->data : '';
		$users->departments 		= isset($department->data)? $department->data : '';
		$users->principals 			= isset($principal->data)? $principal->data : '';
		$users->thumbnail_url 		= $profile->thumbnail_url;
		$users->first_name 			= $profile->first_name;
		$users->last_name 			= $profile->last_name;
		$users->principal_id 		= $profile->principal_id;
		
		add_css('validationEngine.jquery.css');
		add_js('libs/jquery.validationEngine.js');
		add_js('libs/jquery.validationEngine-en.js');

		add_js('modules/users/entry.js');

		$this->layout->view('users/new_user_principal', $users);
	}

	public function edit_principal_user($user_id=0)
	{         
        $profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$position = $this->rest->get('admin_positions', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$department = $this->rest->get('admin_departments', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'department_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$role = $this->rest->get('admin_roles', 
			array(
				'inactive'		=> '1',
				'sort'		   	=> 'role_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$principal = $this->rest->get('principals', 
			array(
				'status'		=> 'Active',
				'sort'		   => 'id',
				'order'		   => 'asc',
				'limit'			=> 1000
				), 'json');

		$company = $this->rest->get('companys', 
			array(
				'inactive'		=> '0',
				'sort'		   	=> 'company_id',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$users = new stdClass();
		$users = $this->rest->get('user', array('id' => $user_id), 'json');

		$users->clssnme 			= $this->class;
		$users->roles 				= isset($role->data)? $role->data : '';
		$users->positions 			= isset($position->data)? $position->data : '';
		$users->companys 			= isset($company->data)? $company->data : '';
		$users->departments 		= isset($department->data)? $department->data : '';
		$users->principals 			= isset($principal->data)? $principal->data : '';
		$users->thumbnail_url 		= $profile->thumbnail_url;
		$users->firstname 			= $users->first_name;
		$users->lastname 			= $users->last_name;
		$users->middlename 			= $users->middle_name;
		$users->first_name 			= $profile->first_name;
		$users->last_name 			= $profile->last_name;
		$users->principal_id 		= $profile->principal_id;

		add_css('validationEngine.jquery.css');
		add_js('libs/jquery.validationEngine.js');
		add_js('libs/jquery.validationEngine-en.js');

		add_js('modules/users/entry.js');

		$this->layout->view('users/update_user_principal', $users);
	}
}
