<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-02-22
 */

class Bank_statement_detail_model extends MY_Model
{
    private $_table_name = 'bank_statement_crew';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'bs_id'
    );

    protected $_search_fields = array(
        'fullname', 'middlename', 'lastname', 'firstname'
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
        $this->db->select($this->_table_name . '.*, DATE_FORMAT(date_terms, "%m/%d/%Y") AS dt',
            FALSE
        ); 
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
            
        // SELECT    id,
        //       crew_id,
        //       amount,
        //       TYPE,
        // ( 
        //         CASE TYPE 
        //           WHEN @curType 
        //           THEN @curRow := @curRow + 1 
        //           ELSE @curRow := 1 AND @curType := TYPE  END
        //       ) + 1 AS rank
        // FROM jd_bank_statement p,
        //       (SELECT @curRow := 0, @curType := '') r
        // ORDER BY crew_id, TYPE ASC;
    }
}