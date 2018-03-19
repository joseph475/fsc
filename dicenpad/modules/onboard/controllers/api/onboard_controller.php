<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Onboard_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('onboard_model', 'model');
        $this->load->library('onboard');
        $this->load->library('crew');
        $this->load->library('promotion_history');
        $this->load->library('vessels');
        $this->load->library('position');
        $this->load->library('principal');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function onboards_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('onboards' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            } 
            $response['l'] = $this->db->last_query();          
            //$cache::save('onboard' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function crew_vessels_get()
    {
        $this->load->model('vessel_crew_model', 'model1');

        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('onboards' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model1->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model1->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('onboard' . serialize($this->_args), $response);
        }

        $this->response($response);
    }

    /**
     * Returns a single onboard.
     * 
     * @return xml
     */
    function onboard_get()
    {
        $load = 'onboard_id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');     
        } elseif ($this->get('cid') != '') {
            $id   = $this->get('cid');
            $load = 'crew_id';
        } else {
            $id = $this->get_user()->id;
        }
        
        $cache = Cache::get_instance();
        $onboard = $cache::get('onboard' . $id);

        if (!$onboard) {            
            $onboard = new Onboard($id);   
            $onboard->load($id, $load);           
            $cache::save('onboard' . $onboard->onboard_id, $onboard, 1800);
        }
        
        $response = $onboard->getData();   
        
        $this->response($response);
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function onboard_delete()
    {   
        // Get onboard to determine if user is allowed to delete.
        $onboard = new Onboard($this->get('id'));

        if (!$onboard->hasData()) {
            // Throw a 404 if this onboard does not exist.
            $this->response(FALSE);
        } else {
            if ($onboard->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($onboard->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function onboard_put()
    {   
        $response = array('status' => 'failed', 'message' => '');

        $this->load->library('Onboard2');
        $onboard = new Onboard2($this->put('id'));

        if($onboard->crew_id != $this->put('crew_id') || $onboard == FALSE) {
            $response['id'] = 0;
            $response['status']  = 'failed'; 
            $response['message'] = "Invalid Onboard ID! Please remove and re-encode this crew again!";
            return $this->response($response);
        }

        $onboard->date_modified             = date('Y-m-d H:i:s');
        $onboard->modifiedbypk              = $this->get_user()->user_id;

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
        $onboard->isdone                    = 1;

        $id = $onboard->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';   

            // ------- UPDATE CREW TAG STATUS AS ONBOARD
            $crew = new Crew($onboard->crew_id); 
            $crew->status_id        = 2;
            $crew->date_modified    = date('Y-m-d H:i:s');
            $crew->modifiedbypk     = $this->get_user()->user_id;
            $crew->save();

            // ------- UPDATE JOIN TAG DISEMBARK AS 1
            $this->load->library('sched/repat');
            $repat = new Repat($this->put('repat_id'));
            $repat->isdisembark    = 1;
            $repat->save();
        } else {
            $response['message'] = $onboard->get_validation_errors();
        }

        return $this->response($response);
    }

    // --------------------------------------------------------------------
    /**
     * Post an onboard entry.
     * 
     * @return xml
     */
    function onboard_post()
    {        
        $this->load->library('sched/joining');

        $joining    = new Joining($this->post('joining_id'));
        $position   = new Position($joining->position_id);
        $crew       = new Crew($joining->crew_id);
        $vessels    = new Vessels($joining->vessel_id);
        $principal  = new Principal($vessels->principal_id);

        $onboard = new Onboard();
        
        $onboard->date_created    = date('Y-m-d H:i:s');
        $onboard->createdbypk     = $this->get_user()->user_id;
        $onboard->date_modified   = date('Y-m-d H:i:s');
        $onboard->modifiedbypk    = $this->get_user()->user_id;

        $response = array('status' => 'failed', 'message' => '');

        $onboard->reference         = $this->start_number();
        $onboard->crew_id           = $crew->crew_id;  
        $onboard->history_id        = $crew->history_id;  
        $onboard->sched_id          = $joining->sched_id;
        $onboard->salary_id         = $joining->salary_id; 
        $onboard->vessel_id         = $vessels->id;  
        $onboard->vessel_old_id     = $vessels->code;   
        $onboard->principal_id      = $principal->id; 
        $onboard->principal_old_id  = $principal->code; 
        $onboard->position_id       = $position->id; 
        $onboard->position          = $position->code; 
        $onboard->department_id     = $position->department_id;  
        $onboard->point_of_hire     = $this->post('point_of_hire');
        $onboard->trade             = ($this->post('trade'))? $this->post('trade') : $vessels->trade;
        $onboard->joining_port      = $this->post('joining_port');
        $onboard->pdos_nos          = $this->post('pdos_nos');
        $onboard->oec_nos           = $this->post('oec_nos');
        $onboard->pdos_date         = ($this->post('pdos_date'))? date('Y-m-d', strtotime($this->post('pdos_date'))) : '0000-00-00';
        $onboard->month_duration    = $joining->duration_month;
        $onboard->duration          = $joining->duration;
        $onboard->remarks           = $joining->remarks;
        $onboard->start_date        = date('Y-m-d', strtotime($this->post('start_date')));
        $onboard->embarked          = $onboard->start_date;
        $onboard->original_date     = $onboard->start_date;
        $onboard->end_date          = date('Y-m-d', strtotime("+{$onboard->month_duration} months", strtotime($onboard->start_date)));
        $onboard->onboard_status    = 'ENGAGED';
        $onboard->isdone            = 0; 
        $id = $onboard->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';   

            // ------- UPDATE CREW TAG STATUS AS ONBOARD
            $crew = new Crew($onboard->crew_id); 
            $crew->status_id        = 3; 
            $crew->date_modified    = date('Y-m-d H:i:s');
            $crew->modifiedbypk     = $this->get_user()->user_id;
            $crew->save();

            // ------- UPDATE JOIN TAG ISPROMOTED AS 1
            $joining->isembark    = 1;            
            $joining->save();
        } else {
            $response['message'] = $onboard->get_validation_errors();
        }

        return $this->response($response);
    } 

    // --------------------------------------------------------------------
    /**
     * Post an onboard entry.
     * 
     * @return xml
     */
    function onpromote_post()
    {       
        $response = array('status' => 'failed', 'message' => '');

        $this->load->library('sched/promotion');
        $this->load->library('Onboard2');

        $promotion  = new Promotion($this->post('promotion_id'));
        $position   = new Position($promotion->position_new);
        $crew       = new Crew($promotion->crew_id);
        $vessels    = new Vessels($promotion->vessel_id);
        $principal  = new Principal($vessels->principal_id);

        $previous = new Onboard2($promotion->onboard_id);
        $previous->isdone         = 1;
        $previous->remarks        = $this->post('remarks');
        $previous->extension_date = date('Y-m-d', strtotime($this->post('extension_date'))); 
        $previous->disembarked    = $previous->extension_date;
        $id = $previous->save();
       
        $onboard = new Onboard();
        
        $onboard->date_created    = date('Y-m-d H:i:s');
        $onboard->createdbypk     = $this->get_user()->user_id;
        $onboard->date_modified   = date('Y-m-d H:i:s');
        $onboard->modifiedbypk    = $this->get_user()->user_id;

        $onboard->crew_id           = $crew->crew_id;  
        $onboard->history_id        = $crew->history_id;  
        $onboard->sched_id          = $promotion->sched_id;
        $onboard->salary_id         = $promotion->salary_id; 
        $onboard->vessel_id         = $vessels->id;  
        $onboard->vessel_old_id     = $vessels->code;  
        $onboard->principal_id      = $principal->id; 
        $onboard->principal_old_id  = $principal->code; 
        $onboard->position_id       = $position->id; 
        $onboard->position          = $position->code; 
        $onboard->department_id     = $position->department_id;  
        $onboard->point_of_hire     = $previous->point_of_hire; 
        $onboard->trade             = $previous->trade; 
        $onboard->joining_port      = $this->post('joining_port');
        $onboard->pdos_nos          = $this->post('pdos_nos');
        $onboard->oec_nos           = $this->post('oec_nos');
        $onboard->pdos_date         = ($this->post('pdos_date'))? date('Y-m-d', strtotime($this->post('pdos_date'))) : '0000-00-00';
        $onboard->reference         = $previous->reference;
        $onboard->remarks           = '';
        $onboard->start_date        = $previous->disembarked;
        $onboard->end_date          = date('Y-m-d', strtotime($this->post('end_date')));
        $onboard->month_duration    = ($promotion->duration_month)? $promotion->duration_month + $previous->month_duration: $previous->month_duration;
        $onboard->duration          = ($promotion->duration_month)? $previous->duration . ' w ' . $promotion->extension . ' Extension' : $previous->duration;
        $onboard->extension_date    = '0000-00-00';  
        $onboard->embarked          = $previous->start_date;
        $onboard->original_date     = $previous->original_date;
        $onboard->disembarked       = '0000-00-00';
        $onboard->onboard_status    = 'RE-ENGAGED';
        $onboard->isdone            = 0;
        $id = $onboard->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';   

            // ------- UPDATE CREW TAG STATUS AS ONBOARD
            $crew = new Crew($onboard->crew_id); 
            $crew->status_id        = 3;
            $crew->position_id      = $position->id;  
            $crew->position_old     = $position->code;
            $crew->date_modified    = date('Y-m-d H:i:s');
            $crew->modifiedbypk     = $this->get_user()->user_id;
            $crew->save();

            // ------- UPDATE CREW TAG STATUS AS ONBOARD
            $promote_history = new Promotion_history();
            $promote_history->crew_id           = $promotion->crew_id;
            $promote_history->vessel_id         = $promotion->vessel_id;
            $promote_history->promotion_date    = $promotion->date_promoted;
            $promote_history->onboard_date      = $previous->embarked;
            $promote_history->prev_pos_id       = $promotion->position_old;
            $promote_history->new_pos_id        = $promotion->position_new;
            $promote_history->date_created      = date('Y-m-d H:i:s');
            $promote_history->createdbypk       = $this->get_user()->user_id;
            $promote_history->date_modified     = date('Y-m-d H:i:s');
            $promote_history->modifiedbypk      = $this->get_user()->user_id;
            $promote_history->save();

            // ------- UPDATE JOIN TAG ISPROMOTED AS 1
            $promotion->ispromoted    = 1;
            $promotion->onboard_id2   = $id;
            $promotion->date_promoted = date('Y-m-d', strtotime($this->post('extension_date')));
            $promotion->remarks       = $this->post('remarks');
            $promotion->save();
            
        } else {
            $response['message'] = $onboard->get_validation_errors();
        }

        return $this->response($response);
    } 

    private function start_number()
    {
        $this->db->select('max(reference) as reference');
        $query = $this->db->get('jd_onboard', 1);    
        $query = ($query->num_rows() == 1)? array_shift(confirm_query($query)) : false;
        if(!$query->reference){
            $query->reference = 1000;            
        }

        $reference = ($query)? $query->reference + 1 : '1000';
        return $reference;
    }   
    
}