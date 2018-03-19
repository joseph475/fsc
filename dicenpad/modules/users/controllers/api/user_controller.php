<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_controller extends PTGI_rest_controller
{
    // Filters for sending out data via REST, we don't want to give out data like passwords and such.
    private $_user_response_filter = array('password');

	function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'model');
        $this->load->model('ref_model', 'rmodel');
        $this->load->library('User');
        $this->load->library('user/ref');
	}

    // --------------------------------------------------------------------

    /**
     * Returns Users when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *
     * Allowed 'data':
     *
     *    - user_id : filter by user ID
     *    - position_id   : filter by position ID
     *    - company_id    : filter by company ID
     *    - exclude_ids   : exclude user_id 
     * 
     * @return xml
     */
	function users_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache->get('users' . serialize($this->_args)); //$cache::get

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $results = $this->model->fetch($this->_args, true);

                //$response['l'] = $this->db->last_query();

                $users = $results->result();
                foreach ($users as $user) {                    
                    $e = new User();
                    $e->loadArray($user);
                    $response['data'][] = Rest_ResponseFilter::filter(
                        $e->getdata(), 
                        $this->_user_response_filter
                    );
                }
            }
            
            $cache->save('users' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    // --------------------------------------------------------------------

    /**
     * Returns a single User.
     * 
     * @return xml
     */
    function user_get()
    {
        $load = 'user_id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');            
        } elseif ($this->get('hash') != '') {
            $id   = $this->get('hash');
            $load = 'hash';
        } else {
            $id = $this->get_user()->user_id;
        }

        $cache = Cache::get_instance();
        $user = $cache->get('user' . $id);

        if (!$user) {            
            $user = new User();
            $user->load($id, $load);            
            $cache->save('user' . $user->user_id, $user, 1800);
        }

        $response = FALSE;
        
        if ($user->hasData()) {
            $response = Rest_ResponseFilter::filter($user->getData(), $this->_user_response_filter);
        }

        $this->response($response); 
    }

    // --------------------------------------------------------------------
    
    /**
     * Saves or updates a new User.
     * 
     * @return xml
     */
    // function user_post()
    // {
    //     $response = array('status' => 'failed', 'message' => '');
    
    //     $user = new User($this->get('id'));            

    //     $id = $user->save();

    //     if ($id) {
    //         $response['user_id'] = $id;
    //         $response['status']  = 'success';
    //         Cache::get_instance()->save('user' . $user->user_id);
    //     } else {
    //         $response['message'] = $user->get_validation_errors();
    //     }        

    //     $this->response($response, 201, 'xml');
    // }  

    /**
    * Delete a record.
    * 
    */
    function user_delete()
    {   
        // Get user to determine if user is allowed to delete.
        $user = new User($this->get('id'));

        if (!$user->hasData()) {
            // Throw a 404 if this user does not exist.
            $this->response(FALSE);
        } else {
            if ($user->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($user->get_validation_errors()));
            }
        }
    
    }

    // --------------------------------------------------------------------
    
    function user_post()
    {        
        $user = new User();

        $user->load($this->post('login'), 'login');  
        if($user->login){  
            $array = array('Username '=> array('is already exist!'));

            $response['status']  = 'error'; 
            $response['message'] = 'Username is already exist!';
            $this->response($response);
        }   

        $user->created      = date('Y-m-d H:i:s');
        $user->created_by   = $this->get_user()->user_id;
        $user->modified     = date('Y-m-d H:i:s');
        $user->modified_by  = $this->get_user()->user_id;

        $user->login        = $this->post('login');
        $user->password     = $this->post('password');

        $this->response($this->_user_save($user, 'post'));
    } 

    /**
     * Updates an user entry.
     * 
     * @return xml
     */
    function user_put()
    {        
        $user = new User($this->put('id'));

        $user->modified     = date('Y-m-d H:i:s');
        $user->modified_by  = $this->get_user()->user_id;
        $this->response($this->_user_save($user, 'put'));
    } 

    function user_pass_put()
    {        
        $user = new User($this->put('id'));
        $user->password     = md5($this->put('password'));
        $id = $user->save();

        if ($id) {
            $response['status']  = 'success';
        } else {
            $response['message'] = $user->get_validation_errors();
        }     

        $this->response($response);
    } 

    // --------------------------------------------------------------------   

    private function _user_save($user, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');   

        $user->email        = $this->{$mode}('email');
        $user->last_name    = $this->{$mode}('last_name');
        $user->first_name   = $this->{$mode}('first_name');
        $user->middle_name  = $this->{$mode}('middle_name');
        $user->inactive     = $this->{$mode}('inactive');

        $id = $user->save();

        if ($id) {
            $ref = new Ref();
            $ref->load($id, 'user_id');
            $ref->user_id           = $id;
            $ref->role_id           = $this->{$mode}('role_id');
            $ref->department_id     = $this->{$mode}('department_id');
            $ref->position_id       = $this->{$mode}('position_id');
            $ref->company_id        = $this->{$mode}('company_id');
            $ref->principal_id      = $this->{$mode}('principal_id');
            $ref->modified          = date('Y-m-d H:i:s');

            $ref->save();

            $response['user_id'] = $id;
            $response['status']  = 'success';
            $response['mode']    = $mode;
        } else {
            $response['message'] = $user->get_validation_errors();
        }    

        return $response;
    }
}