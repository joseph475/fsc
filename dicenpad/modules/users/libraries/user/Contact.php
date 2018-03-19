<?php

/**
 * This class represents a user contact.
 */
class Contact extends Base
{
	protected $_validators = array(
        'contact' => array('Zend_Validate_NotEmpty'),
        'contact_type' => array('Zend_Validate_NotEmpty'),
        'user_id' => array('Zend_Validate_NotEmpty')
        );

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('contact_model');
        return $ci->contact_model;
	}
}