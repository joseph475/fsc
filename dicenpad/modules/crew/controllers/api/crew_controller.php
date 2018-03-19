<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('crew_model', 'model');
        $this->load->library('crew');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function crews_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crews' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('crew' . serialize($this->_args), $response);
        }

        $this->response($response);
    }

    function crew_principals_get()
    {
        $this->load->model('crew_principal_model', 'model2');
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_principals' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model2->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model2->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('crew' . serialize($this->_args), $response);
        }

        $this->response($response);
    }

    /**
     * Returns a single Crew.
     * 
     * @return xml
     */
    function crew_get()
    {
        $load = 'crew_id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');     
        } elseif ($this->get('hash') != '') {
            $id   = $this->get('hash');
            $load = 'hash';
        } elseif ($this->get('fullname') != '') {
            $id   = $this->get('fullname');
            $load = 'fullname';
        } 
        
        $cache = Cache::get_instance();
        $crew = $cache::get('crew' . $id);

        if (!$crew) {            
            $crew = new Crew($id);   
            $crew->load($id, $load);  
            $cache::save('crew' . $crew->crew_id, $crew, 1800);
        }
        
        $response = $crew->getData();   
                
        $this->response($response);
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function crew_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $crew = new Crew($this->get('id'));

        if (!$crew->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($crew->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($crew->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function crew_put()
    { 
        $id   = $this->put('id');

        $crew = new Crew($id);

        $crew->date_modified   = date('Y-m-d H:i:s');
        $crew->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_crew_save($crew, 'put'));
    }

    // --------------------------------------------------------------------
    /**
     * Post an crew entry.
     * 
     * @return xml
     */
    function crew_post()
    {        
        $crew = new Crew();
        $crew->date_created    = date('Y-m-d H:i:s');
        $crew->createdbypk     = $this->get_user()->user_id;
        $crew->date_modified   = date('Y-m-d H:i:s');
        $crew->modifiedbypk    = $this->get_user()->user_id;
        $crew->hash            = md5(microtime() . uniqid() . date('Y-m-d H:i:s'));

        $this->response($this->_crew_save($crew, 'post'));
    } 

    // --------------------------------------------------------------------   

    private function _crew_save($crew, $mode)
    {
        $delete_photo = FALSE;

        $response = array('status' => 'failed', 'message' => '');
        
        $field = array( 'payroll_id', 'profit_id', 'firstname', 'middlename', 'lastname', 'position_id', 'position_id2', 'birthplace', 'birth_province', 'pres_address', 'pres_tel', 'cellphone', 'prov_address', 'prov_tel', 'civil_status', 'gender', 
                        'height', 'weight', 'religion', 'sss_no', 'tin_no', 'clothe_size', 'shoe_size', 'blood_type', 'blood_pressure', 'email', 'spouse', 'spouse_add','spouse_bdate','spouse_telephone', 'father', 'father_add', 'father_bdate', 'father_telephone', 
                        'mother', 'mother_add', 'mother_bdate', 'mother_telephone', 'emeg_contact', 'emeg_add', 'emeg_tel', 'benef_fname', 'benef_lname', 'benef_mname', 'benef_relation', 'benef_add');

        foreach ($field as $key) {            
            $crew->{$key} = $this->{$mode}($key);
        }
        $fullname           = $this->{$mode}('lastname') . ', ' . $this->{$mode}('firstname') . ' ' . $this->{$mode}('middlename');
        $crew->fullname     = strtoupper($fullname);
        $bdate              = ($this->{$mode}('birthdate'))? date('Y-m-d H:i:s', strtotime($this->{$mode}('birthdate'))) : '';
        $crew->birthdate    = $bdate;
        $crew->age          = get_age($bdate);

        if ($this->{$mode}('photo') != '' && $this->{$mode}('photo') != $crew->photo) {
            $delete_photo = $crew->photo;
        }

        $crew->photo = $this->{$mode}('photo');

        $id = $crew->save();

        if ($id) {
            $response['id'] = $id;
            $response['hash'] = $crew->hash;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;

            if($mode == 'post'){
                $this->load->model('document_model', 'dmodel');
                
                $docs = $this->dmodel->insert_docs($id);
            }

            if ($delete_photo) {
                $this->load->config('dir');
                $upload_path = $this->config->item('upload_dir');                
                unlink ($upload_path . 'media/' . $delete_photo);
                unlink ($upload_path . 'media/thumbnails/' . $delete_photo);
            }        
        } else {
            $errors = objectToArray($crew->get_validation_errors());
            $message = '';
            foreach ($errors as $key => $value) {
                $message .= strtoupper($key) . ': ';
                foreach ($value as $data) {
                    $message .= $data . '<br/>';
                }
            }
            $response['message'] = $message;
        }

        return $response;
    }

    function assessment_put()
    { 
        $id   = $this->put('id');

        $crew = new Crew($id);

        $crew->pa_family        = $this->put('pa_family');
        $crew->pa_smoking       = $this->put('pa_smoking');
        $crew->pa_drinking      = $this->put('pa_drinking');
        $crew->pa_prev_ill      = $this->put('pa_prev_ill');
        $crew->pa_job_ability   = $this->put('pa_job_ability');
        $crew->pa_motivation    = $this->put('pa_motivation');
        $crew->pa_change        = $this->put('pa_change');

        $response = array('status' => 'failed', 'message' => '');

        $id = $crew->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';    
        } else {
            $response['message'] = $crew->get_validation_errors();
        }

        $this->response($response);
    }

    function language_put()
    { 
        $id   = $this->put('id');

        $crew = new Crew($id);

        $crew->read_write       = $this->put('read_write');
        $crew->speak_listen     = $this->put('speak_listen');
        $crew->other_language   = $this->put('other_language');

        $response = array('status' => 'failed', 'message' => '');

        $id = $crew->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';    
        } else {
            $response['message'] = $crew->get_validation_errors();
        }

        $this->response($response);
    }

    function remarks_put()
    { 
        $id   = $this->put('id');

        $crew = new Crew($id);

        $crew->remarks          = $this->put('remarks');

        $response = array('status' => 'failed', 'message' => '');

        $id = $crew->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';    
        } else {
            $response['message'] = $crew->get_validation_errors();
        }

        $this->response($response);
    }

    /**
     * Return API key upon login.
     *
     * @param string username User login
     * @param string password User password
     *
     * @return xml HTTP Status code and API KEY 
     */ 
    function validate_post()
    {                       
        $arr = array('firstname' => $this->post('firstname'), 
                     'lastname' => $this->post('lastname'), 
                     'middlename' => $this->post('middlename'), 
                     'birthdate' => date('Y-m-d', strtotime($this->post('birthdate')))
                     );

        $member = $this->model->get_by_array($arr);
        if ($member) {
            $response = TRUE; 
        } else {
            $response = FALSE;
        }
        $this->response($response);
    }

}