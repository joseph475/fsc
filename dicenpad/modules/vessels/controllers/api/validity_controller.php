<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Validity_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('validity_model', 'model');
        $this->load->library('vessels');
        $this->load->library('vessels/validity');
    }

    function validitys_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_validitys' . serialize($this->_args));

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
    function validity_get()
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
    function validity_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $validity = new validity($this->get('id'));

        if (!$validity->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($validity->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($validity->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Create a record.
    * 
    */

    function validity_post()
    {
        $validity = new validity();
        
        $validity->date_created    = date('Y-m-d H:i:s');
        $validity->createdbypk     = $this->get_user()->user_id;
        $validity->date_modified   = date('Y-m-d H:i:s');
        $validity->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_validity_save($validity, 'post'));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function validity_put()
    {   
        $validity = new validity($this->put('id'));

        $validity->date_modified   = date('Y-m-d H:i:s');
        $validity->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_validity_save($validity, 'put'));
    }

    private function _validity_save($validity, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $validity->vessel_id        = $this->{$mode}('vessel_id');
        $validity->validity_year    = $this->{$mode}('validity_year');
        $validity->validity_from    = $this->{$mode}('validity_from');
        $validity->validity_to      = $this->{$mode}('validity_to');
        $validity->cba              = $this->{$mode}('cba');

        $id = $validity->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;
        }else {
            $response['message'] = $validity->get_validation_errors();
        }

        return $response;
    }

}