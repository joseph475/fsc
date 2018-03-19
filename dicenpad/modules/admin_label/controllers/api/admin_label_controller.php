<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_label_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('admin_label_model', 'model');
        $this->load->library('admin_label');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function admin_labels_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('admin_label' . serialize($this->_args));

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
    function admin_label_delete()
    {   
        // Get admin_label to determine if user is allowed to delete.
        $admin_label = new Admin_label($this->get('id'));

        if (!$admin_label->hasData()) {
            // Throw a 404 if this admin_label does not exist.
            $this->response(FALSE);
        } else {
            if ($admin_label->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($admin_label->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function admin_label_post()
    {        
        $admin_label = new Admin_label();

        $admin_label->date_created    = date('Y-m-d H:i:s');
        $admin_label->createdbypk     = $this->get_user()->user_id;
        $admin_label->date_modified   = date('Y-m-d H:i:s');
        $admin_label->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_admin_label_save($admin_label, 'post'));
    } 

    /**
     * Updates an admin_label entry.
     * 
     * @return xml
     */
    function admin_label_put()
    {        
        $admin_label = new Admin_label($this->put('label_id'));

        $admin_label->date_modified   = date('Y-m-d H:i:s');
        $admin_label->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_admin_label_save($admin_label, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _admin_label_save($admin_label, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $admin_label->label_code        = $this->{$mode}('label_code');
        $admin_label->label             = $this->{$mode}('label');
        $admin_label->published         = $this->{$mode}('published');
        $admin_label->sort_order        = $this->{$mode}('sort_order');
        
        $id = $admin_label->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $admin_label->get_validation_errors();
        }

        return $response;
    }
}