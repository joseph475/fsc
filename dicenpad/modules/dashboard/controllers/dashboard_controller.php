<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard_controller extends Front_Controller
{
	private $class = 'dashboard';

	public function __construct()
	{
	   parent::__construct();	
	}

	public function index()
	{		
		$profile = $this->rest->get('user', null, 'json');

		if ($this->rest->status() == '404') redirect ('admin');

		// $tops = new stdClass();
		// $tops = $this->rest->get('tops', 
		// 	array(
		// 		'sort'		   => 'admin_keys_history.user_id',
		// 		'order'		   => 'asc',
		// 		'limit'		   => 5	
		// 		), 'json');	

		$dashboard = new stdClass();
		// $dashboard->own_profile			= ($this->session->userdata('user_id') == $profile->user_id);
		// $dashboard->data 				= isset($tops)? $tops->data : '';
		$dashboard->thumbnail_url 		= $profile->thumbnail_url;
		$dashboard->first_name 			= $profile->first_name;
		$dashboard->last_name 			= $profile->last_name;
		$dashboard->principal_id 		= $profile->principal_id;
		$this->layout->view('dashboard', $dashboard);
	}
	
}