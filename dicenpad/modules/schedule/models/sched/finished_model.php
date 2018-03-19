<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Finished_model extends MY_Model
{
    private $_table_name = 'crew';
    private $_primary_key = 'crew_id';	

    protected $_allowed_filters = array(
        'vessel_id' => 'onboard', 
        'end_date' => 'onboard'
    );
    
    protected $_search_fields = array(
        'jd_onboard.crew_id', 'fullname'
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
        $this->db->select('crew.crew_id, fullname, position.position, position.code, HASH, onboard.remarks, crew.position_id, onboard_id,
            12 * (YEAR(jd_onboard.end_date) - YEAR(jd_onboard.original_date)) + (MONTH(jd_onboard.end_date) - MONTH(jd_onboard.original_date)) AS duration 
             ',
            FALSE
        );

        $this->db->join('onboard', 'crew.crew_id = onboard.crew_id', 'inner');
        $this->db->join('position', 'position.id = onboard.position_id', 'inner');   
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
        $this->db->where('status_id', 3);
        $this->db->where('isdone', 0);
        $this->db->where("jd_onboard.crew_id  NOT IN 
                            (
                                SELECT crew_id FROM jd_schedule_r
                                INNER JOIN jd_schedule_h ON jd_schedule_r.sched_id = jd_schedule_h.id
                                WHERE jd_schedule_h.vessel_id = jd_onboard.vessel_id AND isdisembark = 0                                
                            )
                        ");   
                        // UNION SELECT crew_id FROM jd_onboard AS co
                        // INNER JOIN jd_schedule_h ON co.sched_id = jd_schedule_h.id 
                        // WHERE co.sched_id = jd_onboard.sched_id

        return parent::fetch_all($limit = $limit, $offset = $offset, 'jd_position.sort_order, fullname', $order = $order);
    }
   
}