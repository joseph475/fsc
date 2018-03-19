<?php
/**
 * This class represents an principal (single principal).
 */
class Principal extends Base
{
	// Default values
	protected $_data = array(
		'id' 			=> 0,
		'fullname' 		=> '',
		'code' 			=> '',
		'alternate' 	=> '',
		'status' 		=> '',
		'address' 		=> '',
		'sss' 			=> '',
		'cable' 		=> '',
		'telno1'		=> '',
		'telno2'		=> '',
		'telno3'		=> '',
		'fax1'			=> '',
		'fax2'			=> '',
		'fax3'			=> '',
		'telefax'		=> '',
		'person1'		=> '',
		'designate1'	=> '',
		'contact1'		=> '',
		'person2'		=> '',
		'designate2'	=> '',
		'contact2'		=> '',
		'accredited'	=> '0000-00-00',
		'photo'			=> '',
		'hash'			=> '',
		'date_created'	=> '0000-00-00',
		'createdbypk'	=> '',
		'date_modified'	=> '',
		'modifiedbypk'	=> ''
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('principal_model', '' ,true);

        return $CI->principal_model;
	}

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}

	// --------------------------------------------------------------------

	/**
	 * Get the principal photo URL
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