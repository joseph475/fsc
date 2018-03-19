<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Send_received_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('send_received_model', 'model');
        $this->load->library('send_received');
    }

    /**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function send_receiveds_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('send_received' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('options' . serialize($this->_args), $response);
        }

        $this->response($response);
    }

    /**
    * Delete a record.
    * 
    */
    function send_received_delete()
    {   
        // Get send_received to determine if user is allowed to delete.
        $send_received = new send_received($this->get('id'));
        if (!$send_received->hasData()) {
            // Throw a 404 if this send_received does not exist.
            $this->response(FALSE);
        } else {
            if ($send_received->delete()) {                
                $this->response(TRUE);
            } else {
                $this->response(array($send_received->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function send_received_post()
    {        
        $send_received = new send_received();

        $send_received->date_created    = date('Y-m-d H:i:s');
        $send_received->createdbypk     = $this->get_user()->user_id;
        $send_received->date_modified   = date('Y-m-d H:i:s');
        $send_received->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_send_received_save($send_received, 'post'));
    } 

    /**
     * Updates an send_received entry.
     * 
     * @return xml
     */
    function send_received_put()
    {        
        $send_received = new send_received($this->put('id'));

        $send_received->date_modified   = date('Y-m-d H:i:s');
        $send_received->modifiedbypk    = $this->get_user()->user_id;
        $send_received->date_received   = date('Y-m-d', strtotime($this->put('date_received')));
        $send_received->date_check      = date('Y-m-d', strtotime($this->put('date_check')));

        $this->response($this->_send_received_save($send_received, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _send_received_save($send_received, $mode)
    {
        $delete_file = false;
        $response = array('status' => 'failed', 'message' => '');

        $send_received->vessel_id     = $this->{$mode}('vessel_id');
        $send_received->crew_id       = $this->{$mode}('crew_id');
        $send_received->remarks       = $this->{$mode}('remarks');
        $send_received->document      = $this->{$mode}('document');
        $send_received->sent_thru     = $this->{$mode}('sent_thru');
        $send_received->awb_no        = $this->{$mode}('awb_no');
        $send_received->send_by_others= $this->{$mode}('send_by_others');
        $send_received->date_sent     = date('Y-m-d', strtotime($this->{$mode}('date_sent')));
        
        $id = $send_received->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;           
        } else {
            $response['message'] = $send_received->get_validation_errors();
        }

        return $response;
    }
}