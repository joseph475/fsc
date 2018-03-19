<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Candidate_model extends MY_Model
{
    private $_table_name = 'crew';
    private $_primary_key = 'crew_id';	

    protected $_allowed_filters = array(
        'status_id', 
        'vessel_id' => 'salary', 
        'effective_year' => 'salary', 
        'end_date' => 'onboard', 
        'position_id' => 'salary'
    );
    
    protected $_search_fields = array(
        'crew_id', 'fullname'
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
        $this->db->select('crew_id, fullname, hash, photo, crew.position_id, 
            position.position, position.code, salary.id as salary_id',
            FALSE
        );
        $this->db->join('position', 'position.id = crew.position_id', 'inner');              
        $this->db->join('salary', 'salary.position_id = position.id ', 'inner'); 
    }

    /**
     * Search function.
     *
     * @param mixed $key The field name/s.
     * @param mixed $value Value
     * @param int $limit
     * @param int $offset
     */
    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc')
    {   
        $this->db->where_in('jd_salary.effective_year', date('Y'));
        $this->db->where_in('status_id', array(1, 2, 5));
        $this->db->where("crew_id NOT IN 
                            (
                                SELECT crew_id FROM jd_schedule_j 
                                    LEFT JOIN jd_schedule_h ON jd_schedule_j.sched_id = jd_schedule_h.id
                                    WHERE jd_schedule_h.vessel_id = jd_salary.vessel_id AND isembark = 0
                                UNION
                                SELECT crew_id FROM jd_onboard 
                                    WHERE isdone = 0  and jd_onboard.vessel_id = jd_salary.vessel_id
                            )
                        ");   //AND end_date BETWEEN {$end_date}  

        return parent::fetch_all($limit = $limit, $offset = $offset, $sort = $sort, $order = $order);
    }
}