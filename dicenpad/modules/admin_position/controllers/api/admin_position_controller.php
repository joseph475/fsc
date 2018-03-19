<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_position_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('admin_position_model', 'model');
        $this->load->library('admin_position');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function admin_positions_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('admin_position' . serialize($this->_args));

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
    function admin_position_delete()
    {   
        // Get admin_position to determine if user is allowed to delete.
        $admin_position = new admin_position($this->get('id'));

        if (!$admin_position->hasData()) {
            // Throw a 404 if this admin_position does not exist.
            $this->response(FALSE);
        } else {
            if ($admin_position->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($admin_position->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function admin_position_post()
    {        
        $admin_position = new Admin_position();

        $admin_position->date_created    = date('Y-m-d H:i:s');
        $admin_position->createdbypk     = $this->get_user()->user_id;
        $admin_position->date_modified   = date('Y-m-d H:i:s');
        $admin_position->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_admin_position_save($admin_position, 'post'));
    } 

    /**
     * Updates an admin_position entry.
     * 
     * @return xml
     */
    function admin_position_put()
    {        
        $admin_position = new Admin_position($this->put('position_id'));

        $admin_position->date_modified   = date('Y-m-d H:i:s');
        $admin_position->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_admin_position_save($admin_position, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _admin_position_save($admin_position, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $admin_position->position_code   = $this->{$mode}('position_code');
        $admin_position->position        = $this->{$mode}('position');
        $admin_position->inactive        = $this->{$mode}('inactive');
        $admin_position->sort_order      = $this->{$mode}('sort_order');
        
        $id = $admin_position->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $admin_position->get_validation_errors();
        }

        return $response;
    }
}