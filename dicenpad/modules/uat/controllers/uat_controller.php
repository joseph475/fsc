<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Uat_controller extends Front_Controller
{
	// --------------------------------------------------------------------	
	
	
	function login()	
	{	
		//$this->output->enable_profiler(TRUE);
		if (is_logged_in()) redirect('admin');

		add_js('modules/uat/login.js');
		$this->layout->view('login');
	}

	// --------------------------------------------------------------------	

	function logout()
	{
		$this->session->sess_destroy();
		redirect('uat/login');
	}

	// --------------------------------------------------------------------	

	function get_redirect_url()
	{
		$redirect_url = ($this->session->userdata('redirect_url'))? $this->session->userdata('redirect_url') : 'admin';
		$this->load->view('ajax', array('html' => $redirect_url));
	}

	// --------------------------------------------------------------------	

	function client_login()
	{
		
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));

		$this->_load_rest_client($username, $password);
		// Request keys from the API server.
		$valid = $this->rest->post('uat/login', array('username' => $username, 'password' => $password));	

		//dbug($valid);

		if ($this->rest->status() == 200) {
			// Get user id			
			$user = $this->rest->get('user', array($this->config->item('rest_key_name') => $valid['key']));

			$this->session->set_userdata('user_id', $user['user_id']);
            $this->session->set_userdata('role_id',$user['role_id']);
			$this->session->set_userdata('api_key', $valid['key']);
			$this->session->set_userdata('logged_in', TRUE);

			// Insert to database.
	        $this->db->insert($this->config->item('rest_history_table'), 
	            array(
	                'user_id' 	=> $user['user_id'],
	                'key'     	=> $valid['key'],
	                'created' 	=> date('Y-m-d H:i:s'),
	                'ip_address'=> get_client_ip()
	                )
	        );
		}

		$this->load->view('ajax', array('json' => array('status' => $this->rest->status())));
	}
}