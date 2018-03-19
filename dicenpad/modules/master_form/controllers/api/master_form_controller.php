<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_form_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('master_form_model', 'model');
        $this->load->library('master_form');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function master_forms_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('master_form' . serialize($this->_args));

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
     * Returns a single Crew.
     * 
     * @return xml
     */
    function master_form_get()
    {
        $load = 'id';
        $id   = $this->get('id');           
        
        $cache = Cache::get_instance();
        $master_form = $cache::get('master_form' . $id);

        if (!$master_form) {            
            $master_form = new Master_form($id);   
            $master_form->load($id, $load);  
            $cache::save('crew' . $master_form->id, $master_form, 1800);
        }
        
        $response = $master_form->getData();   
        
        $this->response($response);
    }

    /**
    * Delete a record.
    * 
    */
    function master_form_delete()
    {   
        // Get master_form to determine if user is allowed to delete.
        $master_form = new master_form($this->get('id'));

        if (!$master_form->hasData()) {
            // Throw a 404 if this master_form does not exist.
            $this->response(FALSE);
        } else {
            if ($master_form->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($master_form->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function master_form_post()
    {        
        $master_form = new master_form();

        $this->response($this->_master_form_save($master_form, 'post'));
    } 

    /**
     * Updates an master_form entry.
     * 
     * @return xml
     */
    function master_form_put()
    {        
        $master_form = new master_form($this->put('id'));

        $this->response($this->_master_form_save($master_form, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _master_form_save($master_form, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $master_form->title         = $this->{$mode}('title');
        $master_form->control_nos   = $this->{$mode}('control_nos');
        $master_form->control_nos2  = $this->{$mode}('control_nos2');
        $master_form->remarks       = $this->{$mode}('remarks');
        $master_form->remarks2      = $this->{$mode}('remarks2');
        $master_form->published     = $this->{$mode}('published');
        
        $id = $master_form->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $master_form->get_validation_errors();
        }

        return $response;
    }
}