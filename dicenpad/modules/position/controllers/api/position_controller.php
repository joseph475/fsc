<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Position_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('position_model', 'model');
        $this->load->library('position');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function positions_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('position' . serialize($this->_args));

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
     * Returns a single position.
     * 
     * @return xml
     */
    function position_get()
    {
        $load = 'id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');     
        } elseif ($this->get('department_id') != '') {
            $id   = $this->get('department_id');
            $load = 'department_id';
        } else {
            $id = $this->get_user()->id;
        }
        
        $cache = Cache::get_instance();
        $position = $cache::get('position' . $id);

        if (!$position) {            
            $position = new Position($id);   
            $position->load($id, $load);           
            $cache::save('position' . $position->id, $position, 1800);
        }
        
        $response = $position->getData();   
        
        $this->response($response);
    }

    /**
    * Delete a record.
    * 
    */
    function position_delete()
    {   
        // Get position to determine if user is allowed to delete.
        $position = new position($this->get('id'));

        if (!$position->hasData()) {
            // Throw a 404 if this position does not exist.
            $this->response(FALSE);
        } else {
            if ($position->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($position->get_validation_errors()));
            }
        }
    
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function position_post()
    {        
        $position = new Position();

        $position->date_created    = date('Y-m-d H:i:s');
        $position->createdbypk     = $this->get_user()->user_id;
        $position->date_modified   = date('Y-m-d H:i:s');
        $position->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_position_save($position, 'post'));
    } 

    /**
     * Updates an position entry.
     * 
     * @return xml
     */
    function position_put()
    {        
        $position = new Position($this->put('id'));

        $position->date_modified   = date('Y-m-d H:i:s');
        $position->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_position_save($position, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _position_save($position, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $position->position         = $this->{$mode}('position');
        $position->code             = $this->{$mode}('code');
        $position->alternate        = ($this->{$mode}('alternate'))? $this->{$mode}('alternate') : $position->position;
        $position->inactive         = $this->{$mode}('inactive');
        $position->sort_order       = $this->{$mode}('sort_order');
        $position->department_id    = $this->{$mode}('department_id');
        $position->division_id      = $this->{$mode}('division_id');
        
        $id = $position->save();
        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $position->get_validation_errors();
        }
        
        return $response;
    }
}