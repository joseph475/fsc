<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Send_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('send_model', 'model');
        $this->load->library('send');
    }

    /**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function sends_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('send' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }      

            $response['l'] = $this->db->last_query();           
        }

        $this->response($response);
    }

    /**
    * Delete a record.
    * 
    */
    function send_delete()
    {   
        // Get send to determine if user is allowed to delete.
        $send = new send($this->get('id'));
        if (!$send->hasData()) {
            // Throw a 404 if this send does not exist.
            $this->response(FALSE);
        } else {
            if ($send->delete()) {                
                $this->response(TRUE);
            } else {
                $this->response(array($send->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function send_post()
    {        
        $send = new send();

        $send->date_created    = date('Y-m-d H:i:s');
        $send->createdbypk     = $this->get_user()->user_id;
        $send->date_modified   = date('Y-m-d H:i:s');
        $send->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_send_save($send, 'post'));
    } 

    /**
     * Updates an send entry.
     * 
     * @return xml
     */
    function send_put()
    {        
        $send = new send($this->put('id'));

        $send->date_modified   = date('Y-m-d H:i:s');
        $send->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_update_save($send, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _send_save($send, $mode)
    {
        $delete_file = false;
        $response = array('status' => 'failed', 'message' => '');


        $this->load->library('crew');
        $crew = new Crew($this->{$mode}('crew_id'));

        $send->vessel_id     = $this->{$mode}('vessel_id');
        $send->crew_id       = $this->{$mode}('crew_id');
        $send->position_id   = $crew->position_id;
        $send->remarks       = $this->{$mode}('remarks');
        $send->document      = $this->{$mode}('document');
        $send->awb_no        = $this->{$mode}('awb_no');
        $send->send_by       = $this->{$mode}('send_by');
        $send->sent_thru     = $this->{$mode}('sent_thru');
        $send->date_sent     = ($this->{$mode}('date_sent'))? date('Y-m-d', strtotime($this->{$mode}('date_sent'))) : '';
         
        $id = $send->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;           
        } else {
            $response['message'] = $send->get_validation_errors();
        }

        return $response;
    }

        private function _update_save($send, $mode)
    {
        $delete_file = false;
        $response = array('status' => 'failed', 'message' => '');


        $this->load->library('crew');
        $crew = new Crew($this->{$mode}('crew_id'));

        $send->crew_id       = $this->{$mode}('crew_id');
        $send->position_id   = $crew->position_id;
        $send->remarks       = $this->{$mode}('remarks');
        $send->document      = $this->{$mode}('document');
        $send->awb_no        = $this->{$mode}('awb_no');
        $send->send_by       = $this->{$mode}('send_by');
        $send->sent_thru     = $this->{$mode}('sent_thru');
        $send->date_sent     = ($this->{$mode}('date_sent'))? date('Y-m-d', strtotime($this->{$mode}('date_sent'))) : '';
         
        $id = $send->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;           
        } else {
            $response['message'] = $send->get_validation_errors();
        }

        return $response;
    }
}