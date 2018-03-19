<?php

/**
 * This class represents a work description.
 */
class Work_history extends Base
{
	protected $_data = array(
		//'id'	   		=> null,
		'crew_id'  		=> null,
		'company'		=> '',
		'flag'			=> '',
		'vessel'   		=> '',
		'rank'   		=> '',
		'grt'			=> '',
		'type'			=> '',
		'engine'		=> '',
		'trade'			=> '',
		'embarked'		=> '0000-00-00',
		'disembarked'	=> '0000-00-00',
		'remarks'		=> '',
		'last_evalutation' => '0000-00-00'
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('work_history_model');
        return $ci->work_history_model;
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