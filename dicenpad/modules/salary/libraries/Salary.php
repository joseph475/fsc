<?php
/**
 * This class represents an employee (single employee).
 */
class Salary extends Base
{
	// Default values
	protected $_data = array(
		'id'  			=> 0,
		'position_id'	=> 0,
		'vessel_id'   	=> 0,
		'effective_year'=> '',
		'basic_salary' 	=> 0.00,
		'ot_fixed' 		=> 0.00,
		'ot_hourly'		=> 0.00,
		'leave_pay'		=> '',
		'leave_day'		=> 0,
		't_allowance'	=> 0.00,
		's_allowance'	=> 0.00,
		'other_benefits'=> 0.00,
		'rtmt_fee'		=> 0.00,
		'nos_slot'		=> 0,
		'nos_hours'		=> 0.00
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('salary_model', '' ,true);

        return $CI->salary_model;
	}

	// --------------------------------------------------------------------
	
	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}

	// --------------------------------------------------------------------

	public function getData()
	{		
		$data = parent::getData(); 

		return $data;		
	}
}