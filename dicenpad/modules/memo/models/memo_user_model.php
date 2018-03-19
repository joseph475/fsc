<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-09-24
 */

class Memo_user_model extends MY_Model
{
    private $_table_name = 'manager_user';
    private $_primary_key = 'link_id';	

    protected $_allowed_filters = array(
        'memo_id', 'user_id'
    );
    
    protected $_search_fields = array(
        'jd_manager_memo.title'
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
        $this->db->select("manager_memo.id, manager_memo.type, manager_memo.title, manager_memo.description, manager_memo.filename,  
                        manager_memo.createdbypk, manager_memo.date_created, manager_user.user_id, link_id,
                        CONCAT(jd_user.last_name, ', ', jd_user.first_name, ' ', jd_user.middle_name) as user,
                        DATE_FORMAT(date_created, '%M %d, %Y') AS dc, 
                        CONCAT(jd_user.last_name, ', ', jd_user.first_name, ' ', jd_user.middle_name) as author,
                        (SELECT GROUP_CONCAT(jd_user.first_name, ' ', jd_user.last_name) FROM jd_manager_user as t2
                        INNER JOIN jd_user ON jd_user.user_id = t2.user_id 
                        WHERE t2.memo_id = jd_manager_user.memo_id AND 
                        t2.user_id <> jd_manager_user.user_id) AS users ",  FALSE
        );
 
        $this->db->join('manager_memo', 'manager_memo.id = manager_user.memo_id', 'INNER');  
        $this->db->join('user', 'user.user_id = manager_memo.createdbypk', 'INNER');     
    }

    function delete_mid($key)
    {
        $this->db->where_in('memo_id', $key);
        return $this->db->delete($this->_table_name);
    }

    function get_memo($key, $field = '')
    {
        $this->_set_join();

        if (!is_array($key))
        {
            $key = array ($key);
        }
        
        $this->db->where($key);

        $obj = $this->db->get($this->_table_name);

        if ($obj->num_rows > 0)
        {
            if ($obj->num_rows == 1)
            {   // row() returns an object which holds data from a single row.
                return $obj->row();
            }
            else
            {
                $obj = $obj->result();
                return $obj;
            }
        } 
        else
        {
            return FALSE;
        }
    }
}