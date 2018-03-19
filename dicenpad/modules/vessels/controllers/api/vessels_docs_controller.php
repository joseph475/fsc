<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vessels_docs_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('vessels_docs_model', 'model');
        $this->load->library('vessels');
        $this->load->library('vessels/vessels_docs');
    }

    function vessels_docs_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_vessels_docss' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('vessels' . serialize($this->_args), $response);
        }

        $this->response($response);
    }

	/**
    * Get vessel's education.
    * 
    */
    function vessels_doc_get()
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

        $vessels = new Vessels();
        $vessels->load($this->get('id'));

        $this->response($this->model->get_by_vessel($vessels->getData(), $limit, $offset, $sort, $order));
        

    }

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function vessels_doc_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $vessels_docs = new Vessels_docs($this->get('id'));

        if (!$vessels_docs->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($vessels_docs->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($vessels_docs->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Create a record.
    * 
    */

    function vessels_doc_post()
    {
        $vessels_docs = new Vessels_docs();
        
        $vessels_docs->date_created    = date('Y-m-d H:i:s');
        $vessels_docs->createdbypk     = $this->get_user()->user_id;
        $vessels_docs->date_modified   = date('Y-m-d H:i:s');
        $vessels_docs->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_vessels_docs_save($vessels_docs, 'post'));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function vessels_doc_put()
    {   
        $vessels_docs = new Vessels_docs($this->put('id'));

        $vessels_docs->date_modified   = date('Y-m-d H:i:s');
        $vessels_docs->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_vessels_docs_save($vessels_docs, 'put'));
    }

    private function _vessels_docs_save($vessels_docs, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $vessels_docs->vessel_id        = $this->{$mode}('vessel_id');
        $vessels_docs->documents        = $this->{$mode}('documents');
        $vessels_docs->remarks          = $this->{$mode}('remarks');
        $vessels_docs->published        = $this->{$mode}('published');

        $id = $vessels_docs->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;
        }else {
            $response['message'] = $vessels_docs->get_validation_errors();
        }

        return $response;
    }

}