<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Options_controller extends PTGI_rest_controller
{
    // Filters for sending out data via REST, we don't want to give out data like passwords and such.
    private $_response_filter = array('');

	function __construct()
	{
		parent::__construct();

        $this->load->model('options_model', 'model');
        $this->load->library('options');
	}

    // --------------------------------------------------------------------

    /**
     * Returns Options when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function options_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('options' . serialize($this->_args));

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
    

    // --------------------------------------------------------------------

    /**
     * Returns Masters when called via get
     * 
     * @return xml
     */
    function masters_get()
    {
        $cache = Cache::get_instance();        
        
        $response = $cache::get('masters' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);
            if ($response['_count'] > 0)
            {
                $masters = $this->model->fetch($this->_args, TRUE);
                foreach ($masters->result() as $master) {
                    $e = new Options();
                    $e->loadArray($master);
                    $response['data'][] = $e->getData();
                }
            }
            $response['l'] = $this->db->last_query();   
            $cache::save('masters' . serialize($this->_args), $response);
        }
        
        $this->response($response, 200, 'xml');
    }

    // --------------------------------------------------------------------	
    
    /**
    * Delete a record.
    * 
    */
    function option_delete()
    {   
        // Get options to determine if user is allowed to delete.
        $options = new Options($this->get('id'));

        if (!$options->hasData()) {
            // Throw a 404 if this options does not exist.
            $this->response(FALSE);
        } else {
            if ($options->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($options->get_validation_errors()));
            }
        }
    
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function option_post()
    {        
        $options = new Options();

        $this->response($this->_options_save($options, 'post'));
    } 

    /**
     * Updates an options entry.
     * 
     * @return xml
     */
    function option_put()
    {        
        $options = new Options($this->put('option_id'));

        $this->response($this->_options_save($options, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _options_save($options, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $options->option_code   = $this->{$mode}('option_code');
        $options->option        = $this->{$mode}('option');
        $options->inactive      = $this->{$mode}('inactive');
        $options->option_group  = $this->{$mode}('option_group');
        
        $id = $options->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $options->get_validation_errors();
        }

        return $response;
    }
}
