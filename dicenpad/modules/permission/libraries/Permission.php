<?php
/**
 * This class represents an employee (single employee).
 */
class Permission extends Base
{
	// Default values
	protected $_data = array(
		'id'  			=> 0,
		'type'			=> 'role',
		'type_id'   	=> 0,
		'resource_id'   => 0,
		'i_read'   		=> 'allow',
		'i_insert'   	=> 'allow',
		'i_delete'   	=> 'allow',
		'i_update'   	=> 'allow',
		'i_print'   	=> 'allow',
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('permission_model', '' ,true);

        return $CI->permission_model;
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