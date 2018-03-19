<?php

/**
 * This class represents a private nessage.
 */
class Message extends Base
{	
	protected $_validators = array(
                'user_id' => array('Zend_Validate_NotEmpty'),
                'message' => array('Zend_Validate_NotEmpty'),
                'recipient_id' => array('Zend_Validate_NotEmpty'),
                'user_id' => array('Zend_Validate_GreaterThan' => array ('min' => 0)),
                'recipient_id' => array('Zend_Validate_GreaterThan' => array ('min' => 0))
        );

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('message_model', '' ,true);
        
        return $CI->message_model;
	}
}