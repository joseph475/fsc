<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Position_model extends MY_Model
{
    private $_table_name = 'position';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'id' => 'department', 
        'id' => 'division', 
        'inactive',
        'department_id',
        'exclude_ids'
    );
    
    protected $_search_fields = array(
        'jd_position.id', 
        'jd_position.position', 
        'jd_position.code'
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
        $this->db->select($this->_table_name . '.*, department.option as department, 
            division.option as division',
            FALSE
        );

        $this->db->join('department', 'position.department_id = department.id', 'left');
        $this->db->join('division', 'division.id = position.division_id', 'left');        
    }
   
}