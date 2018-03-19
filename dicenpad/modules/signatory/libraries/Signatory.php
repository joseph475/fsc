<?php
/**
 * This class represents an employee (single employee).
 */
class Signatory extends Base
{
	// Default values
	protected $_data = array(
		'id' 			=> 0,
        'form_id' 		=> 0,
        'admin_position_id'	=> '',
        'salutation'	=> '',
        'firstname' 	=> 0,
        'lastname' 		=> 0,
        'middlename' 	=> 0,
        'published'		=> 0,
        'datecreated'	=> '0000-00-00',
        'createdbypk'	=> 0,
        'datemodified'	=> '0000-00-00',
        'modifiedbypk'	=> 0,
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('signatory_model', '' ,true);

        return $CI->signatory_model;
	}

	// --------------------------------------------------------------------
	
	public function getData()
	{		
		$data = parent::getData(); 

		return $data;		
	}

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}
}
