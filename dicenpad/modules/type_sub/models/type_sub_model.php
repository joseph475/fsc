<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-05-8
 */

class Type_sub_model extends MY_Model
{
    private $_table_name = 'type_sub';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'code', 'type_id', 'published'
    );
    
    protected $_search_fields = array(
        'jd_type_sub.code', 'jd_type_sub.title'
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
        $this->db->select($this->_table_name . '.*, type.title as type',

            FALSE
        );

        $this->db->join('type', 'type.id = type_sub.type_id', 'inner');
    }
   
}