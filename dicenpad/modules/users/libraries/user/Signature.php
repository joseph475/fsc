<?php

/**
 * This class represents a user description.
 */
class Signature extends Base
{
	protected $_data = array(
		'id'	   	=> null,
		'user_id'  	=> null,
		'poea1' 	=> '',
		'poea2'   	=> '',
		'expire_doc'=> '',
		'check1'    => '',
		'check2'  	=> ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('signature_model');
        return $ci->signature_model;
	}

	public function load($key, $field = 'user_id')
	{
		return parent::load($key, 'user_id');
	}
}