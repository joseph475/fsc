<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_controller extends Front_Controller
{
	public function __construct()
	{
	   parent::__construct();	   
	}

    // --------------------------------------------------------------------

    /**
	* Show current user's profile.
	*	
	*/	
	public function index()
	{		
		$this->_user();
	}

	// --------------------------------------------------------------------
	
	public function show($hash)
	{			
		$this->_user($hash);
	}

	// --------------------------------------------------------------------

	/**
	* Show a user's profile.
	* 
	* @param int $user user_id
	*/
	private function _user($user = null)
	{
		
		$profile = $this->rest->get('user', array('id' => $user), 'json');
		
		if ($this->rest->status() == '404') {
			redirect ('employee/dashboard');
		}

		add_js('modules/feeds.js');		
		add_js('libs/jquery.timeago.js');
		add_js('modules/profile/contact.js');
		
		if ($profile->own_profile = ($this->session->userdata('user_id') == $profile->user_id)) {
			add_js('modules/profile/about.js');
			add_js('libs/load-image.min.js');
			add_js('libs/jquery.ui.widget.js');
			add_js('libs/tmpl.min.js');
			add_js('libs/jquery.fileupload.js');
			add_js('libs/jquery.fileupload-fp.js');
			//add_js('libs/jquery.fileupload-ui.js');
			add_js('libs/jquery.iframe-transport.js');
			add_js('modules/profile/upload_photo.js');
			add_js('modules/profile.js');
			
			add_css('jquery.fileupload-ui.css');
		}


		$this->layout->view('profile', $profile);		
	}
}