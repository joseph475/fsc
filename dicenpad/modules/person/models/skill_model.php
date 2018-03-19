<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-13
 */

class Skill_model extends MY_Model
{
    private $_table_name = 'person_skill';
    private $_primary_key = 'id';	
    
	// --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }
 
    public function  _set_join()
    {
        $this->db->select($this->_table_name . '.*, a.option as skill_type, b.option as proficiency');
        $this->db->join('admin_options a', 'a.option_id = skill_type_id', 'left');
        $this->db->join('admin_options b', 'b.option_id = proficiency_id', 'left');
    }   
}