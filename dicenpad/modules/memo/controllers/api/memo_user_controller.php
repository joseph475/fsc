<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Memo_user_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('memo_user_model', 'model');
        $this->load->library('memo_user');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function memo_users_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('memo_user' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('options' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
     * Returns a single Crew.
     * 
     * @return xml
     */
    function memo_user_get()
    {
        $load = 'link_id';
        $arr = array();
        if ($this->get('memo_id') != '' && $this->get('user_id') != '') {
            $arr['manager_user.memo_id']  = $this->get('memo_id');     
            $arr['manager_user.user_id']  = $this->get('user_id');  
        } 
        
        $cache = Cache::get_instance();
        $memo_user = $cache::get('memo_user' . $arr['manager_user.user_id']);

        if (!$memo_user) {   
            $memo_user = new memo_user($arr);    
            $data = $this->model->get_memo($arr);  
            $memo_user->loadArray($data);      
            $cache::save('memo_user' . $memo_user->id, $memo_user, 1800);
        }
        
        $response = $memo_user->getData();   
                
        $this->response($response);
    }

    /**
    * Delete a record.
    * 
    */
    function memo_user_delete()
    {   
        // Get memo_user to determine if user is allowed to delete.
        $memo_user = new Memo_user($this->get('id'));

        if (!$memo_user->hasData()) {
            // Throw a 404 if this memo_user does not exist.
            $this->response(FALSE);
        } else {
            if ($memo_user->delete_id($this->get('id'))) {
                $this->response($this->db->last_query());
                $this->response(TRUE);
            } else {
                $this->response(array($memo_user->get_validation_errors()));
            }
        }
    
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function memo_user_post()
    {        
        $memo_user = new memo_user();

        $this->response($this->_memo_user_save($memo_user, 'post'));
    } 

    /**
     * Updates an memo_user entry.
     * 
     * @return xml
     */
    function memo_user_put()
    {        
        $memo_user = new memo_user($this->put('id'));

        $this->response($this->_memo_user_save($memo_user, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _memo_user_save($memo_user, $mode)
    {
        $delete_file = false;

        $response = array('status' => 'failed', 'message' => '');
        $memo_user->memo_id         = $this->{$mode}('memo_id');
        $memo_user->user_id         = $this->{$mode}('user_id');
        
        $id = $memo_user->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';           
        } else {
            $response['message'] = $memo_user->get_validation_errors();
        }

        return $response;
    }
}