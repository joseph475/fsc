<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flag_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('flag_model', 'model');
        $this->load->library('flag');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function flags_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('flag' . serialize($this->_args));

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
    function flag_delete()
    {   
        // Get flag to determine if user is allowed to delete.
        $flag = new flag($this->get('id'));

        if (!$flag->hasData()) {
            // Throw a 404 if this flag does not exist.
            $this->response(FALSE);
        } else {
            if ($flag->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($flag->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function flag_post()
    {        
        $flag = new flag();

        $flag->date_created    = date('Y-m-d H:i:s');
        $flag->createdbypk     = $this->get_user()->user_id;
        $flag->date_modified   = date('Y-m-d H:i:s');
        $flag->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_flag_save($flag, 'post'));
    } 

    /**
     * Updates an flag entry.
     * 
     * @return xml
     */
    function flag_put()
    {        
        $flag = new flag($this->put('id'));

        $flag->date_modified   = date('Y-m-d H:i:s');
        $flag->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_flag_save($flag, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _flag_save($flag, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $flag->code         = $this->{$mode}('code');
        $flag->flag         = $this->{$mode}('flag');
        $flag->published    = $this->{$mode}('published');
        
        $id = $flag->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $flag->get_validation_errors();
        }

        return $response;
    }
}