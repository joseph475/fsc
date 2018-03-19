<?php
/**
 * This class represents an employee (single employee).
 */
class Memo_user extends Base
{
	// Default values
	protected $_data = array(
		'link_id' 		=> 0,
        'memo_id' 		=> 0,
        'user_id' 		=> 0
		);

	// public function load($key)
	// {
	// 	$data = $this->getModel()->get($key, $field);

	// 	$this->loadArray($data);

	// 	return $this;
	// }
	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('memo_user_model', '' ,true);

        return $CI->memo_user_model;
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

	public function delete_id($id)
	{
		return $this->getModel()->delete_mid($id);
		
	}
}