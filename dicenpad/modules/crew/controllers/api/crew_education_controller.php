<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_education_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('education_model', 'model');
        $this->load->library('crew');
        $this->load->library('crew/education');
    }

    function crew_educations_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_educations' . serialize($this->_args));

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
    function crew_education_get()
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
    function crew_education_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $educs = new Education($this->get('id'));

        if (!$educs->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($educs->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($educs->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Create a record.
    * 
    */

    function crew_education_post()
    {
        $educs = new Education();
        
        $this->response($this->_education_save($educs, 'post'));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function crew_education_put()
    {   
        $educs = new Education($this->put('id'));
        
        $this->response($this->_education_save($educs, 'put'));
    }

    private function _education_save($educs, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $educs->crew_id         = $this->{$mode}('crew_id');
        $educs->year            = $this->{$mode}('year');
        $educs->school          = $this->{$mode}('school');
        $educs->course          = $this->{$mode}('course');
        $educs->vocational      = $this->{$mode}('vocational');
        $educs->highest         = $this->{$mode}('highest');
        $educs->qualification         = $this->{$mode}('qualification');

        $id = $educs->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;
        }else {
            $response['message'] = $educs->get_validation_errors();
        }

        return $response;
    }

}