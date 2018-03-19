<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Options2_controller extends PTGI_rest_controller
{
    // Filters for sending out data via REST, we don't want to give out data like passwords and such.
    private $_response_filter = array('');

	function __construct()
	{
		parent::__construct();

        $this->load->model('options2_model', 'model');
        $this->load->model('options3_model', 'model3');
	}

    // --------------------------------------------------------------------

    /**
     * Returns Options when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function options2_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('options2' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, True)->result();
            }                  
            $response['l'] = $this->db->last_query();          
            //$cache::save('options2' . serialize($this->_args), $response);
        }

        $this->response($response); 
	}
    
    function options3_get()
    {

        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('options3' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model3->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model3->fetch($this->_args, True)->result();
            }                  
            $response['l'] = $this->db->last_query();          
            //$cache::save('options2' . serialize($this->_args), $response);
        }

        $this->response($response); 
    }

    
}
