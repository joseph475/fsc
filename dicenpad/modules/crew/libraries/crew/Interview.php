<?php

/**
 * This class represents a user description.
 */
class Interview extends Base
{
	protected $_data = array(
		'id'	   			=> null,
		'crew_id'  			=> 0,
		'position_id' 		=> 0,
		'vessel_id'			=> 0,
		'tentative_sched'   => '',
		'age'				=> '',
		'vesseltype'		=> '',
		'prevkindvessel'	=> '',
		'prevkindengine'	=> '',
		'prevkindcargo'		=> '',
		'prevtraderoute'	=> '',
		'prevsalary'		=> '',
		'prevforeignexp'	=> '',
		'evalgrade1'		=> '',
		'evalremark1'		=> '',
		'evalgrade2'		=> '',
		'evalremark2'		=> '',
		'evalgrade3'		=> '',
		'evalremark3'		=> '',
		'evalgrade4'		=> '',
		'evalremark4'		=> '',
		'evalgrade5'		=> '',
		'evalremark5'		=> '',
		'evalremark6'		=> '',
		'evalgrade6a'		=> '',
		'evalgrade6b'		=> '',
		'evalgrade6c'		=> '',
		'evalgrade6d'		=> '',
		'evalgrade6e'		=> '',
		'evalgrade7a'		=> '',
		'evalgrade7b'		=> '',
		'recommendation'	=> '',
		'goodforvessel'		=> '',
		'interviewby'		=> '',
		'checkedby'			=> '',
		'approvedby'		=> '',
		'datecreated'		=> ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('interview_model');
        return $ci->interview_model;
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