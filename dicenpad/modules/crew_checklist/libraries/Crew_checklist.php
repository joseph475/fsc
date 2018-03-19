<?php
/**
 * This class represents an crew (single crew).
 */
class Crew_checklist extends Base
{
	// Default values
	protected $_data = array(
		'crew_id' 		=> 0,
		'fullname'		=> ''
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('crew_checklist_model', '' ,true);

        return $CI->crew_checklist_model;
	}
	// --------------------------------------------------------------------
	
	public function getData()
	{		
		$data = parent::getData(); 		

		return $data;		
	}
}