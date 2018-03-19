<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Repat_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('repat_model', 'model');
        $this->load->library('sched/repat');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function repats_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('repats' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('repat_h' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns a single repat.
     * 
     * @return xml
     */
    function repat_get()
    {
        $load = 'id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');
        } 
        
        $cache = Cache::get_instance();
        $repat = $cache::get('repat' . $id);

        if (!$repat) {            
            $repat = new repat($id);   
            $repat->load($id, $load);           
            $cache::save('repat' . $repat->id, $repat, 1800);
        }
        
        $response = $repat->getData();   
        
        $this->response($response);
    }

     // --------------------------------------------------------------------    
    
    /**
    * Delete a record.
    * 
    */
    function repat_delete()
    {   
        // Get repat to determine if user is allowed to delete.
        $repat = new Repat($this->get('id'));

        if (!$repat->hasData()) {
            // Throw a 404 if this repat does not exist.
            $this->response(FALSE);
        } else {
            if ($repat->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($repat->get_validation_errors()));
            }
        }
    }

    function repat2_delete()
    {   
        // Get repat to determine if user is allowed to delete.
        $repat = new Repat($this->get('id'));

        if (!$repat->hasData()) {
            // Throw a 404 if this repat does not exist.
            $this->response(FALSE);
        } else {
            if ($repat->remove()) {
                $this->response(TRUE);
            } else {
                $this->response(array($repat->get_validation_errors()));
            }
        }
    }

    function repat2_put()
    {                
        $this->load->library('onboard2');
        $repat = new Repat($this->get('id'));
        $onboard = new Onboard2($repat->onboard_id);

        if($onboard->crew_id != $this->put('crew_id') || $onboard == FALSE) {
            $response['id'] = 0;
            $response['status']  = 'failed'; 
            $response['message'] = "Invalid Onboard ID! Please remove and re-encode this crew again!";
            return $this->response($response);
        }

        $onboard->port                      = $this->put('port');    
        $onboard->reason                    = $this->put('reason');
        $onboard->performance_grade         = $this->put('performance_grade');
        $onboard->disembarked               = date('Y-m-d', strtotime($this->put('disembarked')));
        $onboard->arrival_date              = date('Y-m-d', strtotime($this->put('arrival_date')));
        $onboard->next_joining              = date('Y-m-d', strtotime($this->put('next_joining')));

        $onboard->finished_remarks          = $this->put('finished_remarks');
        $onboard->finished_others           = $this->put('finished_others');
        $onboard->unfinished_accounts1      = $this->put('unfinished_accounts1');
        $onboard->unfinished_accounts2      = $this->put('unfinished_accounts2');
        $onboard->unfinished_accounts3      = $this->put('unfinished_accounts3');
        $onboard->unfinished_hearing1       = date('Y-m-d', strtotime($this->put('unfinished_hearing1')));
        $onboard->unfinished_hearing2       = date('Y-m-d', strtotime($this->put('unfinished_hearing2')));
        $onboard->unfinished_hearing3       = date('Y-m-d', strtotime($this->put('unfinished_hearing3')));
        $onboard->unfinished_hearing4       = date('Y-m-d', strtotime($this->put('unfinished_hearing4')));
        $onboard->unfinished_remarks        = $this->put('unfinished_remarks');
        $onboard->unfinished_case           = $this->put('unfinished_case');
        $onboard->unfinished_legal          = $this->put('unfinished_legal');
        $onboard->unfinished_surety         = $this->put('unfinished_surety');
        $onboard->unfinished_insurance      = $this->put('unfinished_insurance');
        $onboard->unfinished_settlement     = $this->put('unfinished_settlement');
       
        $onboard->pi_club                   = $this->put('pi_club');
        $onboard->pi_hospital1              = $this->put('pi_hospital1');
        $onboard->pi_hospital2              = $this->put('pi_hospital2');
        $onboard->pi_hospital3              = $this->put('pi_hospital3');
        $onboard->pi_progress1              = $this->put('pi_progress1');
        $onboard->pi_progress2              = $this->put('pi_progress2');
        $onboard->pi_progress3              = $this->put('pi_progress3');
        $onboard->pi_sick1                  = $this->put('pi_sick1');
        $onboard->pi_sick2                  = $this->put('pi_sick2');
        $onboard->pi_fit                    = date('Y-m-d', strtotime($this->put('pi_fit')));
        $onboard->pi_submission             = date('Y-m-d', strtotime($this->put('pi_submission')));
        $onboard->pi_approval               = date('Y-m-d', strtotime($this->put('pi_approval')));
        $onboard->pi_settlement             = $this->put('pi_settlement');
        $id = $onboard->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $joining->get_validation_errors();
        }

        return $this->response($response);
    } 

    // --------------------------------------------------------------------
    /**
     * Post an repat_h entry.
     * 
     * @return xml
     */
    function repat_post()
    {        
        $repat = new repat();

        $repat->date_created    = date('Y-m-d H:i:s');
        $repat->createdbypk     = $this->get_user()->user_id;
        $repat->date_modified   = date('Y-m-d H:i:s');
        $repat->modifiedbypk    = $this->get_user()->user_id;
        // echo "string";
        // exit();
        
        $this->response($this->_repat_save($repat, 'post'));
    } 

    /**
     * Updates an repat entry.
     * 
     * @return xml
     */
    function repat_put()
    {        
        $repat = new repat($this->put('id'));

        $repat->date_modified   = date('Y-m-d H:i:s');
        $repat->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_repat_save($repat, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _repat_save($repat, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        
        $repat->crew_id           = $this->{$mode}('crew_id');
        $repat->onboard_id        = $this->{$mode}('onboard_id');
        $repat->sched_id          = $this->{$mode}('sched_id');
        $repat->vessel_id         = $this->{$mode}('vessel_id');
        $repat->position_id       = $this->{$mode}('position_id');
        $repat->remarks           = $this->{$mode}('remarks');

        $id = $repat->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $repat->get_validation_errors();
        }

        return $response;
    }
}