<?php
/**
 * This class represents an employee (single employee).
 */
class Promotion extends Base
{
	// Default values
	protected $_data = array(
		'id' 			=> 0, 
		'crew_id' 		=> 0,
		'sched_id'		=> 0,
		'salary_id'		=> 0,
		'position_new' 	=> 0, 
		'position_old' 	=> 0, 
		'onboard_id'	=> 0,
		'extension'		=> 0,
		'onboard_id2'	=> 0,
		'duration_month'=> 1,
		'date_promoted' => '0000-00-00',
		'extension_date'=> '0000-00-00',
		'ispromoted'	=> 0,
		'remarks' 		=> '', 
		'date_created' 	=> '0000-00-00', 
		'createdbypk' 	=> 0, 
		'date_modified' => '0000-00-00', 
		'modifiedbypk' 	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('promotion_model', '' ,true);

        return $CI->promotion_model;
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