<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_role_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('admin_role_model', 'model');
        $this->load->library('admin_role');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function admin_roles_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('admin_role' . serialize($this->_args));

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
    function admin_role_delete()
    {   
        // Get admin_role to determine if user is allowed to delete.
        $admin_role = new admin_role($this->get('id'));

        if (!$admin_role->hasData()) {
            // Throw a 404 if this admin_role does not exist.
            $this->response(FALSE);
        } else {
            if ($admin_role->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($admin_role->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function admin_role_post()
    {        
        $admin_role = new admin_role();

        $admin_role->date_created    = date('Y-m-d H:i:s');
        $admin_role->createdbypk     = $this->get_user()->user_id;
        $admin_role->date_modified   = date('Y-m-d H:i:s');
        $admin_role->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_admin_role_save($admin_role, 'post'));
    } 

    /**
     * Updates an admin_role entry.
     * 
     * @return xml
     */
    function admin_role_put()
    {        
        $admin_role = new Admin_role($this->put('role_id'));

        $admin_role->date_modified   = date('Y-m-d H:i:s');
        $admin_role->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_admin_role_save($admin_role, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _admin_role_save($admin_role, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $admin_role->role_code      = $this->{$mode}('role_code');
        $admin_role->role           = $this->{$mode}('role');
        $admin_role->inactive       = $this->{$mode}('inactive');     
        $admin_role->role_order     = $this->{$mode}('role_order');    

        $id = $admin_role->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $admin_role->get_validation_errors();
        }

        return $response;
    }
}