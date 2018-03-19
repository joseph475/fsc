<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Memo_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('memo_model', 'model');
        $this->load->library('memo');
        $this->load->library('memo_user');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function memos_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('memo' . serialize($this->_args));

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
    function memo_get()
    {
        $load = 'id';
        $id   = $this->get('id'); 
        
        $cache = Cache::get_instance();
        $memo = $cache::get('memo' . $id);

        if (!$memo) {            
            $memo = new Memo($id);   
            $memo->load($id, $load);  
            $cache::save('memo' . $memo->id, $memo, 1800);
        }
        
        $response = $memo->getData();   
                
        $this->response($response);
    }

    /**
    * Delete a record.
    * 
    */
    function memo_delete()
    {   
        // Get Memo to determine if user is allowed to delete.
        $memo = new Memo($this->get('id'));

        if (!$memo->hasData()) {
            // Throw a 404 if this Memo does not exist.
            $this->response(FALSE);
        } else {
            if ($memo->delete()) {

                $this->db->where('memo_id', $this->get('id'));
                $this->db->delete('manager_user'); 
                $this->response(TRUE);
            } else {
                $this->response(array($memo->get_validation_errors()));
            }
        }
    
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function memo_post()
    {        
        $memo = new Memo();

        $memo->date_created    = date('Y-m-d H:i:s');
        $memo->createdbypk     = $this->get_user()->user_id;
        $memo->date_modified   = date('Y-m-d H:i:s');
        $memo->modifiedbypk    = $this->get_user()->user_id;

        $delete_file = false;

        $pmemo  = $this->post('memo');
        $data   = $this->post('data');
        
        $response = array('status' => 'failed', 'message' => '');
        $memo->type         = $pmemo['type'];
        $memo->title        = $pmemo['title'];
        $memo->description  = $pmemo['description'];

        if ($data['upload_data']['file_name'] != '' && $data['upload_data']['file_name'] != $memo->filename) {
            $delete_file = $memo->filename;
        }

        $memo->filename = $data['upload_data']['file_name'];
        
        $id = $memo->save();
        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';   

            $this->db->delete('jd_manager_user', array('memo_id' => $id)); 
            if(isset($pmemo['user'])){
                $this->db->delete('jd_manager_user', array('memo_id' => $id)); 
                for ($i=0; $i < count($pmemo['user']) ; $i++) { 
                    $memo_user = new Memo_user();
                    $memo_user->memo_id          = $id;
                    $memo_user->user_id          = $pmemo['user'][$i];
                    $memo_user->save();
                }
            }                

            if ($delete_file) {
                $this->load->config('dir');
                $upload_path = $this->config->item('upload_dir');                
                unlink ($upload_path . 'files/' . $delete_file);            
            }       
        } else {
            $response['message'] = $memo->get_validation_errors();
        }

        $this->response($response);
    } 

    /**
     * Updates an Memo entry.
     * 
     * @return xml
     */
    function memo_put()
    {        
        $pmemo  = $this->put('memo');
        $data   = $this->put('data');

        $memo = new Memo($pmemo['id']);

        $memo->date_modified   = date('Y-m-d H:i:s');
        $memo->modifiedbypk    = $this->get_user()->user_id;

         $delete_file = false;
        
        $response = array('status' => 'failed', 'message' => '');
        $memo->type         = $pmemo['type'];
        $memo->title        = $pmemo['title'];
        $memo->description  = $pmemo['description'];

        if($data)  {
            if ($data['upload_data']['file_name'] != '' && $data['upload_data']['file_name'] != $memo->filename) {
                $delete_file = $memo->filename;
            }

            $memo->filename = $data['upload_data']['file_name'];
        }
        
        $id = $memo->save();
        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';   

            $this->db->delete('jd_manager_user', array('memo_id' => $id)); 
            if(isset($pmemo['user'])){
                for ($i=0; $i < count($pmemo['user']) ; $i++) { 
                    $memo_user = new Memo_user();
                    $memo_user->memo_id          = $id;
                    $memo_user->user_id          = $pmemo['user'][$i];
                    $memo_user->save();
                }
            }                

            if ($delete_file) {
                $this->load->config('dir');
                $upload_path = $this->config->item('upload_dir');                
                unlink ($upload_path . 'files/' . $delete_file);            
            }       
        } else {
            $response['message'] = $memo->get_validation_errors();
        }

        $this->response($response);
    }  

}