<?php
/**
 * This class represents an crew (single crew).
 */
class Crew extends Base
{
	// Default values
	protected $_data = array(
		'crew_id' 		=> 0,
		'status_id' 	=> 1,
		'position_id'	=> 0,
		'payroll_id' 	=> 0,
		'profit_id'		=> 0,
		'position'		=> '',
		'position_id2'	=> 0,
		'lastname' 		=> '', 
		'firstname' 	=> '', 
		'middlename' 	=> '',
		'fullname'		=> '',
		'birthplace' 	=> '',
		'birth_province'=> '',
		'birthdate' 	=> '',
		'age' 			=> '',
		'pres_address' 	=> '',
		'pres_tel' 		=> '',
		'cellphone'		=> '',
		'prov_address' 	=> '',
		'prov_tel' 		=> '',
		'civil_status' 	=> '',
		'gender' 		=> '',
		'height' 		=> '',
		'weight' 		=> '',
		'religion' 		=> '',
		'sss_no' 		=> '00-0000000-0',
		'tin_no' 		=> '000-000-000',
		'clothe_size' 	=> '',
		'shoe_size' 	=> '',
		'blood_type' 	=> '',
		'blood_pressure'=> '',
		'email'			=> '',
		'spouse'		=> '',
		'spouse_add' 	=> '',
		'spouse_bdate' 	=> '',
		'spouse_telephone' 	=> '',
		'father' 		=> '',
		'father_add' 	=> '',
		'father_bdate' 	=> '',
		'father_telephone' 	=> '',
		'mother' 		=> '',
		'mother_add' 	=> '',
		'mother_bdate' 	=> '',
		'mother_telephone' 	=> '',
		'emeg_contact' 	=> '',
		'emeg_add' 		=> '',
		'emeg_tel' 		=> '',
		'benef_fname'	=> '',
		'benef_lname'	=> '',
		'benef_mname'	=> '',
		'benef_relation'=> '',
		'benef_add' 	=> '',
		'photo' 		=> '',
		'hash' 			=> '',
		'read_write'	=> '',
		'speak_listen'	=> '',
		'other_language'=> '',
		'pa_family'		=> '',
		'pa_smoking'	=> '',
		'pa_drinking'	=> '',
		'pa_prev_ill'	=> '',
		'pa_job_ability'=> '',
		'pa_motivation' => '',
		'pa_change'		=> '',
		'remarks'		=> '',
		'date_created'	=> '0000-00-00',
		'createdbypk'	=> '',
		'date_modified'	=> '0000-00-00',
		'modifiedbypk'	=> ''
		);

	// Store about for caching on one instance used in getData.
	private $_docs = null;
	private $_interview = null;

	protected $_validators = array(
        'firstname' => array('Zend_Validate_NotEmpty'),
        'lastname' => array('Zend_Validate_NotEmpty'),        
        'birthdate' => array('Zend_Validate_NotEmpty'),        
        'pres_address' => array('Zend_Validate_NotEmpty')
        );

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('crew_model', '' ,true);

        return $CI->crew_model;
	}

	// --------------------------------------------------------------------

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}

	/**
	 * Get the Document
	 * 
	 * @return string
	 */

	public function getDocs()
	{
		$ci =& get_instance();

		$ci->load->library('crew/docs');

        return $ci->docs->getModel()->get_by_crew($this->crew_id, $this->department_id, $this->division_id);
	}

	public function getDocsTable($type=0)
	{
		$ci =& get_instance();

		$ci->load->library('crew/docs');

        return $ci->docs->getModel()->get_by_Dept($this->crew_id, $type);
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Education
	 * 
	 * @return string
	 */

	public function getEducs()
	{
		$ci =& get_instance();

		$ci->load->library('crew/education');

        return $ci->education->getModel()->get_by_crew($this->crew_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Work History
	 * 
	 * @return string
	 */

	public function getWorks()
	{
		$ci =& get_instance();

		$ci->load->library('crew/works');

        return $ci->works->getModel()->get_by_crew($this->crew_id, 10);
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Work History
	 * 
	 * @return string
	 */

	public function getWorksHistory()
	{
		$ci =& get_instance();

		$ci->load->library('crew/work_history');

        return $ci->work_history->getModel()->get_by_crew($this->crew_id, 1000);
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Children
	 * 
	 * @return string
	 */

	public function getChild()
	{
		$ci =& get_instance();

		$ci->load->library('crew/children');

        return $ci->children->getModel()->get_by_crew($this->crew_id);
	}

	/**
	 * Get the Children
	 * 
	 * @return string
	 */

	public function getRemarks()
	{
		$ci =& get_instance();

		$ci->load->library('crew/remarks');

        return $ci->remarks->getModel()->get_by_crew($this->crew_id);
	}

	/**
	 * Get the Children
	 * 
	 * @return string
	 */

	public function getComment()
	{
		$ci =& get_instance();

		$ci->load->library('crew/comment');

        return $ci->comment->getModel()->get_by_crew($this->crew_id);
	}


	/**
	 * Get the About object of this employee.
	 * @return Position
	 */
	public function getInterview()
	{
		// Check if _interview has already been requested by this instance.
		// To avoid multiple calls to the DB.
		if (is_null($this->_interview)) {
			$ci =& get_instance();
			$ci->load->library('crew/interview');

			$interview = new Interview();
			$interview->load($this->crew_id, 'crew_id');	

			if (is_null($interview->id)) {			
				$interview->loadArray($interview->_data);
			}

			$this->_interview = $interview;
		}

		return $this->_interview;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the profile photo URL
	 * 
	 * @return string
	 */
	public function getPhotoUrl($type)
	{
        if ($info = parent::getData()) {
        	$ci =& get_instance();
            $ci->load->config('dir');
            $upload_path = $ci->config->item('upload_dir');

            if($type == 1){
            	$path = $upload_path . 'media/' . $info['photo']; 
            } elseif($type == 2){
            	$path = $upload_path . 'media/thumbnails/' . $info['photo']; 
            }      

            if (!file_exists($path) || $info['photo'] == '') {
            	$url = base_url().BASE_IMG . 'user-photo.jpg';
            } else {
                $url = site_url($path);
            }
        }	

        return $url;	
	}

	// --------------------------------------------------------------------
	
	public function getData()
	{		
		$data 					= parent::getData(); 
		//$data['about'] 			= parent::getData(); 
		$data['docs']  			= $this->getDocs();
		// // $data['docs_by_deck']  	= $this->getDocsTable(0);
		// // $data['docs_by_engine'] = $this->getDocsTable(1);
        $data['interview']     = $this->getInterview()->getData();
		$data['education']  	= $this->getEducs();
		$data['works']  		= $this->getWorks();
		$data['work_history']  	= $this->getWorksHistory();
		$data['children']  		= $this->getChild();
		$data['comments']  		= $this->getComment();
		$data['remarks']  		= $this->getRemarks();
		$data['pics_url'] 		= $this->getPhotoUrl(1);
		$data['thumb_url'] 		= $this->getPhotoUrl(2);	

		return $data;		
	}
}