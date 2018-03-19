<?php
/**
 * This class represents an employee (single employee).
 */
class Conduct extends Base
{
	// Default values
	protected $_data = array(
			'id'  			=> 0,
			'crew_id' 		=> 0,
			'vessel_id'		=> 0,
			'date_receive'	=> '0000-00-00',
			'date_year'		=> '0000',
			'remarks'  		=> '',
			'published'		=> 0,
			'file_docs'    	=> '',
			'start_date'	=> '0000-00-00',
			'end_date'		=> '0000-00-00',
			'date_created'	=> '0000-00-00',
			'createdbypk'	=> 0,
			'date_modified'	=> '0000-00-00',
			'modifiedbypk'	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('conduct_model', '' ,true);

        return $CI->conduct_model;
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