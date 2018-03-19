<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flight_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('flight_model', 'model');
        $this->load->library('flight');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function flights_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('flights' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('flight_h' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns a single flight.
     * 
     * @return xml
     */
    function flight_get()
    {
        $load = 'id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');
        } elseif ($this->get('sched_id') != '') {
            $load = 'sched_id';
            $id   = $this->get('sched_id');
        } 
        
        $cache = Cache::get_instance();
        $flight = $cache::get('flight' . $id);

        if (!$flight) {            
            $flight = new flight($id);   
            $flight->load($id, $load);           
            $cache::save('flight' . $flight->id, $flight, 1800);
        }
        
        $response = $flight->getData();   
        
        $this->response($response);
    }

     // --------------------------------------------------------------------    
    
    /**
    * Delete a record.
    * 
    */
    function flight_delete()
    {   
        // Get flight to determine if user is allowed to delete.
        $flight = new Flight($this->get('id'));

        if (!$flight->hasData()) {
            // Throw a 404 if this flight does not exist.
            $this->response(FALSE);
        } else {
            if ($flight->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($flight->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an flight_h entry.
     * 
     * @return xml
     */
    function flight_post()
    {        
        $flight = new Flight();

        $flight->date_created    = date('Y-m-d H:i:s');
        $flight->createdbypk     = $this->get_user()->user_id;
        $flight->date_modified   = date('Y-m-d H:i:s');
        $flight->modifiedbypk    = $this->get_user()->user_id;
        // echo "string";
        // exit();
        
        $this->response($this->_flight_save($flight, 'post'));
    } 

    /**
     * Updates an flight entry.
     * 
     * @return xml
     */
    function flight_put()
    {        
        $flight = new Flight($this->put('id'));

        $flight->date_modified   = date('Y-m-d H:i:s');
        $flight->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_flight_save($flight, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _flight_save($flight, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        
        $flight->sched_id        = $this->{$mode}('sched_id');
        $flight->type            = $this->{$mode}('type');
        $flight->flight_date     = ($this->{$mode}('flight_date'))? date('Y-m-d H:i:s', strtotime($this->{$mode}('flight_date'))) : '';
        $flight->flight_no       = $this->{$mode}('flight_no');
        $flight->flight_time     = $this->{$mode}('flight_time');
        $flight->origin          = $this->{$mode}('origin');
        $flight->destination     = $this->{$mode}('destination');
        $flight->remarks         = $this->{$mode}('remarks');

        $id = $flight->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $flight->get_validation_errors();
        }

        return $response;
    }
}