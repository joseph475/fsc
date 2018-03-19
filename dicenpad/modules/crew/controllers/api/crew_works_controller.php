<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_works_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('works_model', 'model');
        $this->load->library('crew');
        $this->load->library('crew/works');
    }

    function crew_works_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_works' . serialize($this->_args));

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
    function crew_work_get()
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

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function crew_work_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $work = new Works($this->get('id'));

        if (!$work->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($work->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($work->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Create a record.
    * 
    */

    function crew_work_post()
    {
        $work = new Works();
        
        $this->response($this->_work_save($work, 'post'));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function crew_work_put()
    {   
        $work = new Works($this->put('id'));
        
        $this->response($this->_work_save($work, 'put'));
    }

    private function _work_save($work, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $work->crew_id      = $this->{$mode}('crew_id');
        $work->company      = $this->{$mode}('company');
        $work->vessel       = $this->{$mode}('vessel');
        $work->rank         = $this->{$mode}('rank');
        $work->grt          = $this->{$mode}('grt');
        $work->type         = $this->{$mode}('type');
        $work->engine       = $this->{$mode}('engine');
        $work->trade        = $this->{$mode}('trade');
        $work->embarked     = date('Y-m-d', strtotime($this->{$mode}('embarked')));
        $work->disembarked  = date('Y-m-d', strtotime($this->{$mode}('disembarked')));
        $work->remarks      = $this->{$mode}('remarks');

        if($mode == 'POST'){
            $check = $this->model->check_works(array('crew_id' => $work->crew_id, 'entry' => $work->embarked));
            dbug($check);
            if($check) {
                $response['status']  = 'invalid'; 
                return $response;  
            }

            $check = $this->model->check_works(array('crew_id' => $work->crew_id, 'entry' => $work->disembarked));
            if($check) {
                $response['status']  = 'invalid'; 
                return $response;  
            }
        }

        $id = $work->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;
        }else {
            $response['message'] = $work->get_validation_errors();
        }

        return $response;
    }

}