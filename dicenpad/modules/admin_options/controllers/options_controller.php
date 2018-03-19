<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Options_controller extends Front_Controller
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

		$options2 = $this->rest->get('options2', 
			array(
				'sort'		   => 'option_group',
				'order'		   => 'asc'
				), 'json');		

		$options2->clssnme 				= $this->class;
		$options2->options_record 		= $options2->data;
		$options2->thumbnail_url 		= $profile->thumbnail_url;
		$options2->first_name 			= $profile->first_name;
		$options2->last_name 			= $profile->last_name;
		$options2->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/admin_options/list.js');
		add_js('modules/admin_options/router.js');
		
		$this->layout->view('admin_options/list', $options2);
	}
}