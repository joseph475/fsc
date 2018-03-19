<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal_controller extends Front_Controller
{
	private $class = 'INVENTORY_SETUP';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}

    /**
	* This is the default action, lists all principal.
	*
	* @param int $page
	*/ 
	public function index()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$principal= new stdClass();
		$principal->clssnme 			= $this->class;
		$principal->options_record 		= array(array('status' => 'active'), array('status' => 'inactive'), array('status' => 'all'));
		$principal->thumbnail_url 		= $profile->thumbnail_url;
		$principal->first_name 			= $profile->first_name;
		$principal->last_name 			= $profile->last_name;
		$principal->principal_id 		= $profile->principal_id;
		
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/principal/list/model.js');
		add_js('modules/principal/list/directory_view.js');
		add_js('modules/principal/list/options_view.js');
		add_js('modules/principal/list/paginated_view.js');
		add_js('modules/principal/list/paginated_collection.js');
		add_js('modules/principal/list/router.js');
		
		$this->layout->view('principal/list', $principal);
	}

    public function principal_resume($hash = null)
    {
    	$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$principal = $this->rest->get('principal', array('hash' => $hash), 'json');

		$principal->clssnme 			= $this->class;
		$principal->thumbnail_url 		= $profile->thumbnail_url;
		$principal->first_name 			= $profile->first_name;
		$principal->last_name 			= $profile->last_name;
		$principal->principal_id 		= $profile->principal_id;
		$principal->Isedit 				= isset($principal->about)? true : false;
		if(!isset($principal->about)){
			$principal->about 			= NULL;
		  	$principal->thumb_url 		= base_url().BASE_IMG . 'user-photo.jpg';
		}

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		add_js('modules/principal/entry/principal_info.js');
		add_js('modules/principal/entry/vessel_info.js');
		
		$this->layout->view('resume/principal', $principal);
    }

    public function principal_entry($hash = null)
    {
    	$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$principal = $this->rest->get('principal', array('hash' => $hash), 'json');

		$principal->clssnme 			= $this->class;
		$principal->thumbnail_url 		= $profile->thumbnail_url;
		$principal->first_name 			= $profile->first_name;
		$principal->last_name 			= $profile->last_name;
		$principal->principal_id 		= $profile->principal_id;
		$principal->Isedit 				= isset($principal->about)? true : false;
		if($principal->id == 0){
			$principal->about 			= FALSE;
		  	$principal->thumb_url 		= base_url().BASE_IMG . 'user-photo.jpg';
		}

		add_js('libs/jquery.timeago.js');		
		add_js('libs/load-image.min.js');
		add_js('libs/tmpl.min.js');
		add_js('libs/jquery.ui.widget.js');
		add_js('libs/jquery.fileupload.js');
		add_js('libs/jquery.fileupload-fp.js');
		add_js('libs/jquery.iframe-transport.js');
		add_js('modules/principal/entry/principal_info.js');

		add_css('jquery.fileupload-ui.css');
		
		$this->layout->view('registration/principal', $principal);
    }

	public function show($hash)
	{			
		$this->principal_entry($hash);
	}

	function principal_redirect_url($hash=null)
	{	
		$this->session->set_userdata('redirect_url', (($hash)? 'principal-entry/' . $hash : 'admin'));
		if($this->session->userdata('redirect_url')){
			$redirect_url = $this->session->userdata('redirect_url');
			$this->session->unset_userdata('redirect_url');
        }

		$this->load->view('ajax', array('html' => $redirect_url));
	}

	public function view($hash)
	{			
		$this->principal_resume($hash);
	}
}