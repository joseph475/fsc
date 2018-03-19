<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Salary_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('salary_model', 'model');
        $this->load->library('salary');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function salarys_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('salary' . serialize($this->_args));

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
     * Returns a single salary.
     * 
     * @return xml
     */
    function salary_get()
    {
        $load = 'id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');     
        } elseif ($this->get('position') != '') {
            $id   = $this->get('position');
            $load = 'position_id';
        } elseif ($this->get('vessel') != '') {
            $id   = $this->get('vessel');
            $load = 'vessel_id';
        } else {
            $id = $this->get_user()->id;
        }
        
        $cache = Cache::get_instance();
        $salary = $cache::get('salary' . $id);

        if (!$salary) {            
            $salary = new salary($id);   
            $salary->load($id, $load);           
            $cache::save('salary' . $salary->id, $salary, 1800);
        }
        
        //$response['l'] = $this->db->last_query(); 
        $response = $salary->getData();   
        
        $this->response($response);
    }

    /**
    * Delete a record.
    * 
    */
    function salary_delete()
    {   
        // Get salary to determine if user is allowed to delete.
        $salary = new salary($this->get('id'));

        if (!$salary->hasData()) {
            // Throw a 404 if this salary does not exist.
            $this->response(FALSE);
        } else {
            if ($salary->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($salary->get_validation_errors()));
            }
        }
    
    }

    // --------------------------------------------------------------------
    /**
     * Post an salary entry.
     * 
     * @return xml
     */
    function salary_post()
    {        
        $salary = new Salary();

        $salary->date_created    = date('Y-m-d H:i:s');
        $salary->createdbypk     = $this->get_user()->user_id;
        $salary->date_modified   = date('Y-m-d H:i:s');
        $salary->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_salary_save($salary, 'post'));
    } 

    /**
     * Updates an salary entry.
     * 
     * @return xml
     */
    function salary_put()
    {        
        $salary = new Salary($this->put('id'));

        $salary->date_modified   = date('Y-m-d H:i:s');
        $salary->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_salary_save($salary, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _salary_save($salary, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        
        $field = array( 'basic_salary', 'ot_fixed', 'ot_hourly', 'leave_pay',
                        't_allowance', 's_allowance', 'other_benefits', 'rtmt_fee'); 
        

        foreach ($field as $key) {           
            $currency = 'USD ';
            if (strpos($this->{$mode}($key), 'USD') !== false) {
                $currency = '';
            }
            $salary->{$key} = $currency . $this->{$mode}($key);
        }

        $salary->vessel_id      = $this->{$mode}('vessel_id');
        $salary->position_id    = $this->{$mode}('position_id');
        $salary->nos_slot       = $this->{$mode}('nos_slot');
        $salary->nos_hours      = $this->{$mode}('nos_hours');
        $salary->leave_day      = $this->{$mode}('leave_day');
        $salary->effective_year = $this->{$mode}('effective_year');

        $id = $salary->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $salary->get_validation_errors();
        }
        
        return $response;
    }
}