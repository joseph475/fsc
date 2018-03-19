<?php
/**
 * This class represents an employee (single employee).
 */
class Ship_crew_document extends Base
{
	// Default values
	protected $_data = array(
		'control_nos'  	=> 0,
		'crew_id'		=> 0,
		'fullname'		=> 0,
		'code'   		=> NULL,
		'position'		=> NULL,
		'joining_date'  => 0,
		'repat_date'	=> 0,
		'vessel_id'		=> 0,
		'vessel_name'	=> 0,
		'crew_document'	=> 0,
		'ship_document' => 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('ship_crew_document_model', '' ,true);

        return $CI->ship_crew_document_model;
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