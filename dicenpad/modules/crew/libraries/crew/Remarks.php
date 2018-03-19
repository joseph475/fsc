<?php

/**
 * This class represents a user description.
 */
class Remarks extends Base
{
	protected $_data = array(
		'id'	   			=> null,
		'crew_id'  			=> null,
		'remarks' 			=> '',
		'remarks_by'		=> '',
		'remarks_date'   	=> '0000-00-00',
		'published'			=> ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('remarks_model');
        return $ci->remarks_model;
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