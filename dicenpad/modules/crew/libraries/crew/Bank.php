<?php

/**
 * This class represents a user description.
 */
class Bank extends Base
{
	protected $_data = array(
		'id'	   			=> 0,
		'crew_id'  			=> 0,
		'amount' 			=> '',
		'date_issued'		=> '0000-00-00',
		'remarks'   		=> '',
		'type'				=> '',
		'type_nos'			=> ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('bank_model');
        return $ci->bank_model;
	}

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}

	public function getData()
	{		
		$data = parent::getData(); 	
		return $data;		
	}
}