<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Promotion_history_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('promotion_history_model', 'model');
        $this->load->library('promotion_history');
        $this->load->library('crew');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function promotion_historys_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('promotion_history' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args,true)->result();
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
    function promotion_history_delete()
    {   
        // Get promotion_history to determine if user is allowed to delete.
        $promotion_history = new promotion_history($this->get('id'));

        if (!$promotion_history->hasData()) {
            // Throw a 404 if this promotion_history does not exist.
            $this->response(FALSE);
        } else {
            if ($promotion_history->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($promotion_history->get_validation_errors()));
            }
        }
    
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function promotion_history_post()
    {        
        $promotion_history = new promotion_history();

        $promotion_history->promotion_date  = date('Y-m-d H:i:s');
        $promotion_history->date_created    = date('Y-m-d H:i:s');
        $promotion_history->createdbypk     = $this->get_user()->user_id;
        $promotion_history->date_modified   = date('Y-m-d H:i:s');
        $promotion_history->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_promotion_history_save($promotion_history, 'post'));
    } 

    /**
     * Updates an promotion_history entry.
     * 
     * @return xml
     */
    function promotion_history_put()
    {        
        $promotion_history = new promotion_history($this->put('id'));

        $this->response($this->_promotion_history_save($promotion_history, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _promotion_history_save($promotion_history, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $promotion_history->crew_id            = $this->{$mode}('crew_id');
        $promotion_history->vessel_id          = $this->{$mode}('vessel_id');
        $promotion_history->prev_pos_id        = $this->{$mode}('prev_pos_id');
        $promotion_history->new_pos_id         = $this->{$mode}('new_pos_id');
        $promotion_history->isfromPlan         = 0;
        $promotion_history->remarks            = $this->{$mode}('remarks');
        
        $id = $promotion_history->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 

            $crew = new Crew($promotion_history->crew_id); 

            $crew->position_id  = $promotion_history->new_pos_id;  

            $crew->save();

        } else {
            $response['message'] = $promotion_history->get_validation_errors();
        }

        return $response;
    }
}