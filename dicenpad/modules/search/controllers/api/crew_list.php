<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_list_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('children_model', 'model');
        $this->load->library('crew');
        $this->load->library('crew/children');
    }

    function crew_lists_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_lists' . serialize($this->_args));

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
    * Get crew's education.
    * 
    */
    function crew_list_get()
    {
        $offset = null;
        $limit = 10;
        $sort = 'year';
        $order = 'desc';
        if ($this->get('limit') != '') {
            $limit  = $this->get('limit');            
            
            if ($this->get('offset') != '') {
                $offset = $this->get('offset');
            }
        }  

        $response['_count'] = $this->model->count_results($this->_args);

        $crew = new Crew();
        $crew->load($this->get('id'));

        $this->response($this->model->get_by_crew($crew->getData(), $limit, $offset, $sort, $order));
        

    }

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function crew_list_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $child = new Children($this->get('id'));

        if (!$child->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($child->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($child->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Create a record.
    * 
    */

    function crew_list_post()
    {
        $child = new Children();
        
        $this->response($this->_children_save($child, 'post'));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function crew_list_put()
    {   
        $child = new Children($this->put('id'));
        
        $this->response($this->_children_save($child, 'put'));
    }
}