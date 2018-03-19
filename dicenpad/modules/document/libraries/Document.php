<?php
/**
 * This class represents an employee (single employee).
 */
class Document extends Base
{
	// Default values
	protected $_data = array(
		'id'  			=> 0,
		'classify_id'	=> 0,
		'division_id'	=> 0,
		'flag_id'		=> 0,
		'document'   	=> NULL,
		'code'    		=> NULL,
		'published'   	=> 0,
		'inresume'		=> 0,
		'deleted'		=> 0,
		'sort_order'	=> 0,
		'hasflag'		=> 0,
		'isdeck_off'	=> 0,
		'isdeck_rat'	=> 0,
		'isengine_off'	=> 0,
		'isengine_rat'	=> 0,
		'iscatering'	=> 0,
		'defaults'		=> 0,
		'sub_order'		=> ''
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('document_model', '' ,true);

        return $CI->document_model;
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