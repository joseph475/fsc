<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Top_model extends MY_Model
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
            AS fullname, user.hash, jd_user_about.photo, 
            (SELECT DATE_FORMAT(created, "%b %d, %Y %h:%i %p") FROM jd_admin_keys_history 
            WHERE user_id = part1.user_id 
            ORDER BY created DESC LIMIT 1 
            ) AS last_login, 
            COUNT(part1.user_id) AS total ', FALSE
        );
        $this->db->from($this->_table_name . ' as part1');

        $this->db->join('user', 'part1.user_id = user.user_id', 'left');  
        $this->db->join('user_about', 'user_about.user_id = user.user_id', 'left');  
    }

     /**
    *
    *  Fetch all rows.
    *  @return obj
    */
    function fetch_all($limit = 5, $offset = null, $sort = null, $order = 'desc')
    {
        $this->_set_join();

        if (is_null($sort)) {
            $this->db->order_by($this->_primary_key . ' ' . $order);
        } else {
            $this->db->order_by($sort . ' ' . $order);
        }        

        $this->db->group_by('part1.user_id');
        $data = $this->db->get($this->_table_name, $limit, $offset);
        return $data;
    }
}