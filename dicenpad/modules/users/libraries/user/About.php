<?php

/**
 * This class represents a user description.
 */
class About extends Base
{
	protected $_data = array(
		'id'	   => null,
		'user_id'  => null,
		'about_me' => '',
		'talent'   => '',
		'movies'   => '',
		'music'    => '',
		'dreams'   => '',
		'website'  => '',
		'photo'    => ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('about_model');
        return $ci->about_model;
	}
}