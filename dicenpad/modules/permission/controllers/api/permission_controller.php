<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permission_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('permission_model', 'model');
        $this->load->library('permission');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function permissions_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('permission' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('permission' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

     // --------------------------------------------------------------------    
    
    /**
    * Delete a record.
    * 
    */
    function permission_delete()
    {   
        // Get permission to determine if user is allowed to delete.
        $permission = new Permission($this->get('id'));

        if (!$permission->hasData()) {
            // Throw a 404 if this permission does not exist.
            $this->response(FALSE);
        } else {
            if ($permission->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($permission->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an permission entry.
     * 
     * @return xml
     */
    function permission_post()
    {        
        $permission = new Permission();
        
        $this->response($this->_permission_save($permission, 'post'));
    } 

    /**
     * Updates an permission entry.
     * 
     * @return xml
     */
    function permission_put()
    {        
        $permission = new Permission($this->put('id'));

        $this->response($this->_permission_save($permission, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _permission_save($permission, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        
        $permission->type_id        = $this->{$mode}('type_id');
        $permission->resource_id    = $this->{$mode}('resource_id');
        $permission->type           = $this->{$mode}('type');
        $permission->i_read         = $this->{$mode}('i_read');
        $permission->i_delete       = $this->{$mode}('i_delete');
        $permission->i_insert       = $this->{$mode}('i_insert');
        $permission->i_update       = $this->{$mode}('i_update');
        $permission->i_print        = $this->{$mode}('i_print');

        $id = $permission->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $permission->get_validation_errors();
        }

        return $response;
    }
}