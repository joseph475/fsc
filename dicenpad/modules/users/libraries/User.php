<?php

/**
 * This class represents a User.
 */
class User extends Base
{	
	protected $_data = array(
		'user_id'     => 0,
		'login'       => null,
		'password'    => 'password',
		'email'       => '',
		'inactive'    => 0,
		'first_name'  => null,
		'last_name'   => '',
		'nick_name'   => '',
		'hash'  	  => '',
		'theme' 	  => 'default',
		'language' 	  => 'english',
		'timezone'    => 'Asia/Manila',
		'last_login'  => '0000-00-00 00:00:00',
		'login_count' => 0,
		'position_id' => 0,
		'department_id' => 0,
		'company_id'  	=> 0,
		'role_id' 	  	=> 0,
		'applicant_id' 	=> 0,
		'division_id' 	=> 0,
		'job_title_id' 	=> 0,
		'deleted' 	  	=> 0	
		);

	protected $_validators = array(
        'first_name' => array('Zend_Validate_NotEmpty'),
        'last_name' => array('Zend_Validate_NotEmpty'),
        //'login' => array('Zend_Validate_NotEmpty')
        );

	// Store about for caching on one instance used in getData.
	private $_about = null;
	private $_ref 	= null;

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('users_model', '' ,true);
        
        return $CI->users_model;
	}

	// --------------------------------------------------------------------
	
	public function save()
	{
		$CI =& get_instance();

		$CI->db->trans_begin();

		$tmp = parent::save();

		if (!$tmp) {
			return FALSE;
		} else {
			$about = $this->getAbout();
			$about->user_id 	= $tmp;
			$about->about_me 	= 'About me';
			$about->talent 		= 'Talent right here';
			$about->movies 		= 'Some movies';
			$about->music 		= 'Some music';
			$about->dreams 		= 'Some dreams';

			if (!$about->save()) {
				// Join validation errors.
				$this->_validation_errors = array_merge($this->get_validation_errors(), $about->get_validation_errors());
				$CI->db->trans_rollback();
				return FALSE;
			}
		}

		$CI->db->trans_commit();

		return $tmp;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the About object of this employee.
	 * @return Position
	 */
	public function getAbout()
	{
		// Check if _about has already been requested by this instance.
		// To avoid multiple calls to the DB.
		if (is_null($this->_about)) {
			$ci =& get_instance();
			$ci->load->library('user/about');

			$about = new About();
			$about->load($this->user_id, 'user_id');	

			if (is_null($about->id)) {			
				$about->loadArray($this->_data);
			}

			$this->_about = $about;
		}

		return $this->_about;
	}

	// --------------------------------------------------------------------

	/**
	 * Return full name.
	 *
	 * @return string.
	 */
	public function getFullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	// --------------------------------------------------------------------

	/**
	 * Return the profile link.
	 * 
	 * @return Position
	 */
	public function getProfileLink()
	{
		return site_url('profile/' . $this->hash);
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Department object of this employee.
	 * @return Department
	 */
	public function getDepartment()
	{
		$ci =& get_instance();
		$ci->load->library('department');

		$department = new Department($this->department_id);				

		return $department;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Company object of this employee.
	 * @return company
	 */
	public function getCompany()
	{
		$ci =& get_instance();
		$ci->load->library('company');
				
		$company = new Company($this->company_id);			

		return $company;
	}


	public function getContact()
	{
		$ci =& get_instance();

		$ci->load->library('user/contact');

        return $ci->contact->getModel()->get_by_user($this->user_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Position object of this employee.
	 * @return Position
	 */
	public function getPosition()
	{
		$ci =& get_instance();
		$ci->load->library('position');		
						
		$position = new Position($this->position_id);

		return $position;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the profile photo URL
	 * 
	 * @return string
	 */
	public function getPhotoUrl()
	{
        if ($about = $this->getAbout()) {
        	$ci =& get_instance();
            $ci->load->config('dir');
            $upload_path = $ci->config->item('upload_dir');

			$path = $upload_path . 'media/' . $about->photo;            

            if (!file_exists($path) || $about->photo == '') {
                $url = base_url().BASE_IMG . 'user-photo.jpg';
            } else {
                $url = site_url($path);
            }
        }	

        return $url;	
	}

	// --------------------------------------------------------------------

	/**
	 * Get the profile photo thumbnial URL
	 * 
	 * @return string
	 */
	public function getThumbnailUrl()
	{
        if ($about = $this->getAbout()) {
        	$ci =& get_instance();
            $ci->load->config('dir');
            $upload_path = $ci->config->item('upload_dir');

			$path = $upload_path . 'media/thumbnails/' . $about->photo;            

            if (!file_exists($path) || $about->photo == '') {
                $url = base_url().BASE_IMG . 'user-photo.jpg';
            } else {
                $url = site_url($path);
            }
        }	

        return $url;
	}

	public function getData()
	{
		$data = parent::getData();        
			
        $data['about']     = $this->getAbout()->getData();
        $data['contact']   = $this->getContact();
        $data['photo_url'] = $this->getPhotoUrl();
        $data['thumbnail_url'] = $this->getThumbnailUrl();

        return $data;
	}

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}
}