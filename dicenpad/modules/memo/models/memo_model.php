<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-09-24
 */

class Memo_model extends MY_Model
{
    private $_table_name = 'manager_memo';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'id', 'createdbypk'
    );
    
    protected $_search_fields = array(
        'title', 'type'
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
        $this->db->select($this->_table_name .".*, DATE_FORMAT(date_created, '%M %d, %Y') AS dc", FALSE
        );

        //$this->db->join('user', 'user.user_id = manager_memo.createdbypk', 'INNER');   
    }
}