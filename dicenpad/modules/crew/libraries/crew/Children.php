<?php

/**
 * This class represents a user description.
 */
class Children extends Base
{
	protected $_data = array(
		'id'	   			=> null,
		'crew_id'  			=> null,
		'child_name' 		=> '',
		'child_birthdate'	=> '',
		'child_address'   	=> '',
		'relationship'		=> '',
		'child_gender'		=> '',
		'child_email'		=> '',
		'child_telephone'	=> ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('children_model');
        return $ci->children_model;
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