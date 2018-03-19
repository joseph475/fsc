<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Principal_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('principal_model', 'model');
        $this->load->library('principal');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function principals_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('principals' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args,true)->result();
            }                 
            $response['l'] = $this->db->last_query();       
            $response['cache'] = $this->_args;   
            //$cache::save('options' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns a single principal.
     * 
     * @return xml
     */
    function principal_get()
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
        $principal = $cache::get('principal' . $id);

        if (!$principal) {            
            $principal = new Principal($id);   
            $principal->load($id, $load);           
            $cache::save('principal' . $principal->id, $principal, 1800);
        }
        
        $response = $principal->getData();   
        
        $this->response($response);
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function principal_delete()
    {   
        // Get principal to determine if user is allowed to delete.
        $principal = new Principal($this->get('id'));

        if (!$principal->hasData()) {
            // Throw a 404 if this principal does not exist.
            $this->response(FALSE);
        } else {
            if ($principal->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($principal->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function principal_put()
    { 
        $id   = $this->put('id');

        $principal = new Principal($id);

        $principal->date_modified   = date('Y-m-d H:i:s');
        $principal->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_principal_save($principal, 'put'));
    }

    // --------------------------------------------------------------------
    /**
     * Post an principal entry.
     * 
     * @return xml
     */
    function principal_post()
    {        
        $principal = new Principal();
        $principal->date_created    = date('Y-m-d H:i:s');
        $principal->createdbypk     = $this->get_user()->user_id;
        $principal->date_modified   = date('Y-m-d H:i:s');
        $principal->modifiedbypk    = $this->get_user()->user_id;
        $principal->hash            = md5(microtime() . uniqid() . date('Y-m-d H:i:s'));

        $this->response($this->_principal_save($principal, 'post'));
    } 

    // --------------------------------------------------------------------   

    private function _principal_save($principal, $mode)
    {
        $delete_photo = FALSE;

        $response = array('status' => 'failed', 'message' => '');
        
        $field = array( 'fullname', 'code', 'alternate', 'status', 'address', 'sss', 'cable', 'telno1', 'telno2', 'telno3', 
                        'fax1', 'fax2', 'fax3', 'telefax', 'person1', 'designate1', 'contact1', 'person2', 'designate2', 
                        'contact2'); 
                        
        foreach ($field as $key) {            
            $principal->{$key} = $this->{$mode}($key);
        }

        $principal->accredited      = date('Y-m-d', strtotime($this->{$mode}('accredited')));
        
        if ($this->{$mode}('photo') != '' && $this->{$mode}('photo') != $principal->photo) {
            $delete_photo = $principal->photo;
        }

        $principal->photo  = $this->{$mode}('photo');
        
        $id = $principal->save();

        if ($id) {
            $response['id'] = $id;
            $response['hash'] = $principal->hash;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;

            if ($delete_photo) {
                $this->load->config('dir');
                $upload_path = $this->config->item('upload_dir');                
                unlink ($upload_path . 'media/' . $delete_photo);
                unlink ($upload_path . 'media/thumbnails/' . $delete_photo);
            }         
        } else {
            $response['message'] = $principal->get_validation_errors();
        }

        return $response;
    }
}