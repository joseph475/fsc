<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Checklist_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('checklist_model', 'model');
        $this->load->library('checklist');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function checklists_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('checklist' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('checklist' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

     // --------------------------------------------------------------------    
    
    /**
    * Delete a record.
    * 
    */
    function checklist_delete()
    {   
        // Get checklist to determine if user is allowed to delete.
        $checklist = new checklist($this->get('id'));

        if (!$checklist->hasData()) {
            // Throw a 404 if this checklist does not exist.
            $this->response(FALSE);
        } else {
            if ($checklist->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($checklist->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an checklist entry.
     * 
     * @return xml
     */
    function checklist_post()
    {        
        $checklist = new checklist();

        $checklist->date_created    = date('Y-m-d H:i:s');
        $checklist->createdbypk     = $this->get_user()->user_id;
        $checklist->date_modified   = date('Y-m-d H:i:s');
        $checklist->modifiedbypk    = $this->get_user()->user_id;
        
        $this->response($this->_checklist_save($checklist, 'post'));
    } 

    // --------------------------------------------------------------------
    /**
     * Post an checkload entry.
     * 
     * @return xml
     */
    function checkload_post()
    {
        $response = array('status' => 'failed', 'message' => '');

        $rs = $this->model->insert_docs($this->post('type_id'));
        if ($rs) {
            $response['status']  = "success";
        }

        return $this->response($response);
    }

    /**
     * Updates an checklist entry.
     * 
     * @return xml
     */
    function checklist_put()
    {        
        $checklist = new Checklist($this->put('id'));

        $checklist->date_modified   = date('Y-m-d H:i:s');
        $checklist->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_checklist_save($checklist, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _checklist_save($checklist, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        
        $checklist->docs_id         = $this->{$mode}('docs_id');
        $checklist->sort_order      = $this->{$mode}('sort_order');
        $checklist->sub_order       = $this->{$mode}('sub_order');
        $checklist->officer_deck    = $this->{$mode}('officer_deck');
        $checklist->officer_engr    = $this->{$mode}('officer_engr');
        $checklist->officer_stwd    = $this->{$mode}('officer_stwd');
        $checklist->rating_deck     = $this->{$mode}('rating_deck');
        $checklist->rating_engr     = $this->{$mode}('rating_engr');
        $checklist->rating_stwd     = $this->{$mode}('rating_stwd');
        $checklist->published       = $this->{$mode}('published');
        
        $id = $checklist->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $checklist->get_validation_errors();
        }

        return $response;
    }
}