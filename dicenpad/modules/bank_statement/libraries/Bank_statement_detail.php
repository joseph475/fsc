<?php

/**
 * This class represents a user description.
 */
class Bank_statement_detail extends Base
{
	protected $_data = array(
		'id'	   			=> 0,
		'bs_id'  			=> 0,
		'payment'			=> 0,
		'status'   			=> '',
		'ispaid'			=> 0,
		'date_terms'		=> '0000-00-00',
		'date_created'		=> '0000-00-00',
		'createdbypk'		=> 0,
		'date_modified'		=> '0000-00-00',
		'modifiedbypk'		=> 0 
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('bank_statement_detail_model');
        return $ci->bank_statement_detail_model;
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