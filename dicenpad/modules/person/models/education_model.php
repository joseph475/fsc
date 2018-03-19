<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-16
 */

class Education_model extends MY_Model
{
    private $_table_name = 'person_education';
    private $_primary_key = 'id';	
    
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
        $this->db->select($this->_table_name . '.*, admin_options.option as education_level');
        $this->db->join('admin_options', 'admin_options.option_id = education_level_id', 'left');
        $this->db->order_by('admin_options.sort_order desc');
    }    
}