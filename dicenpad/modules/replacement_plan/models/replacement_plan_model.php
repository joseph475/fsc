<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-16
 */

class Replacement_plan_model extends MY_Model
{
    private $_table_name = 'schedule_h';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'joining_date', 'repat_date'
    );
    
    protected $_search_fields = array(
        'vessel_name', 'joining_date'
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
        $this->db->select('control_nos, joining_date, DATE_FORMAT(joining_date, "%b-%d") as jdate, repat_date, vessel_name, joining_port, airport, visa, 
                            (
                            SELECT GROUP_CONCAT(pos) AS embark FROM
                                (SELECT CONCAT(" ", CODE, " (", COUNT(position_id), ")") AS pos, sched_id FROM jd_schedule_j 
                                LEFT JOIN jd_position ON jd_position.id = jd_schedule_j.position_id
                                GROUP BY position_id) AS a
                                WHERE a.sched_id = jd_schedule_h.id 
                            ) AS embark,
                            (
                            SELECT GROUP_CONCAT(pos) AS disembark FROM
                                (SELECT CONCAT(CODE, " (", COUNT(position_id), ")") AS pos, sched_id FROM jd_schedule_r 
                                LEFT JOIN jd_crew ON jd_crew.crew_id = jd_schedule_r.crew_id
                                LEFT JOIN jd_position ON jd_position.id = jd_crew .position_id
                                GROUP BY position_id) AS b
                                WHERE b.sched_id =  jd_schedule_h.id 
                            ) AS disembark', 
            FALSE
        );

        
        $this->db->join('vessels', 'vessels.id = schedule_h.vessel_id', 'left');    
    }

    public function search($key, $value = null, $limit = null, $offset = null, $sort = 'joining_date', $order ='desc')
    {
        if ($key == '') {
            return $this->fetch_all($limit, $offset, $sort, $order);
        }

        if (!is_array($key))
        {
            $key = array ($key);
        }

        $type = 'eq';

        foreach ($key as $field)
        {
            if (is_array($field)) {                
                if (isset($field['type']) && $field['type'] != '') {
                    $type = $field['type'];
                }

                if (isset($field['value'])) {
                    $value = $field['value'];
                }

                $field = $field['field'];
            }

            switch ($type) {
                case 'eq':
                    $this->db->where("DATE_FORMAT(joining_date, '%e-%Y') = '{$value}'");                 
                    break;
                case 'custom':                    
                    $this->db->where($value, null, FALSE); 
                    break;
            }                
        }
        
        return $this->fetch_all($limit, $offset, $sort, $order);
    }
    
}