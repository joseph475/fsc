<?php
/**
 * This class represents an employee (single employee).
 */
class Admin_department extends Base
{
	// Default values
	protected $_data = array(
		'id' 			=> 0,
        'option_code' 	=> '',
        'option' 		=> '',
        'inactive' 		=> 0,
        'deleted' 		=> 0,
        'sort_order' 	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('admin_department_model', '' ,true);

        return $CI->admin_department_model;
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