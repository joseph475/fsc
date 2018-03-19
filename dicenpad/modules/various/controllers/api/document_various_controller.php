<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Document_various_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('document_various_model', 'model');
        $this->load->library('document_various');
    }

    /**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function document_variouss_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crews' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, true)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('crew' . serialize($this->_args), $response);
        }

        $this->response($response);
    }

    /**
     * Returns a single Crew.
     * 
     * @return xml
     */
    function document_various_get()
    {
        $load = 'id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');     
        } 
        
        $cache = Cache::get_instance();
        $dv = $cache::get('document_various' . $id);

        if (!$dv) {            
            $dv = new Document_various($id);   
            $dv->load($id, $load);  
            $cache::save('document_various' . $dv->crew_id, $dv, 1800);
        }
        
        $response = $dv->getData();   
                
        $this->response($response);
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function document_various_put()
    { 
        $id   = $this->put('id');

        $db = new Document_various($id);

        $db->date_modified   = date('Y-m-d H:i:s');
        $db->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_document_various_save($db, 'put'));
    }

    // --------------------------------------------------------------------   

    private function _document_various_save($db, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $db->docs_id        = $this->{$mode}('docs_id');
        //$db->published      = $this->{$mode}('option');
        
        $id = $db->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $db->get_validation_errors();
        }

        return $response;
    }
}