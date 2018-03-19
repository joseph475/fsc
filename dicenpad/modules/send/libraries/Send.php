<?php
/**
 * This class represents an employee (single employee).
 */
class Send extends Base
{
	// Default values
	protected $_data = array(
			'id'  			=> 0,
			'crew_id' 		=> 0,
			'vessel_id'		=> 0,
			'position_id'	=> 0,
			'date_sent' 	=> '',
			'document'		=> '',
			'send_by'		=> '',
			'awb_no'		=> '',
			'remarks'		=> '',
			'sent_thru'		=> '',
			'date_created'	=> '0000-00-00',
			'createdbypk'	=> 0,
			'date_modified'	=> '0000-00-00',
			'modifiedbypk'	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('send_model', '' ,true);

        return $CI->send_model;
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