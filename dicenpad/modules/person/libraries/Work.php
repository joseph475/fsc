<?php

/**
 * This class represents a Person's work experience.
 */
class Work extends Base
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('work_model', '' ,true);
        
        return $CI->work_model;
	}
}