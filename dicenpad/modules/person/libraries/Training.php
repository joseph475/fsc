<?php

/**
 * This class represents a Person's work experience.
 */
class Training extends Base
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('training_model', '' ,true);
        
        return $CI->training_model;
	}
}