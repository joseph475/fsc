<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Replacement_plan_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('replacement_plan_model', 'model');
        $this->load->library('replacement_plan');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function replacement_plans_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('replacement_plans' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('replacement_plan' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns a single replacement_plan.
     * 
     * @return xml
     */
    function replacement_plan_get()
    {
        $load = 'replacement_plan_id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');     
        } elseif ($this->get('cid') != '') {
            $id   = $this->get('cid');
            $load = 'crew_id';
        } else {
            $id = $this->get_user()->id;
        }
        
        $cache = Cache::get_instance();
        $replacement_plan = $cache::get('replacement_plan' . $id);

        if (!$replacement_plan) {            
            $replacement_plan = new Replacement_plan($id);   
            $replacement_plan->load($id, $load);           
            $cache::save('replacement_plan' . $replacement_plan->replacement_plan_id, $replacement_plan, 1800);
        }
        
        $response = $replacement_plan->getData();   
        
        $this->response($response);
    }

}