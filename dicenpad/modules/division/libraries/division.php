<?php
/**
 * This class represents an employee (single employee).
 */
class Division extends Base
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
        $CI->load->model('division_model', '' ,true);

        return $CI->division_model;
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