<?php
/**
 * This class represents an crew (single crew).
 */
class Replacement_plan extends Base
{
	// Default values
	protected $_data = array(
		'control_nos' 	=> 0, 
		'joining_date' 	=> '0000-00-00', 
		'repat_date' 	=> '0000-00-00', 
		'vessel_name' 	=> '', 
		'joining_port' 	=> '', 
		'airport'		=> '',
		'embark'		=> '',
		'disembark'		=> ''
		);


	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('replacement_plan_model', '' ,true);

        return $CI->replacement_plan_model;
	}

	// --------------------------------------------------------------------

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}
	
	public function getData()
	{		
		$data 					= parent::getData(); 

		return $data;		
	}
}