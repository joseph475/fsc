<?php
/**
 * This class represents an employee (single employee).
 */
class Memo extends Base
{
	// Default values
	protected $_data = array(
		'id' 			=> 0,
        'filename' 		=> 0,
        'type'			=> '',
        'title' 		=> 1,
        'alias' 		=> 0,
        'description' 	=> 0,
        'date_created'	=> '0000-00-00',
        'createdbypk'	=> 0,
        'date_modified'	=> '0000-00-00',
        'modifiedbypk'	=> 0
		);

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('memo_model', '' ,true);

        return $CI->memo_model;
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