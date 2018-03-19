<?php
/**
 * This class represents an employee (single employee).
 */
class Admin_label extends Base
{
	// Default values
	protected $_data = array(
		'label_id' 		=> 0,
        'label_code' 	=> '',
        'label' 		=> '',
        'published' 	=> 0,
        'deleted' 		=> 0,
        'sort_order'	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('admin_label_model', '' ,true);

        return $CI->admin_label_model;
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