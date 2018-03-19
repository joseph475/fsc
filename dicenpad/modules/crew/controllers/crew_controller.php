<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crew_controller extends Front_Controller
{
	private $class = 'CREW';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();		
	}

    /**
	* This is the default action, lists all crew.
	*
	* @param int $page
	*/ 
	public function index()
	{		
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') {
			redirect ('admin');
		}	

		$arrstatus = array(
				'option_group'	=> 'APPLICATION-STATUS',
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc'
				);

		$arrstatus = ($profile->principal_id)? array_merge(array('option_code' => 'ON BOARD'), $arrstatus) : $arrstatus;

		$status = $this->rest->get('options', $arrstatus, 'json');

		if(!$profile->principal_id) 
		{			
			$all = new stdClass();
			$all->option = 'All';
			$all->option_id = '';
			$all->id = '';
			(object) array_push( $status->data,  $all);
		}


		$positions = $this->rest->get('positions', 
			array(
				'published'		=> 1,
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc',
				'limit'			=> 1000,
				), 'json');
		
		$personal = new stdClass();
		$personal->clssnme 				= $this->class;
		$personal->positions			= $positions->data;
		$personal->options_record		= $status->data;
		$personal->thumbnail_url 		= $profile->thumbnail_url;
		$personal->first_name 			= $profile->first_name;
		$personal->last_name 			= $profile->last_name;
		$personal->principal_id 		= $profile->principal_id;			

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/crew/list/list.js');
		add_js('modules/crew/list/router.js');

		$this->layout->view('crew/list', $personal);
	}

	public function no_position() 
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		
		$personal = new stdClass();
		$personal->clssnme 				= $this->class;
		$personal->thumbnail_url 		= $profile->thumbnail_url;
		$personal->first_name 			= $profile->first_name;
		$personal->last_name 			= $profile->last_name;	
		$personal->principal_id 		= $profile->principal_id;		

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/crew/list/no_position.js');
		add_js('modules/crew/list/router.js');

		$this->layout->view('crew/no_position', $personal);
	}

	public function show($hash)
	{			
		$this->crew_registration($hash);
	}
	
	function crew_redirect_url($hash=null)
	{	
		$this->session->set_userdata('redirect_url', (($hash)? 'crew-applicant/' . $hash : 'admin'));
		if($this->session->userdata('redirect_url')){
			$redirect_url = $this->session->userdata('redirect_url');
			$this->session->unset_userdata('redirect_url');
        }

		$this->load->view('ajax', array('html' => $redirect_url));
	}

	public function view($hash)
	{			
		$this->crew_resume($hash);
	}

	/**
	* Show a user's crew.
	* 
	* @param int $user user_id
	*/
	public function crew_resume($crew = null)
	{		
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$position = $this->rest->get('positions', 
			array(
				'inactive' 		=> 1,
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$signatory = $this->rest->get('signatorys', 
			array(
				'sort'		   	=> 'id',
				'order'		   	=> 'asc',
				'limit'			=> 500
				), 'json');

		$vessel = $this->rest->get('vessels', 
			array(
				'status' 		=> 'Active',
				'sort'		   	=> 'vessel_name',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$personal = $this->rest->get('crew', array('hash' => $crew), 'json');	

		$personal->clssnme 				= $this->class;
		$personal->thumbnail_url 		= $profile->thumbnail_url;
		$personal->first_name 			= $profile->first_name;
		$personal->last_name 			= $profile->last_name;
		$personal->principal_id 		= $profile->principal_id;
		$personal->positions			= isset($position->data)? $position->data : '';
		$personal->vessels				= isset($vessel->data)? $vessel->data : '';
		$personal->signatorys			= isset($signatory->data)? $signatory->data : '';
		$personal->Isedit 				= ($personal->crew_id)? true : false;
		$personal->effective_year 		= date('Y'); 
		
		$this->db->order_by('effective_year', 'ASC');
		$this->db->select('effective_year');
		$obj = $this->db->get('salary', 1);

        if ($obj->num_rows > 0)
        {
            if ($obj->num_rows == 1)
            {   
                $personal->effective_year  = $obj->row()->effective_year;
            }
        } 

		
		if(!$personal->crew_id) redirect('crew-applicant');

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/crew/personal/resume.js');
		
		$this->layout->view('resume/resume', $personal);
	}

	/**
	* Show a crew's profile.
	* 
	* @param int $crew crew_id
	*/
	public function crew_registration($crew = 0)
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$religion = $this->rest->get('options', 
			array(
				'option_group' => 'RELIGION',
				'sort'		   => 'option_group',
				'order'		   => 'asc',
				'limit'			=> 1000
				), 'json');
		
		$position = new stdClass();
		$position = $this->rest->get('positions', 
			array(
				'inactive' 		=> 1,
				'sort'		   	=> 'sort_order',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$relations = $this->rest->get('options', 
			array(
				'option_group' => 'RELATIONSHIP',
				'sort'		   => 'option_group',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$comments = $this->rest->get('options', 
			array(
				'option_group' => 'SPECIAL-COMMENTS',
				'sort'		   => 'option_group',
				'order'		   	=> 'asc',
				'limit'			=> 1000
				), 'json');

		$type = $this->rest->get('type_subs', 
			array(
				'published'		=> 1,
				'sort'		   	=> 'id',
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

		$vessels = $this->rest->get('vessels', 
			array(
				'status'		=> 'Active',
				'sort'		   	=> 'vessel_name',
				'order'		   	=> 'asc',
				'limit'			=> 500
				), 'json');
	
	
		$personal = $this->rest->get('crew', array('hash' => $crew), 'json');

		$personal->clssnme 				= $this->class;
		$personal->thumbnail_url 		= $profile->thumbnail_url;
		$personal->first_name 			= $profile->first_name;
		$personal->last_name 			= $profile->last_name;
		$personal->principal_id 		= $profile->principal_id;
		$personal->religion_list		= $religion->data;
		$personal->positions			= isset($position->data)? $position->data : '';
		$personal->types				= isset($type->data)? $type->data : '';
		$personal->vessels				= isset($vessels->data)? $vessels->data : '';
		$personal->relations			= $relations->data;
		$personal->comments				= $comments->data;
		$personal->flags				= $flag->data;

		$personal->status  				= isset($personal->status)? $personal->status : '';

		if(!$personal->crew_id)	$personal->thumb_url = base_url().BASE_IMG . 'user-photo.jpg';

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
		add_js('libs/ajaxfileupload.js');
		
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		
		add_js('libs/input-mask/jquery.inputmask.js');
		add_js('libs/input-mask/jquery.inputmask.date.extensions.js');
		add_js('libs/input-mask/jquery.inputmask.extensions.js');

		//add_js('modules/crew/registration/registration.js');
		add_js('modules/crew/registration/personal_info.js');
		add_js('modules/crew/registration/education.js');
		add_js('modules/crew/registration/children.js');
		add_js('modules/crew/registration/works.js');
		add_js('modules/crew/registration/documents.js');
		add_js('modules/crew/registration/comment.js');
		add_js('modules/crew/registration/assessment.js');
		add_js('modules/crew/registration/interview.js');
		add_js('modules/crew/registration/language.js');
		add_js('modules/crew/registration/remarks.js');

		add_css('jquery.fileupload-ui.css');
		
		$this->layout->view('registration/registration', $personal);		
	}

	function validate_entry()
	{
		$response = array('status' => 400, 'entry' => '');


		$array = array(	'lastname' => $this->input->post('lastname'), 
						'firstname' => $this->input->post('firstname'), 
						'middlename' => $this->input->post('middlename'), 
						'birthdate' => $this->input->post('birthdate')
						);

		// Request keys from the API server.
		$member = new stdClass();
		$member = $this->rest->post('crew_validate', $array, 'json');

		if($member) {
			$response = TRUE;
		} else {
			$response = FALSE;
		}

		$this->load->view('ajax', array('json' => $response));
	}

	function load_position()
	{
		$response = array('status' => 400, 'entry' => '');
		$salary	= ($_POST['ids'])? $_POST['ids'] : '0';
		$year	= ($_POST['effective_year'])? $_POST['effective_year'] : '0';

		// Request keys from the API server.
		$position = new stdClass();
		$position = $this->rest->get('salarys', 
			array(
				'vessel_id'			=> $salary,
				'effective_year'	=> $year,
				'published'			=> 1,
				'sort'		   		=> 'jd_position.sort_order',
				'order'		   		=> 'asc',
				'limit'				=> 1000
				), 'json');

		if($position->_count == 0) {
			$response = FALSE;
		} else {
			$response['entry'] = $position->data;
		}

		$this->load->view('ajax', array('json' => $response));
	}
}