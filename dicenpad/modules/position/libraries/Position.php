<?php
/**
 * This class represents an employee (single employee).
 */
class Position extends Base
{
	// Default values
	protected $_data = array(
		'id'  			=> 0,
		'department_id'	=> 0,
		'division_id'   => 0,
		'position'    	=> '',
		'alternate'    	=> '',
		'code'    		=> '',
		'inactive'		=> 0,
		'deleted'		=> 0,
		'sort_order'	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('position_model', '' ,true);

        return $CI->position_model;
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