<?php

/**
 * This class represents a work description.
 */
class Works extends Base
{
	protected $_data = array(
		'id'	   		=> null,
		'crew_id'  		=> null,
		'company'		=> '',
		'flag'			=> '',
		'vessel'   		=> '',
		'rank'   		=> '',
		'grt'			=> '',
		'type'			=> '',
		'engine'		=> '',
		'trade'			=> '',
		'embarked'		=> '',
		'disembarked'	=> '',
		'remarks'		=> '',
		'last_evalutation' => '0000-00-00'
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('works_model');
        return $ci->works_model;
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