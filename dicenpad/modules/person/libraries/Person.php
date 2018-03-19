<?php

/**
 * This class represents a Person.
 */
class Person extends Base
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('person_model', '' ,true);
        
        return $CI->person_model;
	}
}