<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Various_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

        $this->load->model('various_model', 'model');
        $this->load->model('draft_various_model', 'dmodel');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function variouss_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('variouss' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('onboard' . serialize($this->_args), $response);
        }

        $this->response($response);
    }    

    function draftvariouss_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('draftvariouss' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->dmodel->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->dmodel->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('onboard' . serialize($this->_args), $response);
        }

        $this->response($response);
    }    
}