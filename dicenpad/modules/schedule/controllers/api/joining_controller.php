<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Joining_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('joining_model', 'model');
        $this->load->library('schedule');
        $this->load->library('sched/joining');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function joinings_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('joinings' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('joining_h' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns a single joining.
     * 
     * @return xml
     */
    function joining_get()
    {
        $load = 'id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');
        } elseif ($this->get('ref') != '') {
            $id   = $this->get('ref');
            $load = 'control_nos';
        } 
        
        $cache = Cache::get_instance();
        $joining = $cache::get('joining' . $id);

        if (!$joining) {            
            $joining = new Joining($id);   
            $joining->load($id, $load);           
            $cache::save('joining' . $joining->id, $joining, 1800);
        }
        
        $response = $joining->getData();   
        
        $this->response($response);
    }

     // --------------------------------------------------------------------    
    
    /**
    * Delete a record.
    * 
    */
    function joining_delete()
    {   
        // Get joining to determine if user is allowed to delete.
        $joining = new Joining($this->get('id'));

        if (!$joining->hasData()) {
            // Throw a 404 if this joining does not exist.
            $this->response(FALSE);
        } else {
            if ($joining->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($joining->get_validation_errors()));
            }
        }
    }

    function joining2_delete()
    {   
        // Get joining to determine if user is allowed to delete.
        $joining = new Joining($this->get('id'));

        $r = $this->model->get_by_repat($joining->crew_id, $joining->onboard_id);
        $p = $this->model->get_by_promote($joining->crew_id, $joining->onboard_id);
        if($r['isdisembark']) {
            $this->response(array('status' => 'failed', 'message' => "Record already disembarked on reference nos {$r['control_nos']}"));
        } elseif($p['ispromoted']) {
            $this->response(array('status' => 'failed', 'message' => "Record has reference nos {$p['control_nos']} on Promotion"));
        } else {
            if (!$joining->hasData()) {
                // Throw a 404 if this joining does not exist.
                $this->response(FALSE);
            } else {
                if ($joining->remove()) {
                    $joining->isembark  = 0;
                    $joining->onboard_id  = 0;
                    $joining->save();

                    $this->response(TRUE);
                } else {
                    $this->response(array($joining->get_validation_errors()));
                }
            }
        }
    }

    function joining2_put()
    {                
        $this->load->library('onboard2');
        $joining = new Joining($this->get('id'));
        $onboard = new Onboard2($joining->onboard_id);

        $onboard->start_date        = ($this->put('start_date'))? date('Y-m-d', strtotime($this->put('start_date'))) : '';
        $onboard->embarked          = $onboard->start_date;
        $onboard->original_date     = $onboard->start_date;
        $onboard->end_date          = ($this->put('start_date'))? date('Y-m-d', strtotime("+{$joining->duration_month} months", strtotime($onboard->start_date))) : '';
        $onboard->pdos_nos          = $this->put('pdos_nos');
        $onboard->pdos_date         = ($this->put('pdos_date'))? date('Y-m-d', strtotime($this->put('pdos_date'))) : '';
        $onboard->oec_nos           = $this->put('oec_nos');
        $onboard->point_of_hire     = $this->put('point_of_hire'); 
        $onboard->trade             = $this->put('trade'); 
        $onboard->date_modified     = date('Y-m-d H:i:s');
        $onboard->modifiedbypk      = $this->get_user()->user_id;

        $id = $onboard->save();

        if ($id) {
            $joining->start_date = date('Y-m-d', strtotime($this->put('start_date')));
            $joining->save();

            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $joining->get_validation_errors();
        }

        return $this->response($response);
    } 

    // --------------------------------------------------------------------
    /**
     * Post an joining_h entry.
     * 
     * @return xml
     */
    function joining_post()
    {        
        $joining = new Joining();

        $joining->date_created    = date('Y-m-d H:i:s');
        $joining->createdbypk     = $this->get_user()->user_id;
        $joining->date_modified   = date('Y-m-d H:i:s');
        $joining->modifiedbypk    = $this->get_user()->user_id;
        $joining->isembark        = 0;
        
        $this->response($this->_joining_save($joining, 'post'));
    } 

    /**
     * Updates an joining entry.
     * 
     * @return xml
     */
    function joining_put()
    {        
        $joining = new Joining($this->put('id'));

        $joining->date_modified   = date('Y-m-d H:i:s');
        $joining->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_joining_save($joining, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _joining_save($joining, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        
        $sched_id = $this->{$mode}('sched_id');

        $schedule = new Schedule($sched_id);

        $joining->sched_id          = $sched_id;
        $joining->crew_id           = $this->{$mode}('crew_id');
        $joining->position_id       = $this->{$mode}('position_id');
        $joining->salary_id         = $this->{$mode}('salary_id');
        $joining->duration_month    = $this->{$mode}('duration_month');
        $joining->vessel_id         = $schedule->vessel_id;
        $joining->start_date        = date('Y-m-d', strtotime($schedule->joining_date));
        $joining->onboard_id        = $this->{$mode}('onboard_id');
        $joining->remarks           = $this->{$mode}('remarks');

        $id = $joining->save();
        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $joining->get_validation_errors();
        }

        return $response;
    }
}