<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search_vessel_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('search_vessel_model', 'model');
        $this->load->model('drop_crewlist_model', 'model2');
    }

    /**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function search_vessel_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('search_vessel' . serialize($this->_args));

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

    /**
     * Returns a single Crew.
     * 
     * @return xml
     */
    function crewsss_get()
    {
        $load = 'crew_id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');     
        } elseif ($this->get('hash') != '') {
            $id   = $this->get('hash');
            $load = 'hash';
        } elseif ($this->get('fullname') != '') {
            $id   = $this->get('fullname');
            $load = 'fullname';
        } 
        
        $cache = Cache::get_instance();
        $crew = $cache::get('crew' . $id);

        if (!$crew) {            
            $crew = new Crew($id);   
            $crew->load($id, $load);  
            $cache::save('crew' . $crew->crew_id, $crew, 1800);
        }
        
        $response = $crew->getData();   
                
        $this->response($response);
    }

    function drop_crewlists_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('drop_crewlists' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model2->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model2->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('crew' . serialize($this->_args), $response);
        }
        $this->response($response);
    }

}