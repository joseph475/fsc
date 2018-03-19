<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Type_sub_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('type_sub_model', 'model');
        $this->load->library('type_sub');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function type_subs_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('type_sub' . serialize($this->_args));

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
    function type_sub_delete()
    {   
        // Get type_sub to determine if user is allowed to delete.
        $type_sub = new type_sub($this->get('id'));

        if (!$type_sub->hasData()) {
            // Throw a 404 if this type_sub does not exist.
            $this->response(FALSE);
        } else {
            if ($type_sub->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($type_sub->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function type_sub_post()
    {        
        $type_sub = new type_sub();

        $type_sub->date_created    = date('Y-m-d H:i:s');
        $type_sub->createdbypk     = $this->get_user()->user_id;
        $type_sub->date_modified   = date('Y-m-d H:i:s');
        $type_sub->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_type_sub_save($type_sub, 'post'));
    } 

    /**
     * Updates an type_sub entry.
     * 
     * @return xml
     */
    function type_sub_put()
    {        
        $type_sub = new type_sub($this->put('id'));

        $type_sub->date_modified   = date('Y-m-d H:i:s');
        $type_sub->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_type_sub_save($type_sub, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _type_sub_save($type_sub, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $type_sub->code             = $this->{$mode}('code');
        $type_sub->title            = $this->{$mode}('title');
        $type_sub->type_id          = $this->{$mode}('type_id');
        $type_sub->published        = $this->{$mode}('published');
        
        $id = $type_sub->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $type_sub->get_validation_errors();
        }

        return $response;
    }
}