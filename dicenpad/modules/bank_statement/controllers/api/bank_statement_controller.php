<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bank_statement_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('bank_statement_model', 'model');
        $this->load->library('Bank_statement');
        $this->load->library('Crew');
    }

    function bank_statements_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('bank_statements' . serialize($this->_args));

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

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function bank_statement_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $bank_statement = New Bank_statement($this->get('id'));

        if (!$bank_statement->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($bank_statement->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($bank_statement->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Create a record.
    * 
    */

    function bank_statement_post()
    {
        $bank_statement = new Bank_statement();

        $bank_statement->date_created    = date('Y-m-d H:i:s');
        $bank_statement->createdbypk     = $this->get_user()->user_id;
        $bank_statement->date_modified   = date('Y-m-d H:i:s');
        $bank_statement->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_bank_statement_save($bank_statement, 'post'));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function bank_statement_put()
    {   
        $bank_statement = new Bank_statement($this->put('id'));

        $bank_statement->date_modified   = date('Y-m-d H:i:s');
        $bank_statement->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_bank_statement_save($bank_statement, 'put'));
    }

    private function _bank_statement_save($bank_statement, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $crew = new Crew($this->{$mode}('crew_id'));
        if($crew->crew_id){

            $bank_statement->crew_id           = $crew->crew_id;
            $bank_statement->amount            = $this->{$mode}('amount');
            $bank_statement->prefix            = $this->{$mode}('prefix');
            $bank_statement->type              = $this->{$mode}('type');
            $bank_statement->paid              = $this->{$mode}('paid');
            $bank_statement->date_issued       = date('Y-m-d', strtotime($this->{$mode}('date_issued'))); 
            $bank_statement->remarks           = $this->{$mode}('remarks');

            $id = $bank_statement->save();

            if ($id) {
                $response['id'] = $id;
                $response['status']  = 'success'; 
                $response['mode']  = $mode;
            }else {
                $response['status']  = 'error'; 
                $response['message'] = $bank_statement->get_validation_errors();
            }
        } else {
            $array = array('Crew ID '=> array('not found! Please check if this is exist.'));

            $response['status']  = 'error'; 
            $response['message'] = $array;
        }

        return $response;
    }

}