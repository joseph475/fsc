<?php
/**
 * This class represents an employee (single employee).
 */
class received extends Base
{
	// Default values
	protected $_data = array(
			'id'  			=> 0,
			'crew_id' 		=> 0,
			'vessel_id'		=> 0,
			'position_id'	=> 0,
			'date_received' => '',
			'date_expired' 	=> '',
			'date_check'	=> '',
			'document'		=> '',
			'receivedfrom'	=> '',
			'remarks'		=> '',
			'date_created'	=> '0000-00-00',
			'createdbypk'	=> 0,
			'date_modified'	=> '0000-00-00',
			'modifiedbypk'	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('received_model', '' ,true);

        return $CI->received_model;
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