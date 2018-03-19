<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ship_crew_document_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('ship_crew_document_model', 'model');
        $this->load->library('ship_crew_document');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function ship_crew_documents_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('ship_crew_document' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
        }

        $this->response($response);
	}

    /**
    * Get crew's education.
    * 
    */
    function ship_crew_document_get()
    {
        $id   = $this->get('id');
        $load = 'control_nos';
        
        $cache = Cache::get_instance();
        $sc_docs = $cache::get('sc_docs' . $id);

        if (!$sc_docs) {            
            $sc_docs = new Ship_crew_document($id);   
            $sc_docs->load($id, $load);  
            $cache::save('sc_docs' . $sc_docs->control_nos, $sc_docs, 1800);
        }
        
        $response = $sc_docs->getData();   
        $response['l'] = $this->db->last_query(); 
        
        $this->response($response);
    }

}