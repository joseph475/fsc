<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Promotion_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('promotion_model', 'model');
        $this->load->library('sched/promotion');
        $this->load->library('salary');
        $this->load->library('onboard');
        $this->load->library('crew');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function promotions_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('promotions' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('promotion_h' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns a single promotion.
     * 
     * @return xml
     */
    function promotion_get()
    {
        $load = 'id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');
        } 
        
        $cache = Cache::get_instance();
        $promotion = $cache::get('promotion' . $id);

        if (!$promotion) {            
            $promotion = new promotion($id);   
            $promotion->load($id, $load);           
            $cache::save('promotion' . $promotion->id, $promotion, 1800);
        }
        
        $response = $promotion->getData();   
        
        $this->response($response);
    }

     // --------------------------------------------------------------------    
    
    /**
    * Delete a record.
    * 
    */
    function promotion_delete()
    {   
        // Get promotion to determine if user is allowed to delete.
        $promotion = new Promotion($this->get('id'));

        if (!$promotion->hasData()) {
            // Throw a 404 if this promotion does not exist.
            $this->response(FALSE);
        } else {
            if ($promotion->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($promotion->get_validation_errors()));
            }
        }
    }

    function promotion2_delete()
    {   
        // Get promotion to determine if user is allowed to delete.
        $promotion = new Promotion($this->get('id'));

        if (!$promotion->hasData()) {
            // Throw a 404 if this promotion does not exist.
            $this->response(FALSE);
        } else {
            if ($promotion->remove()) {
                $this->response(TRUE);
            } else {
                $this->response(array($promotion->get_validation_errors()));
            }
        }
    }

    function promotion2_put()
    {                
        $this->load->library('onboard2');

        $promotion = new Promotion($this->put('id'));
        $promotion->duration_month    = $this->put('duration_month');
        $promotion->date_promoted     = date('Y-m-d', strtotime($this->put('extension_date')));
        $promotion->remarks           = $this->put('remarks');
        $promotion->save();

        $previous = new Onboard2($promotion->onboard_id);
        $previous->disembarked      = $promotion->date_promoted;
        $previous->extension_date   = $promotion->date_promoted;
        $previous->remarks          = $promotion->remarks;
        $previous->save();
        
        $onboard = new Onboard2($promotion->onboard_id2);

        $onboard->pdos_nos          = $this->put('pdos_nos');
        $onboard->oec_nos           = $this->put('oec_nos');
        $onboard->pdos_date         = ($this->put('pdos_date'))? date('Y-m-d', strtotime($this->put('pdos_date'))) : '';        
        $onboard->month_duration    = ($promotion->duration_month)? $promotion->duration_month + $previous->month_duration: $previous->month_duration;
        $onboard->duration          = ($promotion->duration_month)? $previous->duration . ' w ' . $promotion->extension . ' Extension' : $previous->duration;
        $onboard->end_date          = date('Y-m-d', strtotime($this->put('end_date')));
        $onboard->extension_date    = '0000-00-00';
        $onboard->start_date        = $promotion->date_promoted;
        $onboard->original_date     = $previous->original_date;
        $onboard->embarked          = $onboard->start_date;
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
     * Post an promotion_h entry.
     * 
     * @return xml
     */
    function promotion_post()
    {        
        $promotion = new promotion();

        $promotion->date_created    = date('Y-m-d H:i:s');
        $promotion->date_promoted   = date('Y-m-d');
        $promotion->createdbypk     = $this->get_user()->user_id;
        $promotion->date_modified   = date('Y-m-d H:i:s');
        $promotion->modifiedbypk    = $this->get_user()->user_id;
        // echo "string";
        // exit();
        
        $this->response($this->_promotion_save($promotion, 'post'));
    } 

    /**
     * Updates an promotion entry.
     * 
     * @return xml
     */
    function promotion_put()
    {        
        $promotion = new promotion($this->put('id'));

        $promotion->date_modified   = date('Y-m-d H:i:s');
        $promotion->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_promotion_save($promotion, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _promotion_save($promotion, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $onboard    = new Onboard($this->{$mode}('onboard_id'));
        $crew       = new Crew($onboard->crew_id);
        $salary     = new Salary($this->{$mode}('salary_id'));

        $promotion->crew_id           = $onboard->crew_id;
        $promotion->onboard_id        = $onboard->onboard_id;        
        $promotion->vessel_id         = $onboard->vessel_id;
        $promotion->salary_id         = $salary->id;
        $promotion->position_new      = $salary->position_id;
        $promotion->position_old      = $crew->position_id;
        $promotion->sched_id          = $this->{$mode}('sched_id');
        $promotion->duration_month    = $this->{$mode}('duration_month');
        $promotion->remarks           = $this->{$mode}('premarks');

        $id = $promotion->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $promotion->get_validation_errors();
        }

        return $response;
    }
}