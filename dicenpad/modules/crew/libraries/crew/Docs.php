<?php

/**
 * This class represents a user description.
 */
class Docs extends Base
{
	protected $_data = array(
		'id'	   		=> 0,
		'crew_id'  		=> 0,
		'docs_id' 		=> 0,
		'flag_id' 		=> 0,
		'position_id'	=> 0,
		'docs_nos'   	=> 0,
		'date_iss'		=> '',
		'date_expr'		=> '',
		'date_issued'   => '',
		'date_expired'  => '',
		'uploading_modified'   => '',
		'encoding_modified'  => '',
		'remarks'		=> '',
		'endorsement'	=> '',
		'capacity'		=> '',
		'hasflag'		=> '',
		'published'		=> 1,
		'sort_order'	=> '',
		'file_docs'		=> ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('docs_model');
        return $ci->docs_model;
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