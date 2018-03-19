<?php
/**
 * This class represents an crew (single crew).
 */
class Document_various extends Base
{
	// Default values
	protected $_data = array(
		'id' 		=> 0,
		'docs_id' 	=> 0,
		'published'	=> 0,
		'user_id'	=> 0,
		'date_modified'	=> ''
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('document_various_model', '' ,true);

        return $CI->document_various_model;
	}

	// --------------------------------------------------------------------

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}
	
	// --------------------------------------------------------------------
	
	public function getData()
	{		
		$data 					= parent::getData(); 		

		return $data;		
	}
}