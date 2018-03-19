<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_docs_controller extends PTGI_rest_controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->model('docs_model', 'model');
        $this->load->library('crew/docs');
        $this->load->library('crew');
    }

    function crew_docs_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_docs' . serialize($this->_args));

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
    * Get crew's Docs.
    * 
    */
    function crew_doc_get()
    {
        $offset = null;
        $limit = 10;
        $sort = 'sort_order';
        $order = 'desc';
        if ($this->get('limit') != '') {
            $limit  = $this->get('limit');            
            
            if ($this->get('offset') != '') {
                $offset = $this->get('offset');
            }
        }   

        $response['_count'] = $this->model->count_results($this->_args);

        $crew = new Crew();
        $crew->load($this->get('crew_id'), 'crew_id');

        $crew = $this->model->get_by_crew($this->get('id'));
        if ($crew) {
            return $this->response($this->model->get_by_crew($this->get('id')));          
        } else {
            $response['status']  = 'No data was found';
            return $this->response($response);  
        }
    }   

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function crew_doc_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $docs = new Docs($this->get('id'));

        if (!$docs->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            $id     = $this->get('id');
            $array  = array( 'crew_docs' . '.id' => $id);
            $query1 = $this->model->get_crew($array);
            $query  = $this->model->delete_docs($id);
            if ($query && $query1) {

                $this->load->config('dir');
                $upload_path = $this->config->item('upload_dir');                
                unlink ($upload_path . 'files/' . $query1->file_docs);

                $this->response(TRUE);
            } else {
                $this->response(array($docs->get_validation_errors()));
            }
        }
    
    }

    function crew_doc_post()
    { 
        $response = array('status' => 'failed', 'message' => '');
         

        $this->load->model('document_model', 'dmodel');

        $rs = $this->dmodel->insert_docs($this->post('crew_id'));
        if ($rs) {
            $response['status']  = "success";
            $response['l'] = $this->db->last_query();
        }

        return $this->response($response);
    }

    function crew_doc_put()
    {   
        $docs = new Docs($this->put('id'));
        
        $this->response($this->_docs_save($docs, 'put'));
    }

    private function _docs_save($docs, $mode)
    {   
        $delete_file = false;
        $response = array('status' => 'failed', 'message' => '');

        $docs->docs_nos         = $this->{$mode}('docs_nos');        

        // if(!$this->{$mode}('date_issued')){
        //     $docs->date_issued = '';
        // } else {
        //     $docs->date_issued = date('Y-m-d', strtotime($this->{$mode}('date_issued'))); 
        // }

        // if(!$this->{$mode}('date_expired')){
        //     $docs->date_expired = '';
        // } else {
        //     $docs->date_expired = date('Y-m-d', strtotime($this->{$mode}('date_expired'))); 
        // }

        $docs->date_issued      = $this->{$mode}('date_issued');
        $docs->date_expired     = $this->{$mode}('date_expired'); 
        $docs->remarks          = $this->{$mode}('remarks');
        $docs->capacity         = $this->{$mode}('capacity');
        $docs->endorsement      = $this->{$mode}('endorsement');
        //$docs->position_id      = $this->{$mode}('position_id');
        $docs->encoding_modified        = $this->{$mode}('encoding_modified');

        if ($this->{$mode}('docs_file') != '' && $this->{$mode}('docs_file') != $docs->file_docs) {
            $delete_file = $docs->file_docs;
        }

        if($this->{$mode}('docs_file')) $docs->file_docs = $this->{$mode}('docs_file');
        if($this->{$mode}('docs_file')) $docs->uploading_modified = $this->{$mode}('uploading_modified');

        $id = $docs->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;

            if ($delete_file) {
                $this->load->config('dir');
                $upload_path = $this->config->item('upload_dir');                
                unlink ($upload_path . 'files/' . $delete_file);            
            } 

        }else {
            $response['message'] = $docs->get_validation_errors();
        }

        return $response;
    }

}