<?php
/**
 * This class represents an employee (single employee).
 */
class Checklist extends Base
{
	// Default values
	protected $_data = array(
		'id'  			=> 0,
		'type_id'		=> 0,
		'docs_id'		=> 0,
		'position_id'	=> 0,
		'sort_order'   	=> 0,
		'sub_order'     => '',
		'published'		=> 1,
		'officer_deck'	=> '',
		'officer_engr'	=> '',
		'officer_stwd'	=> '',
		'rating_deck'	=> '',
		'rating_engr'	=> '',
		'rating_stwd'	=> '',
		'date_created'	=> '0000-00-00',
		'createdbypk'	=> 0,
		'date_modified'	=> '0000-00-00',
		'modifiedbypk'	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('checklist_model', '' ,true);

        return $CI->checklist_model;
	}

	// --------------------------------------------------------------------
	
	public function getData()
	{		
		$data = parent::getData(); 

		return $data;		
	}

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}
}