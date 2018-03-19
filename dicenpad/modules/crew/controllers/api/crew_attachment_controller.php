<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_attachment_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('attachment_model', 'model');
        $this->load->library('crew');
        $this->load->library('crew/attachment');
    }

    function crew_attachments_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('crew_attachments' . serialize($this->_args));

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
    * Get crew's education.
    * 
    */
    function crew_attachment_get()
    {
        $offset = null;
        $limit = 10;
        $sort = 'year';
        $order = 'desc';
        if ($this->get('limit') != '') {
            $limit  = $this->get('limit');            
            
            if ($this->get('offset') != '') {
                $offset = $this->get('offset');
            }
        }  

        $response['_count'] = $this->model->count_results($this->_args);

        $crew = new Crew();
        $crew->load($this->get('id'));

        $this->response($this->model->get_by_crew($crew->getData(), $limit, $offset, $sort, $order));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Delete a record.
    * 
    */
    function crew_attachment_delete()
    {   
        // Get crew to determine if user is allowed to delete.
        $attachment = new Attachment($this->get('id'));

        if (!$attachment->hasData()) {
            // Throw a 404 if this crew does not exist.
            $this->response(FALSE);
        } else {
            if ($attachment->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($attachment->get_validation_errors()));
            }
        }
    
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Create a record.
    * 
    */

    function crew_attachment_post()
    {
        $attachment = new Attachment();

        $attachment->date_created    = date('Y-m-d H:i:s');
        $attachment->createdbypk     = $this->get_user()->user_id;
        $attachment->date_modified   = date('Y-m-d H:i:s');
        $attachment->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_attachment_save($attachment, 'post'));
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Update a record.
    * 
    */

    function crew_attachment_put()
    {   
        $attachment = new Attachment($this->put('id'));

        $attachment->date_modified   = date('Y-m-d H:i:s');
        $attachment->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_attachment_save($attachment, 'put'));
    }

    private function _attachment_save($attachment, $mode)
    {
        $delete_file = FALSE;
        $response = array('status' => 'failed', 'message' => '');

        $attachment->crew_id              = $this->{$mode}('crew_id');
        $attachment->file_title           = $this->{$mode}('file_title');
        $attachment->file_desc            = $this->{$mode}('file_desc');

        if ($this->{$mode}('file_docs') != '' && $this->{$mode}('file_docs') != $attachment->file_docs) {
            $delete_file = $attachment->file_docs;
        }

        $attachment->file_docs = $this->{$mode}('file_docs');
        $id = $attachment->save();

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
            $response['message'] = $attachment->get_validation_errors();
        }

        return $response;
    }

}