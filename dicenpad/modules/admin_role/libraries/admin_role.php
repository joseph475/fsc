<?php
/**
 * This class represents an employee (single employee).
 */
class Admin_role extends Base
{
	// Default values
	protected $_data = array(
		'role_id' 		=> 0,
        'role_code' 	=> '',
        'role' 			=> '',
        'inactive' 		=> 0,
        'deleted' 		=> 0,
        'role_order' 	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('admin_role_model', '' ,true);

        return $CI->admin_role_model;
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