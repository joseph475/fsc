<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Conduct_rep1_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('conduct_rep1_model', 'model');
    }

    /**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function conduct_rep1s_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('conduct' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('options' . serialize($this->_args), $response);
        }

        $this->response($response);
    }

    function conduct_rep2s_get()
    {
        $this->load->model('conduct_rep2_model', 'model2');

        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('conduct' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model2->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model2->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('options' . serialize($this->_args), $response);
        }

        $this->response($response);
    }
}