<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Type_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('type_model', 'model');
        $this->load->library('type');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function types_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('type' . serialize($this->_args));

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
    function type_delete()
    {   
        // Get type to determine if user is allowed to delete.
        $type = new Type($this->get('id'));

        if (!$type->hasData()) {
            // Throw a 404 if this type does not exist.
            $this->response(FALSE);
        } else {
            if ($type->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($type->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function type_post()
    {        
        $type = new Type();

        $type->date_created    = date('Y-m-d H:i:s');
        $type->createdbypk     = $this->get_user()->user_id;
        $type->date_modified   = date('Y-m-d H:i:s');
        $type->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_type_save($type, 'post'));
    } 

    /**
     * Updates an type entry.
     * 
     * @return xml
     */
    function type_put()
    {        
        $type = new Type($this->put('id'));

        $type->date_modified   = date('Y-m-d H:i:s');
        $type->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_type_save($type, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _type_save($type, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $type->code             = $this->{$mode}('code');
        $type->title            = $this->{$mode}('title');
        $type->type             = $this->{$mode}('type');
        $type->published        = $this->{$mode}('published');
        
        $id = $type->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $type->get_validation_errors();
        }

        return $response;
    }
}