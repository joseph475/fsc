<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_remarks_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('remarks_model', 'model');
        $this->load->library('crew');
        $this->load->library('crew/remarks');
    }

    function crew_remarkss_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_remarkss' . serialize($this->_args));

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
    function crew_remarks_get()
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
    function crew_remarks_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $remarks = new Remarks($this->get('id'));

        if (!$remarks->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($remarks->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($remarks->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Create a record.
    * 
    */

    function crew_remarks_post()
    {
        $remarks = new Remarks();
        
        $this->response($this->_remarks_save($remarks, 'post'));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function crew_remarks_put()
    {   
        $remarks = new Remarks($this->put('id'));
        
        $this->response($this->_remarks_save($remarks, 'put'));
    }

    private function _remarks_save($remarks, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $remarks->crew_id                 = $this->{$mode}('crew_id');
        $remarks->remarks                 = $this->{$mode}('remarks');
        $remarks->remarks_date            = date('Y-m-d H:i:s'); 
        $remarks->published               = $this->{$mode}('published');
        $remarks->remarks_by              = $this->{$mode}('remarks_by');

        $id = $remarks->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;
        }else {
            $response['message'] = $remarks->get_validation_errors();
        }

        return $response;
    }

}