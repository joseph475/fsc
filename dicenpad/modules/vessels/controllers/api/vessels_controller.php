<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vessels_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('vessels_model', 'model');
        $this->load->library('vessels');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function vessels_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('vessels' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('options' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns a single vessel.
     * 
     * @return xml
     */
    function vessel_get()
    {
        $load = 'id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');     
        } elseif ($this->get('hash') != '') {
            $id   = $this->get('hash');
            $load = 'hash';
        } else {
            $id = 0;
        }

        $cache = Cache::get_instance();
        $vessel = $cache::get('vessel' . $id);

        if (!$vessel) {            
            $vessel = new Vessels($id);   
            $vessel->load($id, $load);           
            $cache::save('vessel' . $vessel->id, $vessel, 1800);
        }
        
        $response = $vessel->getData();   
        
        $this->response($response);
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function vessel_delete()
    {   
        // Get vessel to determine if user is allowed to delete.
        $vessel = new Vessels($this->get('id'));

        if (!$vessel->hasData()) {
            // Throw a 404 if this vessel does not exist.
            $this->response(FALSE);
        } else {
            if ($vessel->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($vessel->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function vessel_put()
    { 
        $id   = $this->put('id');

        $vessel = new Vessels($id);

        $vessel->date_modified   = date('Y-m-d H:i:s');
        $vessel->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_vessel_save($vessel, 'put'));
    }

    // --------------------------------------------------------------------
    /**
     * Post an vessel entry.
     * 
     * @return xml
     */
    function vessel_post()
    {        
        $vessel = new Vessels();
        $vessel->date_created    = date('Y-m-d H:i:s');
        $vessel->createdbypk     = $this->get_user()->user_id;
        $vessel->date_modified   = date('Y-m-d H:i:s');
        $vessel->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_vessel_save($vessel, 'post'));
    } 

    // --------------------------------------------------------------------   

    private function _vessel_save($vessel, $mode)
    {
        $delete_photo = FALSE;

        $response = array('status' => 'failed', 'message' => '');

        
        $field = array( 'principal_id', 'control_nos', 'status_id', 'company_id', 'type_id', 'vessel_name', 'builder', 'builtin', 'engine', 'e_year', 'manufacturer', 'gross', 
                        'net', 'dwt', 'length', 'depth', 'breadth', 'cylinder', 'hp', 'speed', 'certi_nos', 'order_nos', 'cba', 'status', 'duration',
                        'classification', 'official_nos', 'trade', 'imo_nos', 'flag_id', 'registered', 'us_visa', 'calsign', 'telefax', 'faxno',
                        'certi_validity', 'certi_validity_to', 'order_date');

        foreach ($field as $key) {            
            $vessel->{$key} = $this->{$mode}($key);
        }

        //$vessel->cer_date             = date('Y-m-d', strtotime($this->{$mode}('cer_date')));

        // For Prefix
        $type_id = $this->{$mode}('type_id');
        if(!empty($type_id)){
            $query  = $this->db->query("SELECT type FROM jd_type WHERE ID  = (SELECT type_id FROM jd_type_sub WHERE id = ". $this->{$mode}('type_id') .")");
            $result = $query->row();
            $vessel->prefix = $result->type;
        }

        if ($this->{$mode}('photo') != '' && $this->{$mode}('photo') != $vessel->photo) {
            $delete_photo = $vessel->photo;
        }

        $vessel->photo = $this->{$mode}('photo');

        $id = $vessel->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;

            if ($delete_photo) {
                $this->load->config('dir');
                $upload_path = $this->config->item('upload_dir');                
                unlink ($upload_path . 'media/' . $delete_photo);
                unlink ($upload_path . 'media/thumbnails/' . $delete_photo);
            }           
        } else {
            $response['message'] = $vessel->get_validation_errors();
        }

        return $response;
    }
}