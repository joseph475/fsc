<?php
/**
 * This class represents an employee (single employee).
 */
class Schedule extends Base
{
	// Default values
	protected $_data = array(
		'id'  			=> 0,
		'control_nos'	=> 0,
		'vessel_id'   	=> 0,
		'company_id'   	=> 0,
		'han_agent_id'	=> 0,
		'cha_agent_id'	=> 0,
		'position_id'	=> 0,
		'position'		=> '',
		'joining_date'  => '0000-00-00',
		'repat_date'   	=> '0000-00-00',
		'airport'		=> '',
		'joining_port'	=> '',
		'prev_port'		=> '',
		'next_port'		=> '',
		'visa'			=> '',
		'approval_date'	=> '',
		'srp_date'		=> '',
		'remarks'		=> '',
		'onleave'		=> '0000-00-00',
		'arrival'		=> '0000-00-00',
		'airfare1'		=> 0,
		'airfare2'		=> 0,
		'revision'		=> '',
		'final_dispatch'=> 0,
		'final_flight'	=> 0,
		'advised_agent' => 0,
		'on_signers'	=> 0,
		'off_signers'	=> 0,
		'is_approve'	=> 0,
		'date_created'	=> '0000-00-00',
		'createdbypk'	=> 0,
		'date_modified'	=> '0000-00-00',
		'modifiedbypk'	=> 0,
		'terminal'	=> '',
		'arrival_time' => '0000-00-00',
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('schedule_model', '' ,true);

        return $CI->schedule_model;
	}

	// --------------------------------------------------------------------
	
	public function getData()
	{		
		$data = parent::getData(); 
		$data['about'] 	= parent::getData();

		return $data;		
	}

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}
}