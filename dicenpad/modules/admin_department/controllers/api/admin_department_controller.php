<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_department_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('admin_department_model', 'model');
        $this->load->library('admin_department');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function admin_departments_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('admin_department' . serialize($this->_args));

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
    function admin_department_delete()
    {   
        // Get admin_department to determine if user is allowed to delete.
        $admin_department = new admin_department($this->get('id'));

        if (!$admin_department->hasData()) {
            // Throw a 404 if this admin_department does not exist.
            $this->response(FALSE);
        } else {
            if ($admin_department->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($admin_department->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function admin_department_post()
    {        
        $admin_department = new admin_department();

        $admin_department->date_created    = date('Y-m-d H:i:s');
        $admin_department->createdbypk     = $this->get_user()->user_id;
        $admin_department->date_modified   = date('Y-m-d H:i:s');
        $admin_department->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_admin_department_save($admin_department, 'post'));
    } 

    /**
     * Updates an admin_department entry.
     * 
     * @return xml
     */
    function admin_department_put()
    {        
        $admin_department = new admin_department($this->put('department_id'));

        $admin_department->date_modified   = date('Y-m-d H:i:s');
        $admin_department->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_admin_department_save($admin_department, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _admin_department_save($admin_department, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $admin_department->department_code   = $this->{$mode}('department_code');
        $admin_department->department        = $this->{$mode}('department');
        $admin_department->inactive          = $this->{$mode}('inactive');
        
        $id = $admin_department->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $admin_department->get_validation_errors();
        }

        return $response;
    }
}