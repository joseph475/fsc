<?php
/**
 * This class represents an employee (single employee).
 */
class Joining extends Base
{
	// Default values
	protected $_data = array(
		'id' 			=> 0, 
		'crew_id' 		=> 0, 
		'position_id' 	=> 0, 
		'vessel_id'		=> 0,
		'salary_id'		=> 0,
		'sched_id'		=> 0,
		'duration_month'=> 0, 
		'onboard_id'	=> 0,
		'start_date'	=> '0000-00-00', 
		'remarks' 		=> '', 
		'isembark' 		=> '0', 
		'date_created' 	=> '0000-00-00', 
		'createdbypk' 	=> 0, 
		'date_modified' => '0000-00-00', 
		'modifiedbypk' 	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('joining_model', '' ,true);

        return $CI->joining_model;
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

	public function remove()
	{	
		$ci =& get_instance();

		$user = $ci->get_user();

		return $this->getModel()->remove($this->getId());
	}
}