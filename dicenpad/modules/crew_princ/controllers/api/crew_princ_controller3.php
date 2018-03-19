<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_princ_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

        $this->load->model('crew_princ_model', 'model');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function crew_princs_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_princs' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query(); 
        }

        $this->response($response);
    }       
}