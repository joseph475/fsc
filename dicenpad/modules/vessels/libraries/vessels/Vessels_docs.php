<?php

/**
 * This class represents a user description.
 */
class Vessels_docs extends Base
{
	protected $_data = array(
		'id'	   			=> 0,
		'vessel_id'  		=> 0,
		'remarks' 			=> '',
		'published'			=> '',
		'documents'			=> '',
		'date_created'		=> '0000-00-00',
		'createdbypk'		=> 0,
		'date_modified'		=> '0000-00-00',
		'modifiedbypk'		=> 0

		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('vessels_docs_model');
        return $ci->vessels_docs_model;
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