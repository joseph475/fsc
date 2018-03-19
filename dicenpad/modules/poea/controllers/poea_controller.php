<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poea_controller extends Front_Controller
{
	private $class = 'CERTIFICATES';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}

    public function contract_list()
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

		$signatorys = $this->rest->get('signatorys', 
			array(
				'form_id'		=> 'POEA or RPS',
				'sort'		   	=> 'id',
				'order'		   	=> 'asc',
				'limit'			=> 500
				), 'json');

		$companys = $this->rest->get('companys', 
			array(
				'sort'		   	=> 'company_id',
				'order'		   	=> 'asc'
				), 'json');

		$purposes = $this->rest->get('options', 
			array(
				'option_group'	=> 'EMPLOYMENT-PURPOSES',
				'sort'		   	=> 'option',
				'order'		   	=> 'asc',
				'limit'			=> 500
				), 'json');
		
		$poea = new stdClass();
		$poea->clssnme 				= $this->class;
		$poea->vessels				= $vessels->data;
		$poea->signatorys			= $signatorys->data;
		$poea->purposes				= $purposes->data;
		$poea->companys				= $companys->data;
		$poea->thumbnail_url 		= $profile->thumbnail_url;
		$poea->first_name 			= $profile->first_name;
		$poea->last_name 			= $profile->last_name;	
		$poea->user_id 				= $profile->user_id;
		$poea->principal_id 		= $profile->principal_id;
		
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/poea/list/model.js');
		add_js('modules/poea/list/directory_view.js');
		add_js('modules/poea/list/paginated_view.js');
		add_js('modules/poea/list/paginated_collection.js');
		add_js('modules/poea/list/router.js');

		$this->layout->view('contract/list', $poea);
    }
}