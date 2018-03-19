<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bank_statement_detail_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('bank_statement_detail_model', 'model');
        $this->load->library('bank_statement');
        $this->load->library('bank_statement_detail');
    }

    function bank_statement_details_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('bank_statement_details' . serialize($this->_args));

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
    * Get crew's bsd.
    * 
    */

    function bank_statement_detail_get()
    {
        $id = $this->get('id');   

        $response = $this->model->get_by_bs($id);

        $cache = Cache::get_instance();
        $bank_statement = $cache::get('bank_statement' . $id);

        if (!$response) {            
            $bank_statement = new Bank_statement($id);   
            $bank_statement->load($id, 'id');  
            $cache::save('bank_statement' . $bank_statement->id, $bank_statement, 1800);

            $response = $bank_statement->getData(); 
        }
        //$response['l'] = $this->db->last_query();      
        $this->response($response);
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function bank_statement_detail_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $bsd = new Bank_statement_detail($this->get('id'));

        if (!$bsd->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($bsd->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($bsd->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Create a record.
    * 
    */

    function bank_statement_detail_post()
    {
        $bsd = new Bank_statement_detail();

        $bsd->date_created    = date('Y-m-d H:i:s');
        $bsd->createdbypk     = $this->get_user()->user_id;
        $bsd->date_modified   = date('Y-m-d H:i:s');
        $bsd->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_bsd_save($bsd, 'post'));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function bank_statement_detail_put()
    {   
        $bsd = new Bank_statement_detail($this->put('id'));

        $bsd->date_modified   = date('Y-m-d H:i:s');
        $bsd->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_bsd_save($bsd, 'put'));
    }

    private function _bsd_save($bsd, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $bsd->bs_id             = $this->{$mode}('bs_id');
        $bsd->payment           = $this->{$mode}('payment');
        $bsd->ispaid            = $this->{$mode}('ispaid');
        $bsd->date_terms        = date('Y-m-d', strtotime($this->{$mode}('date_terms'))); 
        $bsd->status           = $this->{$mode}('status');

        $id = $bsd->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;
        }else {
            $response['message'] = $bsd->get_validation_errors();
        }

        return $response;
    }

}