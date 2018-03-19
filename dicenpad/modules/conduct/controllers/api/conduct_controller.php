<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Conduct_controller extends PTGI_rest_controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('conduct_model', 'model');
        $this->load->library('conduct');
    }

    /**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function conducts_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('conduct' . serialize($this->_args));

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
    * Delete a record.
    * 
    */
    function conduct_delete()
    {   
        // Get conduct to determine if user is allowed to delete.
        $conduct = new Conduct($this->get('id'));
        if (!$conduct->hasData()) {
            // Throw a 404 if this conduct does not exist.
            $this->response(FALSE);
        } else {
            if ($conduct->delete()) {                
                $this->response(TRUE);
            } else {
                $this->response(array($conduct->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function conduct_post()
    {        
        $conduct = new conduct();

        $conduct->date_created    = date('Y-m-d H:i:s');
        $conduct->createdbypk     = $this->get_user()->user_id;
        $conduct->date_modified   = date('Y-m-d H:i:s');
        $conduct->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_conduct_save($conduct, 'post'));
    } 

    /**
     * Updates an conduct entry.
     * 
     * @return xml
     */
    function conduct_put()
    {        
        $conduct = new conduct($this->put('id'));

        $conduct->date_modified   = date('Y-m-d H:i:s');
        $conduct->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_conduct_save($conduct, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _conduct_save($conduct, $mode)
    {
        $delete_file = false;
        $response = array('status' => 'failed', 'message' => '');

        $conduct->vessel_id     = $this->{$mode}('vessel_id');
        $conduct->crew_id       = $this->{$mode}('crew_id');
        $conduct->remarks       = $this->{$mode}('remarks');
        $conduct->date_receive  = date('Y-m-d', strtotime($this->{$mode}('date_receive')));
        $conduct->date_year     = date('Y', strtotime($this->{$mode}('date_receive')));
        $conduct->published     = $this->{$mode}('published');
        $conduct->start_date    = date('Y-m-d', strtotime($this->{$mode}('start_date')));
        $conduct->end_date      = date('Y-m-d', strtotime($this->{$mode}('end_date')));

        if ($this->{$mode}('file_docs') != '' && $this->{$mode}('file_docs') != $conduct->file_docs) {
            $delete_file = $conduct->file_docs;
        }

        $conduct->file_docs = $this->{$mode}('file_docs');
        
        $id = $conduct->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success'; 
            $response['mode']  = $mode;

            if ($delete_file) {
                $this->load->config('dir');
                $upload_path = $this->config->item('upload_dir');                
                unlink ($upload_path . 'files/' . $delete_file);            
            }            
        } else {
            $response['message'] = $conduct->get_validation_errors();
        }

        return $response;
    }
}