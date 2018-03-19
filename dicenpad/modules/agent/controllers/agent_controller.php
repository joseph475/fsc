<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent_controller extends Front_Controller
{
	private $class = 'INVENTORY_SETUP';

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

		$principal = $this->rest->get('principals', 
			array(
				'sort'		   => 'id',
				'order'		   => 'asc'
				), 'json');
		
		$agents = new stdClass();
		$agents->clssnme 			= $this->class;
		$agents->principal 			= $principal->data;
		$agents->thumbnail_url 		= $profile->thumbnail_url;
		$agents->first_name 		= $profile->first_name;
		$agents->last_name 			= $profile->last_name;
		$agents->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('modules/agent/list.js');
		add_js('modules/agent/router.js');
		
		$this->layout->view('agent/list', $agents);
	}

    public function agent_resume($hash = null)
    {
    	$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$agent = $this->rest->get('agent', array('hash' => $hash), 'json');

		$agent->clssnme 			= $this->class;
		$agent->thumbnail_url 		= $profile->thumbnail_url;
		$agent->first_name 			= $profile->first_name;
		$agent->last_name 			= $profile->last_name;
		$agent->principal_id 		= $profile->principal_id;
		$agent->Isedit 				= isset($agent->about)? true : false;
		if(!isset($agent->about))	$agent->about = NULL;
		
		$this->layout->view('resume/agent', $agent);
    }

    public function agent_entry($hash = null)
    {
    	$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$agent = $this->rest->get('agent', array('hash' => $hash), 'json');

		$principals = $this->rest->get('principals', 
						array(
							'status'		=> 'Active',
							'sort'		   	=> 'id',
							'order'		   	=> 'asc',
							'limit'			=> 1000
							), 'json');

		$agent->clssnme 			= $this->class;
		$agent->principals 			= $principals->data;
		$agent->thumbnail_url 		= $profile->thumbnail_url;
		$agent->first_name 			= $profile->first_name;
		$agent->last_name 			= $profile->last_name;
		$agent->principal_id 		= $profile->principal_id;
		$agent->Isedit 				= isset($agent->about)? true : false;
		if($agent->id == 0) {
			$agent->about = FALSE;
		}

		add_js('libs/jquery.timeago.js');		
		add_js('libs/load-image.min.js');
		add_js('libs/tmpl.min.js');
		add_js('libs/jquery.ui.widget.js');
		add_js('libs/jquery.fileupload.js');
		add_js('libs/jquery.fileupload-fp.js');
		add_js('libs/jquery.iframe-transport.js');
		add_js('modules/agent/agent_info.js');

		add_css('jquery.fileupload-ui.css');
		
		$this->layout->view('registration/agent', $agent);
    }

	public function show($hash)
	{			
		$this->agent_entry($hash);
	}

	public function view($hash)
	{			
		$this->agent_resume($hash);
	}

	function agent_redirect_url($hash=null)
	{	
		$this->session->set_userdata('redirect_url', (($hash)? 'agent-master-list' : 'admin'));
		if($this->session->userdata('redirect_url')){
			$redirect_url = $this->session->userdata('redirect_url');
			$this->session->unset_userdata('redirect_url');
        }

		$this->load->view('ajax', array('html' => $redirect_url));
	}
}