<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Candidate_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('sched/candidate_model', 'model');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function candidates_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('candidates' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('candidate_h' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    
}