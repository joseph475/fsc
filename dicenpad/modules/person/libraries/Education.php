<?php

/**
 * This class represents a Person's education.
 */
class Education extends Base
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('education_model', '' ,true);
        
        return $CI->education_model;
	}
}