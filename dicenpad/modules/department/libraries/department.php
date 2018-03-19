<?php
/**
 * This class represents an employee (single employee).
 */
class Department extends Base
{
	// Default values
	protected $_data = array(
		'id' => 0,
        'option_code' => '',
        'option' => '',
        'published' => 1,
        'deleted' => 0,
        'sort_order' => 0,
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('department_model', '' ,true);

        return $CI->department_model;
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