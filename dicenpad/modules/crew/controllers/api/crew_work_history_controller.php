<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_work_history_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('work_history_model', 'model');
        $this->load->library('crew');
        $this->load->library('crew/work_history');
    }

    function crew_work_historys_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_work_historys' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('crew' . serialize($this->_args), $response);
        }
        $this->response($response);
    }
    /**
    * Get crew's work.
    * 
    */
    function crew_work_history_get()
    {
        $offset = null;
        $limit = 10;
        $sort = 'embarked';
        $order = 'desc';
        if ($this->get('limit') != '') {
            $limit  = $this->get('limit');            
            
            if ($this->get('offset') != '') {
                $offset = $this->get('offset');
            }
        }        

        $crew = new Crew();
        $crew->load($this->get('id'));
        
        $this->response($this->model->get_by_crew($crew->getData(), $limit, $offset));
    }
}