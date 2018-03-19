<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_bank_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('bank_model', 'model');
        $this->load->library('crew');
        $this->load->library('crew/bank');
    }

    function crew_banks_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_banks' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            }                 
        }

        $this->response($response);
    }

	/**
    * Get crew's education.
    * 
    */
    function crew_bank_get()
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
    function crew_bank_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $bank = new bank($this->get('id'));

        if (!$bank->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($bank->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($bank->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Create a record.
    * 
    */

    function crew_bank_post()
    {
        $bank = new Bank();
        
        $this->response($this->_bank_save($bank, 'post'));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function crew_bank_put()
    {   
        $bank = new Bank($this->put('id'));
        
        $this->response($this->_bank_save($bank, 'put'));
    }

    private function _bank_save($bank, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $bank->crew_id              = $this->{$mode}('crew_id');
        $bank->amount               = $this->{$mode}('amount');
        $bank->date_issued          = date('Y-m-d', strtotime($this->{$mode}('date_issued'))); 
        $bank->prefix               = $this->{$mode}('prefix');
        $bank->type                 = $this->{$mode}('type');
        $bank->type_nos             = $this->{$mode}('type_nos');
        $bank->remarks              = $this->{$mode}('remarks');

        $id = $bank->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;
        }else {
            $response['message'] = $bank->get_validation_errors();
        }

        return $response;
    }

}