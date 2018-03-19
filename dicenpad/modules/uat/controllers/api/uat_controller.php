<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class uat_controller extends PTGI_rest_controller
{
	// --------------------------------------------------------------------	
	
	/**
	 * Return API key upon login.
	 *
	 * @param string username User login
	 * @param string password User password
	 *
	 * @return xml HTTP Status code and API KEY 
	 */	
	function login_post()
	{
		$valid = parent::_check_login($this->post('username'), $this->post('password'));

		$status = 401;

		if ($valid) {
			$this->load->model('users_model');			
			$user = $this->users_model->get_by_login($this->post('username'), $this->post('password'));

	        if (!$user) {
	        	$status = 401;
	        } else {
	        	$status = 200;
	        	$key    = $this->_generate_key($user['user_id']);
	        	$valid  = array('key' => $key);
	        }
		}

		$this->response($valid, $status, 'xml');
	}

	// --------------------------------------------------------------------
	
	/**
	 * Generate a key for the requesting user.
	 *
	 * @param string login user login
	 * @param int ctr variable to add
	 *
	 * @return int API Key
	 */
    private function _generate_key($login, $ctr = 0)
    {        
        $key = md5($ctr . $this->config->item('encryption_key') . $login);

        // Clear old keys.
        $this->db->where('user_id', $login);
        $this->db->delete($this->config->item('rest_keys_table'));

        // Check for duplicate keys.
        $this->db->where('key', $key);
        if ($this->db->get($this->config->item('rest_keys_table'))->num_rows() > 0) {
            $key = $this->_generate_key($login, ++$ctr);
        }

        // Insert to database.
        $this->db->insert($this->config->item('rest_keys_table'), 
            array(
                'user_id' 	=> $login,
                'key'     	=> $key,
                'created' 	=> time(),
                'ip_address'=> get_client_ip()
                )
        );

        // // Insert to database.
        // $this->db->insert($this->config->item('rest_history_table'), 
        //     array(
        //         'user_id' 	=> $login,
        //         'key'     	=> $key,
        //         'created' 	=> date('Y-m-d H:i:s'),
        //         'ip_address'=> get_client_ip()
        //         )
        // );
        return $key;
    }

	// --------------------------------------------------------------------
	
	/**
	 * Get role's access to resource
	 *	 
	 * @param string resource
	 * 
	 * @return xml
	 */
	function access_get()
	{	
		$this->response($this->acl->check_acl($this->get('resource'), $this->get_user()->login));			
	}
}