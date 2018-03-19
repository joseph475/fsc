<?php

/**
 * This class represents a user description.
 */
class Ref extends Base
{
	protected $_data = array(
		'id'	   		=> null,
		'user_id'  		=> 0,
		'role_id'  		=> 0,
		'company_id'   	=> 0,
		'division_id'  	=> 0,
		'department_id' => 0,
		'position_id'   => 0,
		'job_title_id'  => 0,
		'location_id'   => 0,
		'modified'		=> '0000-00-00'
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('ref_model');
        return $ci->ref_model;
	}
}