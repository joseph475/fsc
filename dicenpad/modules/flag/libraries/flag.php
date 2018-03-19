<?php
/**
 * This class represents an employee (single employee).
 */
class Flag extends Base
{
	// Default values
	protected $_data = array(
		'id' 			=> 0,
        'flag' 			=> '',
        'code' 			=> '',
        'published'		=> '',
        'date_created'	=> '0000-00-00',
		'createdbypk'	=> '',
		'date_modified'	=> '0000-00-00',
		'modifiedbypk'	=> ''
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('flag_model', '' ,true);

        return $CI->flag_model;
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