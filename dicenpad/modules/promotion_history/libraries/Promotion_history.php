<?php
/**
 * This class represents an employee (single employee).
 */
class Promotion_history extends Base
{
	// Default values
	protected $_data = array(
		'id' 				=> 0,
		'crew_id'			=> 0,
		'vessel_id'			=> 0,
		'prev_pos_id'		=> 0,
		'new_pos_id'		=> 0,
        'onboard_date' 		=> '0000-00-00',
        'isfrom_plan' 		=> '0',
        'promotion_date'	=> '0000-00-00',
        'remarks'			=> '',
        'date_created'		=> '0000-00-00',
		'createdbypk'		=> 0,
		'date_modified'		=> '0000-00-00',
		'modifiedbypk'		=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('promotion_history_model', '' ,true);

        return $CI->promotion_history_model;
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