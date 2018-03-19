<?php

/**
 * This class represents a user description.
 */
class Education extends Base
{
	protected $_data = array(
		'id'	   		=> null,
		'crew_id'  		=> null,
		'year' 			=> '',
		'school'   		=> '',
		'course'   		=> '',
		'vocational'	=> '',
		'highest'		=> 0,
		'qualification'	=> ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('education_model');
        return $ci->education_model;
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