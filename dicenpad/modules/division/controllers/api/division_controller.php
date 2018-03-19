<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Division_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('division_model', 'model');
        $this->load->library('division');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function divisions_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('division' . serialize($this->_args));

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
    function division_delete()
    {   
        // Get division to determine if user is allowed to delete.
        $division = new Division($this->get('id'));

        if (!$division->hasData()) {
            // Throw a 404 if this division does not exist.
            $this->response(FALSE);
        } else {
            if ($division->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($division->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function division_post()
    {        
        $division = new Division();

        $division->date_created    = date('Y-m-d H:i:s');
        $division->createdbypk     = $this->get_user()->user_id;
        $division->date_modified   = date('Y-m-d H:i:s');
        $division->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_division_save($division, 'post'));
    } 

    /**
     * Updates an division entry.
     * 
     * @return xml
     */
    function division_put()
    {        
        $division = new Division($this->put('id'));

        $division->date_modified   = date('Y-m-d H:i:s');
        $division->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_division_save($division, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _division_save($division, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $division->option_code   = $this->{$mode}('option_code');
        $division->option        = $this->{$mode}('option');
        $division->inactive      = $this->{$mode}('inactive');
        
        $id = $division->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $division->get_validation_errors();
        }

        return $response;
    }
}