<?php
/**
 * This class represents an employee (single employee).
 */
class Master_form extends Base
{
	// Default values
	protected $_data = array(
		'id' 			=> 0,
        'title' 		=> '',
        'control_nos' 	=> 'FSC-CR',
        'control_nos2' 	=> '',
        'published' 	=> 0,
        'remarks'		=> '',
        'remarks2'		=> ''
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('master_form_model', '' ,true);

        return $CI->master_form_model;
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