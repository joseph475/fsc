<?php

/**
 * This class represents a user description.
 */
class Bank_statement extends Base
{
	protected $_data = array(
		'id'	   			=> 0,
		'crew_id'  			=> 0,
		//'vessel_id'			=> 0,
		'type' 				=> '',
		'amount'			=> 0,
		'remarks'   		=> '',
		'paid'				=> 0,
		'prefix'			=> '',
		'date_issued'		=> '0000-00-00',
		'date_created'		=> '0000-00-00',
		'createdbypk'		=> 0,
		'date_modified'		=> '0000-00-00',
		'modifiedbypk'		=> 0 
		);

	protected $_validators = array(
        'crew_id' => array('Zend_Validate_NotEmpty'),
        'amount' => array('Zend_Validate_Float'),
        'amount' => array('Zend_Validate_NotEmpty'),
        'date_issued' => array('Zend_Validate_NotEmpty')
        );

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('bank_statement_model');
        return $ci->bank_statement_model;
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