<?php

/**
 * This class represents a user description.
 */
class Comment extends Base
{
	protected $_data = array(
		'id'	   			=> 0,
		'crew_id'  			=> 0,
		'title' 			=> '',
		'description'		=> ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('comment_model');
        return $ci->comment_model;
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