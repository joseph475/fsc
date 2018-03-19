<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_statement_controller extends Front_Controller
{
	private $class = 'BANK_STATEMENT';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}  
	
    public function index()
    {		
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$vessels = $this->rest->get('vessels', 
			array(
				'status'		=> 'Active',
				'sort'		   	=> 'id',
				'order'		   	=> 'asc'
				), 'json');
		
		$crews = new stdClass();
		$crews->clssnme 			= $this->class;
		$crews->vessels				= $vessels->data;
		$crews->thumbnail_url 		= $profile->thumbnail_url;
		$crews->first_name 			= $profile->first_name;
		$crews->last_name 			= $profile->last_name;	
		$crews->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		add_js('libs/jquery.formatcurrency.js');

		add_js('modules/bank_statement/list.js');
		add_js('modules/bank_statement/router.js');

		$this->layout->view('bank_statement/list_header', $crews);
    }
}