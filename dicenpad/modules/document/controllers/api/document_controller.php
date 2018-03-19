<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Document_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('document_model', 'model');
        $this->load->library('document');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function documents_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('document' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('document' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns a single Crew.
     * 
     * @return xml
     */
    function document_get()
    {
        $id   = $this->get('id');
        $load = 'id';
        
        $cache = Cache::get_instance();
        $document = $cache::get('document' . $id);

        if (!$document) {            
            $document = new Document($id);   
            $document->load($id, $load);  
            $cache::save('document' . $document->id, $document, 1800);
        }
        
        $response = $document->getData();   
        
        $this->response($response);
    }

     // --------------------------------------------------------------------    
    
    /**
    * Delete a record.
    * 
    */
    function document_delete()
    {   
        // Get document to determine if user is allowed to delete.
        $document = new Document($this->get('id'));

        if (!$document->hasData()) {
            // Throw a 404 if this document does not exist.
            $this->response(FALSE);
        } else {
            if ($document->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($document->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an document entry.
     * 
     * @return xml
     */
    function document_post()
    {        
        $document = new document();

        $document->date_created    = date('Y-m-d H:i:s');
        $document->createdbypk     = $this->get_user()->user_id;
        $document->date_modified   = date('Y-m-d H:i:s');
        $document->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_document_save($document, 'post'));
    } 

    /**
     * Updates an document entry.
     * 
     * @return xml
     */
    function document_put()
    {        
        $document = new document($this->put('id'));

        $document->date_modified   = date('Y-m-d H:i:s');
        $document->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_document_save($document, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _document_save($document, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        
        $document->classify_id  = $this->{$mode}('classify_id');
        $document->document     = $this->{$mode}('document');
        $document->division_id  = $this->{$mode}('division_id');
        $document->flag_id      = $this->{$mode}('flag_id');
        $document->code         = $this->{$mode}('code');
        $document->published    = $this->{$mode}('published');
        $document->deleted      = $this->{$mode}('deleted');
        $document->sort_order   = $this->{$mode}('sort_order');
        $document->hasflag      = $this->{$mode}('hasflag');
        $document->defaults     = $this->{$mode}('defaults');
        $document->isdeck_off   = $this->{$mode}('isdeck_off');
        $document->isdeck_rat   = $this->{$mode}('isdeck_rat');
        $document->isengine_off = $this->{$mode}('isengine_off');
        $document->isengine_rat = $this->{$mode}('isengine_rat');
        $document->iscatering   = $this->{$mode}('iscatering');
        $document->sort_order   = $this->{$mode}('sort_order');
        
        $id = $document->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $document->get_validation_errors();
        }

        return $response;
    }
}