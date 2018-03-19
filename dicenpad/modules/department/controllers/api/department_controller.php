<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Department_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('department_model', 'model');
        $this->load->library('department');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function departments_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('department' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args)->result();
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
    function department_delete()
    {   
        // Get department to determine if user is allowed to delete.
        $department = new Department($this->get('id'));

        if (!$department->hasData()) {
            // Throw a 404 if this department does not exist.
            $this->response(FALSE);
        } else {
            if ($department->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($department->get_validation_errors()));
            }
        }
    
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function department_post()
    {        
        $department = new Department();

        $department->date_created    = date('Y-m-d H:i:s');
        $department->createdbypk     = $this->get_user()->user_id;
        $department->date_modified   = date('Y-m-d H:i:s');
        $department->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_department_save($department, 'post'));
    } 

    /**
     * Updates an department entry.
     * 
     * @return xml
     */
    function department_put()
    {        
        $department = new Department($this->put('id'));

        $department->date_modified   = date('Y-m-d H:i:s');
        $department->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_department_save($department, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _department_save($department, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $department->option_code   = $this->{$mode}('option_code');
        $department->option        = $this->{$mode}('option');
        $department->published     = $this->{$mode}('published');
        
        $id = $department->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $department->get_validation_errors();
        }

        return $response;
    }
}