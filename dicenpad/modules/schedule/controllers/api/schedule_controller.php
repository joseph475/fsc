<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('schedule_model', 'model');
        $this->load->library('schedule');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function schedules_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('schedules' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('schedule_h' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns a single schedule.
     * 
     * @return xml
     */
    function schedule_get()
    {
        $load = 'id';
        $id = '';
        if ($this->get('id') != '') {
            $id   = $this->get('id');
        } elseif ($this->get('ref') != '') {
            $id   = $this->get('ref');
            $load = 'control_nos';
        } 
        
        $cache = Cache::get_instance();
        $schedule = $cache::get('schedule' . $id);

        if (!$schedule) {            
            $schedule = new Schedule($id);   
            $schedule->load($id, $load);           
            
            $cache::save('schedule' . $schedule->id, $schedule, 1800);
        }
        
        $response = $schedule->getData();   
        
        $this->response($response);
    }

     // --------------------------------------------------------------------    
    
    /**
    * Delete a record.
    * 
    */
    function schedule_delete()
    {   
        // Get schedule to determine if user is allowed to delete.
        $schedule = new Schedule($this->get('id'));

        if (!$schedule->hasData()) {
            // Throw a 404 if this schedule does not exist.
            $this->response(FALSE);
        } else {
            $fields = $this->db->list_fields('schedule_h_deleted');
            $data = array();

            foreach ($fields as $field) {
                if($field == 'deletedby') {
                    $data['deletedby'] = $this->get_user()->user_id;
                } else {
                    $data[$field] = $schedule->{$field};
                }
            }
            
            if ($schedule->delete()) {
                $this->db->insert('schedule_h_deleted', $data);
                $this->response(TRUE);
            } else {
                $this->response(array($schedule->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an schedule_h entry.
     * 
     * @return xml
     */
    function schedule_post()
    {        
        $schedule = new Schedule();

        $schedule->date_created    = date('Y-m-d H:i:s');
        $schedule->createdbypk     = $this->get_user()->user_id;
        $schedule->date_modified   = date('Y-m-d H:i:s');
        $schedule->modifiedbypk    = $this->get_user()->user_id;
        $schedule->control_nos     = $this->_generate_control();
        
        $this->response($this->_schedule_save($schedule, 'post'));
    } 

    /**
     * Updates an schedule entry.
     * 
     * @return xml
     */
    function schedule_put()
    {        
        $schedule = new Schedule($this->put('id'));

        $schedule->date_modified   = date('Y-m-d H:i:s');
        $schedule->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_schedule_save($schedule, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _schedule_save($schedule, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        
        $schedule->vessel_id    = $this->{$mode}('vessel_id');
        $schedule->joining_date = ($this->{$mode}('joining_date'))? date('Y-m-d', strtotime($this->{$mode}('joining_date'))) : '';
        $schedule->repat_date   = ($this->{$mode}('repat_date'))? date('Y-m-d', strtotime($this->{$mode}('repat_date'))) : ''; 
        $schedule->arrival      = ($this->{$mode}('arrival'))? date('Y-m-d', strtotime($this->{$mode}('arrival'))) : ''; 
        $schedule->onleave      = ($this->{$mode}('onleave'))? date('Y-m-d', strtotime($this->{$mode}('onleave'))) : ''; 
        $schedule->approval_date= ($this->{$mode}('approval_date'))? date('Y-m-d', strtotime($this->{$mode}('approval_date'))) : ''; 
        $schedule->srp_date     = ($this->{$mode}('srp_date'))? date('Y-m-d', strtotime($this->{$mode}('srp_date'))) : ''; 
        $schedule->airport      = $this->{$mode}('airport');
        $schedule->joining_port = $this->{$mode}('joining_port');
        $schedule->han_agent_id = $this->{$mode}('han_agent_id');
        $schedule->cha_agent_id = $this->{$mode}('cha_agent_id');
        $schedule->remarks      = $this->{$mode}('remarks');
        $schedule->airfare1     = $this->{$mode}('airfare1');
        $schedule->airfare2     = $this->{$mode}('airfare2');
        $schedule->visa         = $this->{$mode}('visa');
        $schedule->revision     = $this->{$mode}('revision');
        $schedule->company_id   = $this->{$mode}('company_id');
        $schedule->advised_agent= $this->{$mode}('advised_agent');
        $schedule->is_approve   = $this->{$mode}('is_approve');
        $schedule->final_flight =  $this->{$mode}('final_flight');
        $schedule->final_dispatch= $this->{$mode}('final_dispatch');
        $schedule->off_signers= $this->{$mode}('off_signers');
        $schedule->on_signers= $this->{$mode}('on_signers');
        $schedule->terminal= $this->{$mode}('terminal');
        $schedule->arrival_time= $this->{$mode}('arrival_time');

        $id = $schedule->save();

        if ($id) {
            $response['control_nos'] = $schedule->control_nos;
            $response['id'] = $id;
            $response['status']  = 'success';  
            $response['type']  = $mode;
        } else {
            $response['message'] = $schedule->get_validation_errors();
        }

        return $response;
    }

    /**
     * Generate a key for the requesting user.
     *
     * @param string login user login
     * @param int ctr variable to add
     *
     * @return int API Key
     */
    private function _generate_reference($key=0)
    {        
        // Clear old keys.
        $this->db->where('control_nos', $key);
        $query = $this->db->get('jd_schedule_h');
        if ($query->num_rows() > 0) {
            return $this->_generate_reference(gen_chars(8));
        }

        return $key;
    }

    private function _generate_control() 
    {
        $cn = date('Ymd') . 'F' . strtoupper(substr(uniqid(), -3));

        $this->db->trans_begin();
        $this->db->where('control_nos', $cn);
        $rs = $this->db->get('schedule_h');

        if($rs->num_rows() > 0) {    
            $this->_generate_control();
        }
        $this->db->trans_commit();

        return $cn;

        // $this->db->select('max(control_nos) as control_nos');
        // $query = $this->db->get('jd_schedule_h', 1);    
        // $query = ($query->num_rows() == 1)? array_shift(confirm_query($query)) : false;
        // if(!$query->control_nos){
        //     $query->control_nos = date('Ym') . '0000';
        // }
        // return ($query)? $query->control_nos + 1 : '0';
    }

    
}