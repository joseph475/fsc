<?php
/**
 * This class represents an flight_schedule (single flight_schedule).
 */
class Flight extends Base
{
	// Default values
	protected $_data = array(
		'id' 			=> 0, 
		'sched_id'		=> 0,
		'type'			=> 'join',
		'flight_date' 	=> '0000-00-00',
		'flight_no' 	=> '', 
		'flight_time'	=> '', 
		'origin'		=> '', 
		'destination' 	=> '',
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
        $CI->load->model('flight_model', '' ,true);

        return $CI->flight_model;
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