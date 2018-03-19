<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class crew_checklist_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('crew_checklist_model', 'model');
        $this->load->model('crew_endorse_checklist_model', 'model2');
        $this->load->library('crew_checklist');
    }

    /**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function checklist_crews_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('checklist_crew' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('checklist_crew' . serialize($this->_args), $response);
        }

        $this->response($response);
    }

    /**
     * Returns a single Crew.
     * 
     * @return xml
     */
    function checklist_crew_get()
    {
        $load = 'crew_id';
        $id   = $this->get('id');
        
        $cache = Cache::get_instance();
        $crew = $cache::get('checklist_crew' . $id);

        if (!$crew) {            
            $crew = new Crew_checklist($id);   
            $crew->load($id, $load);  
            $cache::save('checklist_crew' . $crew->crew_id, $crew, 1800);
        }
        
        $response = $crew->getData();   
        $this->response($response);
    }    

    function checklist_endorse_crews_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('checklist_endorse_crews' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model2->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model2->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
        }

        $this->response($response);
    }
}