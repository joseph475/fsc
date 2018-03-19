<?php
/**
 * This class represents an employee (single employee).
 */
class Send_received extends Base
{
	// Default values
	protected $_data = array(
			'id'  			=> 0,
			'crew_id' 		=> 0,
			'vessel_id'		=> 0,
			'sent_thru'		=> '',
			'awb_no'		=> 0,
			'date_sent'		=> '0000-00-00',
			'date_received' => '0000-00-00',
			'date_check'	=> '0000-00-00',
			'send_by'		=> '',
			'send_by_others'=> '',
			'remarks'		=> '',
			'document'		=> '',
			'date_created'	=> '0000-00-00',
			'createdbypk'	=> 0,
			'date_modified'	=> '0000-00-00',
			'modifiedbypk'	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('send_received_model', '' ,true);

        return $CI->send_received_model;
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