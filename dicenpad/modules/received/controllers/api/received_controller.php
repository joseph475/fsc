<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Received_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('received_model', 'model');
        $this->load->library('received');
    }

    /**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function receiveds_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('received' . serialize($this->_args));

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
    function received_delete()
    {   
        // Get received to determine if user is allowed to delete.
        $received = new received($this->get('id'));
        if (!$received->hasData()) {
            // Throw a 404 if this received does not exist.
            $this->response(FALSE);
        } else {
            if ($received->delete()) {                
                $this->response(TRUE);
            } else {
                $this->response(array($received->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function received_post()
    {        
        $received = new received();

        $received->date_created    = date('Y-m-d H:i:s');
        $received->createdbypk     = $this->get_user()->user_id;
        $received->date_modified   = date('Y-m-d H:i:s');
        $received->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_received_save($received, 'post'));
    } 

    /**
     * Updates an received entry.
     * 
     * @return xml
     */
    function received_put()
    {        
        $received = new received($this->put('id'));

        $received->date_modified   = date('Y-m-d H:i:s');
        $received->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_received_save($received, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _received_save($received, $mode)
    {
        $delete_file = false;
        $response = array('status' => 'failed', 'message' => '');


        $this->load->library('crew');
        $crew = new Crew($this->{$mode}('crew_id'));

        $received->vessel_id     = $this->{$mode}('vessel_id');
        $received->crew_id       = $this->{$mode}('crew_id');
        $received->position_id   = $crew->position_id;
        $received->remarks       = $this->{$mode}('remarks');
        $received->document      = $this->{$mode}('document');
        $received->receivedfrom  = $this->{$mode}('receivedfrom');
        $received->date_received = ($this->{$mode}('date_received'))? date('Y-m-d', strtotime($this->{$mode}('date_received'))) : '';
        $received->date_check    = ($this->{$mode}('date_check'))? date('Y-m-d', strtotime($this->{$mode}('date_check'))) : '';
        $received->date_expired  = ($this->{$mode}('date_expired'))? date('Y-m-d', strtotime($this->{$mode}('date_expired'))) : '';
        
        $id = $received->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;           
        } else {
            $response['message'] = $received->get_validation_errors();
        }

        return $response;
    }
}