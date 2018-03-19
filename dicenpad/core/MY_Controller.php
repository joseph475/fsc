<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class that holds common implementations for frontend and admin.
 */
abstract class MY_Controller extends CI_Controller
{
    protected $user;

    // --------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct(); 
    
        // Loads module packages.
        $this->_load_module_packages();

        if (!$this->check_login_status()) {
        	throw new Exception('Please log-in.');
        }
                               
        // Load asset paths config.
        $this->load->config('dir');

        // Load directory helper.
        $this->load->helper('dir');

        $this->_define_current_module();

        // Determine what template to use.
        $this->setLayout();
                
        $this->_prep_view_data();
    }

    protected function _load_rest_client($key)
    {
        $this->load->config('rest');

        $this->load->library('rest', array(
            'server' => site_url('api'),
            // Load the api key retrieved after login.        
            'api_key' => array('key' => $key, 'name' => $this->config->item('rest_key_name'))
        ));         

    }

    // --------------------------------------------------------------------    
    
    /**
     * Have to remap the call to the controller in case there are some uri segments issues.
     */    
    function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            if (isset($params[0]) && $method == $params[0])
            {
                unset($params[0]);
            }
            
            return call_user_func_array(array($this, $method), $params);
        }
    }
    
    // --------------------------------------------------------------------    
    
    /**
     * Loads the dir of all modules that we have.
     */      
    function _load_module_packages()
    {
        $this->load->config('modules');
        
        $modules = $this->config->item('modules');
        
        foreach ($modules as $module)
        {
            $this->load->add_package_path(MODPATH . $module);
        }
    }   

    // --------------------------------------------------------------------

    /**
     * Start populating $this->view_data which will contain the parameters to be parsed
     * on the template.
     */
    private function _prep_view_data()
    {
        // add_js('libs/bootstrap/bootstrap.min.js');
        // add_js('libs/bootstrapx-clickover.js');

        // add_js('libs/jquery-ui-1.8.16.custom.min.js');
        // add_js('libs/jquery.validate.min.js');        

        // add_js('libs/date.js');    

        // add_js('libs/underscore.js');
        // add_js('libs/backbone-min.js');        
        // add_js('libs/enhance.min.js');

        add_js('libs/master-js.min.js');
        // add_js('libs/fileinput.jquery.js');
        // add_js('app.js');

        $this->view_data = array();
    }

    // --------------------------------------------------------------------
    
    /**
     * Determines which template to use depending on the current location.
     */
    private function _define_template()
    {
        // Load our custom layout library.
        $this->load->library('layout');
        $this->layout->setLayout('layout/base');
    }

    // --------------------------------------------------------------------

    /**
     * Returns the current module being accessed.
     * 
     * @return string.
     */
    public function get_current_module()
    {
        return $this->_current_module;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the current action being accessed.
     * 
     * @return string.
     */
    public function get_current_action()
    {
        return $this->_current_action;
    }  
    
    // --------------------------------------------------------------------

    /**
     * Override current_action.
     * 
     * @return string.
     */    
    public function set_current_action($action) {
        $this->_current_action = $action;
    }

    // --------------------------------------------------------------------

    /**
     * Initialize the pagination.
     *
     * @param array $params Array of configuration params
     */
    public function paginate($params = null)
    {
        $this->load->library('pagination');

        $config = $params;

        $config['per_page'] = isset($params['per_page']) ? $params['per_page'] : 10;                

        // Get the uri_segment for pagination, it's usually the segment after the current action.
        $uri_segment = array_keys($this->uri->segment_array(), $this->get_current_action());

        if (isset($uri_segment[0]) && !isset($params['uri_segment']))
        {
            $config['uri_segment'] = $uri_segment[0] + 1;
        }

        $config['full_tag_open'] = '<div class="pagination"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';        
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['page_query_string'] = TRUE;    

        $this->pagination->initialize($config);
    }

    // --------------------------------------------------------------------
    
    private function _define_current_module()
    {
        $this->_current_action = $this->router->method;

        $this->_current_module = $this->router->class;
    }

	// ------------------------------------------------------------------------

	/**
	 * Define what layout to use for controller
	 */
	abstract function setLayout();

	abstract function check_login_status();
}

// ------------------------------------------------------------------------

/**
 * Frontend specific 
 */
class Front_Controller extends MY_Controller
{	

    public function __construct()
    {
        parent::__construct(); 

        //$this->output->cache(CACHE_MINUTE);

    }
	// ------------------------------------------------------------------------
	
	function setLayout()
	{
		$this->layout->setLayout('layout/front');
	}

	function check_login_status()
	{
        if (!is_logged_in() && $this->uri->segment(1) != 'uat') {       
            $this->session->set_userdata('redirect_url', $this->uri->uri_string());
            redirect('uat/login');
        } elseif (is_logged_in() && $this->uri->segment(1) != 'logout') {            
            $this->_load_rest_client($this->session->userdata('api_key'));
        }

        return TRUE;
	}
}

// ------------------------------------------------------------------------

class Admin_Controller extends MY_Controller
{
	function check_login_status()
	{
        if (!is_logged_in() && $this->uri->segment(1) != 'uat' && !$this->is_admin()) {
        	//redirect('admin/login');
        }

        return TRUE;
	}

	// ------------------------------------------------------------------------

	function setLayout()
	{
		$this->layout->setLayout('layout/backend');
	}

	// ------------------------------------------------------------------------
	
    function is_admin() 
    {
        return false; //($this->user->group_id == 1);
    }		
}

require_once (APPPATH . 'libraries/REST_Controller.php');

// ------------------------------------------------------------------------

class PTGI_rest_controller extends REST_controller
{    
    private $_user = null;

    /**
     * When the client is logged in we can retrieve the credentials.
     * @return [type] [description]
     */
    public function get_user()
    {
        if (is_null($this->_user)) {
            $this->load->library('user');

            // Get the api key name variable set in the rest config file
            $api_key_variable = config_item('rest_key_name');

            // Work out the name of the SERVER entry based on config
            $key_name = 'HTTP_'.strtoupper(str_replace('-', '_', $api_key_variable));

            $key = isset($this->_args[$api_key_variable]) ? $this->_args[$api_key_variable] : $this->input->server($key_name);

            $this->db->where('key', $key);
            $user = $this->db->get($this->config->item('rest_keys_table'));

            $user = new User($user->row()->user_id);         

            $this->_user = (object) $user->getData();
        }

        return $this->_user;
    }

    protected function early_checks()
    {
        $this->_load_module_packages();

        // Disable keys for login
        if ($this->uri->segment(2) == 'uat') {
            $this->config->set_item('rest_enable_keys', FALSE);

            // Only get valid logins when a request is for authorization.
            $cache = Cache::get_instance();
            $id = md5('restlogins');
            $logins = $cache::get($id); 

            if (!$logins) {
                $this->load->model('users_model');
                $logins = $this->users_model->get_login_array();
                $cache::save($id, $logins);
            }

            $this->config->set_item('rest_valid_logins', $logins);
        }
    }
}
/* End of file */
/* Location: application/core */