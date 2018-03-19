<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Agent_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('agent_model', 'model');
        $this->load->library('agent');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function agents_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('agent' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('options' . serialize($this->_args), $response);
        }

        $this->response($response);
	}


    /**
     * Returns a single agent.
     * 
     * @return xml
     */
    function agent_get()
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
        $agent = $cache::get('agent' . $id);

        if (!$agent) {            
            $agent = new Agent($id);   
            $agent->load($id, $load);           
            $cache::save('agent' . $agent->id, $agent, 1800);
        }
        
        $response = $agent->getData();   
        
        $this->response($response);
    }

    /**
    * Delete a record.
    * 
    */
    function agent_delete()
    {   
        // Get agent to determine if user is allowed to delete.
        $agent = new agent($this->get('id'));

        if (!$agent->hasData()) {
            // Throw a 404 if this agent does not exist.
            $this->response(FALSE);
        } else {
            if ($agent->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($agent->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function agent_post()
    {        
        $agent = new agent();

        $agent->date_created    = date('Y-m-d H:i:s');
        $agent->createdbypk     = $this->get_user()->user_id;
        $agent->date_modified   = date('Y-m-d H:i:s');
        $agent->modifiedbypk    = $this->get_user()->user_id;
        $agent->hash            = md5(microtime() . uniqid() . date('Y-m-d H:i:s'));

        $this->response($this->_agent_save($agent, 'post'));
    } 

    /**
     * Updates an agent entry.
     * 
     * @return xml
     */
    function agent_put()
    {        
        $agent = new agent($this->put('id'));

        $agent->date_modified   = date('Y-m-d H:i:s');
        $agent->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_agent_save($agent, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _agent_save($agent, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $agent->principal_id    = $this->{$mode}('principal_id');
        $agent->fullname        = $this->{$mode}('fullname');
        $agent->address         = $this->{$mode}('address');
        $agent->port            = $this->{$mode}('port');
        $agent->telno1          = $this->{$mode}('telno1');
        $agent->telno2          = $this->{$mode}('telno2');
        $agent->telno3          = $this->{$mode}('telno3');
        $agent->fax1            = $this->{$mode}('fax1');
        $agent->fax2            = $this->{$mode}('fax2');
        $agent->fax3            = $this->{$mode}('fax3');
        $agent->email           = $this->{$mode}('email');
        $agent->telefax         = $this->{$mode}('telefax');
        $agent->cable           = $this->{$mode}('cable');
        $agent->incharge        = $this->{$mode}('incharge');
        $agent->contact         = $this->{$mode}('contact');
        $agent->designation     = $this->{$mode}('designation');
        $agent->status          = $this->{$mode}('status');

        $id = $agent->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';          
            $response['hash'] = $agent->hash; 
            $response['mode']  = $mode;
        } else {
            $response['message'] = $agent->get_validation_errors();
        }

        return $response;
    }
}