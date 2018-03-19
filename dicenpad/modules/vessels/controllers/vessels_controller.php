<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vessels_controller extends Front_Controller
{
	private $class = 'INVENTORY_SETUP';

	public function __construct()
	{
		parent::__construct();
		
		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}

   	/**
	* This is the default action, lists all Vessels.
	*
	* @param int $page
	*/ 
	public function index()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$vessels = new stdClass();
		$vessels->clssnme 			= $this->class;
		$vessels->options_record 	= array(array('status' => 'active'), array('status' => 'inactive'), array('status' => 'all'));
		$vessels->thumbnail_url 	= $profile->thumbnail_url;
		$vessels->first_name 		= $profile->first_name;
		$vessels->last_name 		= $profile->last_name;
		$vessels->principal_id 		= $profile->principal_id;
		
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/vessels/list/model.js');
		add_js('modules/vessels/list/directory_view.js');
		add_js('modules/vessels/list/options_view.js');
		add_js('modules/vessels/list/paginated_view.js');
		add_js('modules/vessels/list/paginated_collection.js');
		add_js('modules/vessels/list/router.js');
		
		$this->layout->view('vessels/list', $vessels);
	}

    public function vessel_setup($vessel_id = null)
    {
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$type = $this->rest->get('type_subs', 
			array(
				'published'		=> 1,
				'sort'		   	=> 'title',
				'order'		   	=> 'asc',				
				'limit'			=> 1000
				), 'json');

		$flag = $this->rest->get('flags', 
			array(
				'published'		=> 1,
				'sort'		   	=> 'id',
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

		$vessel = $this->rest->get('vessel', array('id' => $vessel_id), 'json');

		$vessel->clssnme 				= $this->class;
		$vessel->principal				= isset($principal->data)? $principal->data : '';
		$vessel->flag					= isset($flag->data)? $flag->data : '';
		$vessel->type					= isset($type->data)? $type->data : '';
		$vessel->thumbnail_url 			= $profile->thumbnail_url;
		$vessel->first_name 			= $profile->first_name;
		$vessel->last_name 				= $profile->last_name;
		$vessel->principal_id 			= $profile->principal_id;
		$vessel->Isedit 				= isset($vessel->about)? true : false;
		if($vessel->id == 0){
			$vessel->about 				= NULL;
		  	$vessel->thumb_url 			= base_url().BASE_IMG . 'user-photo.jpg';
		}

		add_css('validationEngine.jquery.css');
		add_js('libs/jquery.validationEngine.js');
		add_js('libs/jquery.validationEngine-en.js');

		add_js('libs/jquery.timeago.js');		
		add_js('libs/load-image.min.js');
		add_js('libs/tmpl.min.js');
		add_js('libs/jquery.ui.widget.js');
		add_js('libs/jquery.fileupload.js');
		add_js('libs/jquery.fileupload-fp.js');
		add_js('libs/jquery.iframe-transport.js');

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('libs/input-mask/jquery.inputmask.js');
		add_js('libs/input-mask/jquery.inputmask.date.extensions.js');
		add_js('libs/input-mask/jquery.inputmask.extensions.js');
		
		add_js('modules/vessels/entry/vessel_info.js');
		add_js('modules/vessels/entry/documents.js');
		add_js('modules/vessels/entry/validity.js');

		add_css('jquery.fileupload-ui.css');
		
		$this->layout->view('entry/vessels', $vessel);
    }

    public function vessel_specs($vessel_id = null)
    {
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$vessel = $this->rest->get('vessel', array('id' => $vessel_id), 'json');

		$vessel->clssnme 				= $this->class;
		$vessel->thumbnail_url 			= $profile->thumbnail_url;
		$vessel->first_name 			= $profile->first_name;
		$vessel->last_name 				= $profile->last_name;
		$vessel->principal_id 			= $profile->principal_id;
		if(!isset($vessel->about)){
			$vessel->about 				= NULL;
		  	$vessel->thumb_url 			= base_url().BASE_IMG . 'user-photo.jpg';
		}

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		add_js('modules/vessels/specs');
		
		$this->layout->view('specs/vessels', $vessel);
    }
	
	public function show($id)
	{			
		$this->vessel_setup($id);
	}

	function vessel_redirect_url($hash=null)
	{	
		$this->session->set_userdata('redirect_url', (($hash)? 'vessel-entry/' . $hash : 'admin'));
		if($this->session->userdata('redirect_url')){
			$redirect_url = $this->session->userdata('redirect_url');
			$this->session->unset_userdata('redirect_url');
        }

		$this->load->view('ajax', array('html' => $redirect_url));
	}

	public function view($id)
	{			
		$this->vessel_specs($id);
	}
}