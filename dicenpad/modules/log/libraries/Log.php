<?php
/**
 * This class represents an employee (single employee).
 */
class Log extends Base
{
	// Default values
	protected $_data = array(
		'id'  			=> 0,
		'user_id'		=> 0,
		'key'   		=> NULL,
		'created'    	=> NULL,
		'ip_address'    => NULL
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('log_model', '' ,true);

        return $CI->log_model;
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