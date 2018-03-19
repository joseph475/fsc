<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Log_model extends MY_Model
{
    private $_table_name = 'admin_keys_history';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'user_id', 'fullname'
    );
    
    protected $_search_fields = array( 
        'jd_user.user_id', 'jd_user.last_name', 'jd_user.first_name'
    );

	// --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    public function _set_join()
    {
        $this->db->select($this->_table_name . '.*,CONCAT(last_name, ", ", first_name, " ", middle_name) 
            AS fullname, user.hash, user_about.photo, DATE_FORMAT(jd_admin_keys_history.created, "%b %d, %Y %h:%i %p") as created', FALSE
        );

        $this->db->join('user', 'admin_keys_history.user_id = user.user_id', 'left');  
        $this->db->join('user_about', 'user_about.user_id = user.user_id', 'left');  
    }
}