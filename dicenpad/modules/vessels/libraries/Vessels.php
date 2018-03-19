<?php
/**
 * This class represents an employee (single employee).
 */
class Vessels extends Base
{
	// Default values
	protected $_data = array(
		'id'  			=> 0,
		'principal_id'	=> 0,
		'type_id'		=> 0,
		'flag_id'		=> 0,
		'company_id'	=> 0,
		'vessel_name'	=> '',
		'registered'	=> '',
		'builder'		=> '',
		'builtin'		=> '',
		'engine'		=> '',
		'e_year'		=> '0000',
		'manufacturer'	=> '',
		'trade'			=> '',
		'status'		=> '',
		'gross'			=> 0,
		'net'			=> 0,
		'dwt'			=> 0,
		'length'		=> 0,
		'depth'			=> 0,
		'breadth'		=> 0,
		'cylinder'		=> 0,
		'hp'			=> 0,
		'speed'			=> 0,
		'calsign'		=> 0,
		'telefax'		=> 0,
		'faxno'			=> 0,
		'certi_nos'		=> '',
		'certi_validity'	=> '0000-00-00',
		'certi_validity_to'	=> '0000-00-00',
		'official_nos'	=> 0,
		'imo_nos'		=> 0,
		'order_nos'		=> '',
		'order_date'	=> '',
		'cba'			=> '',
		'photo'			=> '',
		'classification'=> '',
		'us_visa'		=> 0,
		'duration'		=> 0,
		'date_created'	=> '0000-00-00',
		'createdbypk'	=> '',
		'date_modified'	=> '0000-00-00',
		'modifiedbypk'	=> ''
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('vessels_model', '' ,true);

        return $CI->vessels_model;
	}

	// --------------------------------------------------------------------
	
	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}

	// --------------------------------------------------------------------

	/**
	 * Get the vessel photo URL
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
		$data['about'] 			= parent::getData(); 
		$data['pics_url'] 		= $this->getPhotoUrl(1);
		$data['thumb_url'] 		= $this->getPhotoUrl(2);	

		return $data;	
	}
}