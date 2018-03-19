<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-02-22
 */

class Bank_statement_model extends MY_Model
{
    private $_table_name = 'jd_bank_statement';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'crew_id'
    );

    protected $_search_fields = array(
        'fullname', 'middlename', 'lastname'
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
        $this->db->query('SET @crew_id = 0');
        $this->db->query('SET @num  = 1');

        $this->db->select($this->_table_name . '.*, DATE_FORMAT(date_issued, "%m/%d/%Y") AS di, crew.crew_id, 
            fullname, vessel_name, hash,
            position.code, position.position, CONCAT(jd_bank_statement.type, " ", jd_bank_statement.prefix) as nos,
            @num := IF(@crew_id = jd_bank_statement.crew_id, @num + 1, 1) AS row_number, 
            @crew_id := jd_bank_statement.crew_id AS dummy
            ',
            FALSE
        );

        $this->db->join('crew', 'crew.crew_id = bank_statement.crew_id', 'left');  
        $this->db->join('position', 'position.id = crew.position_id', 'left');  
        $this->db->join('vessels', 'vessels.id = bank_statement.vessel_id', 'left');  
    }

    

    public function get_by_bs($bs_id)
    {
        $this->db->order_by('id', 'asc');
        $bank_statement_detail = $this->get($bs_id, 'bs_id');

        $c = array();
        if ($bank_statement_detail) {
            if (!is_array($bank_statement_detail)) {
                $bank_statement_detail = array($bank_statement_detail);
            }
            
            foreach ($bank_statement_detail as $child) {
                $o_c = new Bank_statement_detail($child);
                $c[] = $o_c->getData();
            }

            return $c;
        }

        return FALSE;
    }

}