<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-12
 */

class Assign_position_model extends MY_Model
{
    private $_table_name = 'salary';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'vessel_id' => 'salary',
        'effective_year' => 'salary', 
        'end_date' => 'onboard'
    );
    
    protected $_search_fields = array(
        'position_id', 'jd_position.code', 'jd_position.position'
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
        $this->db->distinct();
        $this->db->select("salary.id as salary_id, position_id, position.code, position.position, position.sort_order",
            FALSE
        );
        $this->db->join('position', 'position.id = salary.position_id', 'INNER');   
    }

    /**
     * Search function.
     *
     * @param mixed $key The field name/s.
     * @param mixed $value Value
     * @param int $limit
     * @param int $offset
     */
    function search($key, $value = null, $limit = null, $offset = null, $sort = null, $order ='desc')
    {   
        if ($key == '') {
            return $this->fetch_all($limit, $offset, $sort, $order);
        }

        if (!is_array($key))
        {
            $key = array ($key);
        }

        $limit = 1000;

        $vessel_id = ($key[0]['field'] == 'salary.vessel_id')? $key[0]['value'] : '';
        $end_date = ($key[1]['field'] == 'onboard.end_date')? $key[1]['value'] : '';

        $this->db->where("jd_salary.vessel_id", $vessel_id);
        $this->db->where("jd_salary.published", 1);
        $this->db->where_in('jd_salary.effective_year', date('Y'));
        // $this->db->where("jd_salary.id NOT IN (SELECT DISTINCT salary_id FROM jd_onboard 
        //                 WHERE jd_onboard.vessel_id = {$vessel_id} AND DATE_FORMAT(end_date,'%Y-%m') 
        //                 BETWEEN '{$end_date}' AND '{$end_date}' AND isdone = 0)");           
        
        return $this->fetch_all($limit, $offset, $sort, $order);
    }

    /**
    *
    *  Fetch all rows.
    *  @return obj
    */
    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc')
    {
        $this->_set_join();      

        $this->db->order_by('jd_position.sort_order asc');
        $this->db->order_by('position_id asc');

        return $this->db->get($this->_table_name, $limit, $offset);
    }
   
}