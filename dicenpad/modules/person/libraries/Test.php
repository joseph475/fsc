<?php

/**
 * This class represents a Person's work experience.
 */
class Test extends Base
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('test_model', '' ,true);
        
        return $CI->test_model;
	}
}