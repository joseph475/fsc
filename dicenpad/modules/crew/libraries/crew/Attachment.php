<?php

/**
 * This class represents a user description.
 */
class Attachment extends Base
{
	protected $_data = array(
		'id'	   			=> null,
		'crew_id'  			=> null,
		'file_title' 		=> '',
		'file_desc'			=> '',
		'file_docs'   		=> ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('attachment_model', '' ,true);
        return $ci->attachment_model;
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