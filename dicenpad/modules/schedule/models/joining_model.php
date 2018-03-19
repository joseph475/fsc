<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-10
 */

class Joining_model extends MY_Model
{
    private $_table_name = 'schedule_j';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'sched_id'      => 'schedule_j', 
        'control_nos'   => 'schedule_h', 
        'isembark'      => 'schedule_j'
    );
    
    protected $_search_fields = array(
        'sched_id'
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
        $this->db->select($this->_table_name . '.*, crew.crew_id, crew.fullname,crew.birthdate, crew.hash, DATE_FORMAT(jd_schedule_j.start_date, "%m/%d/%Y") AS est_start_date,
                    DATE_FORMAT(DATE_ADD(jd_schedule_h.joining_date, INTERVAL (IF(duration_month=0, 0, duration_month)) MONTH ), "%m/%d/%Y") AS est_end_date,
                    CONCAT(duration_month, IF(duration_month >1, " Months", " Month" )) AS duration, 
                    position.code, position.position,
                    (SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS sirb,
                    (SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 3 LIMIT 1) AS passport_expired,
					 (select docs_nos from jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 3) AS passport,
					 (SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1) AS sirbno,
					 
                    IF(jd_position.division_id = 1, 
                    (SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 7 LIMIT 1), 
                    (SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 8 LIMIT 1) 
                    ) AS coc_expired,
                    (SELECT date_issued FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 140 LIMIT 1) AS medical_issued,
                    onboard.pdos_nos, onboard.pdos_date, onboard.oec_nos, onboard.month_duration, onboard.point_of_hire, onboard.trade, onboard.joining_port,
                    schedule_h.control_nos, 
                    (SELECT jd_schedule_h.control_nos FROM jd_onboard 
                    INNER JOIN jd_schedule_r ON jd_schedule_r.onboard_id = jd_onboard.onboard_id 
                    INNER JOIN jd_schedule_h ON jd_schedule_h.id = jd_schedule_r.sched_id
                    WHERE jd_onboard.onboard_id =  jd_schedule_j.onboard_id AND jd_schedule_r.isdisembark = 1 
                    LIMIT 1) control_nos2
                      ', FALSE
        );

        $this->db->join('crew', 'crew.crew_id = schedule_j.crew_id', 'INNER'); 
        $this->db->join('schedule_h', 'schedule_h.id = schedule_j.sched_id', 'INNER');
        $this->db->join('position', 'position.id = schedule_j.position_id', 'INNER');  
        $this->db->join('onboard', 'onboard.onboard_id = schedule_j.onboard_id', 'LEFT'); 
        $this->db->join('schedule_r', 'onboard.onboard_id = schedule_r.onboard_id', 'LEFT');  
    }

   /**
    *
    *  Fetch all rows.
    *  @return obj
    */
    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc')
    {
        $this->_set_join();

        if (is_null($sort)) {
            $this->db->order_by($this->_table_name . '.' . $this->_primary_key . ' ' . $order);
        } else {
            $this->db->order_by($sort . ' ' . $order);
        }        

        $this->db->order_by('fullname ');

        return $this->db->get($this->_table_name, $limit, $offset);
    }

    function remove($key)
    {
        if (!is_array($key))
        {
            $key = array($key);
        }
        
        $field = $this->_primary_key;        
        
        $this->db->limit(1);
        $this->db->where_in($this->_table_name . '.' . $field, $key);
        $obj = $this->db->get($this->_table_name);        

        if ($obj->num_rows > 0)
        {
            $rs = null;
            if ($obj->num_rows == 1)
            {   // row() returns an object which holds data from a single row.
                $rs = $obj->row();
            }
            else
            {
                $data = array();
                foreach ($obj->result() as $row){
                    $data[] = $row;  
                }  

                $rs = array_shift($data);
            }

            $this->load->library('crew');
            $crew = new Crew($rs->crew_id); 
            $crew->status_id    = 2;
            $crew->save();

            return $this->db->delete('onboard', array('crew_id' => $rs->crew_id, 'sched_id' => $rs->sched_id, 'vessel_id' => $rs->vessel_id));
        } 

        return FALSE;

        // $this->db->where_in($this->_table_name . '.' . $this->_primary_key, $key);
        // return $this->db->delete($this->_table_name);
    }

    // --------------------------------------------------------------------
    
    /**
     * Get by username and password.
     *      
     * @return array
     */    
    public function get_by_repat($crew_id, $onboard_id)
    {
        $this->db->where('crew_id', $crew_id);
        $this->db->where('onboard_id', $onboard_id);
        $schedule_r = $this->db->get('schedule_r');

        if ($schedule_r->num_rows() > 0) {
            $this->load->library('sched/repat');
            $r = new Repat($schedule_r->row()->id);            
            return $r->getData();
        }

        return FALSE;
    }

    // --------------------------------------------------------------------
    
    /**
     * Get by username and password.
     *      
     * @return array
     */    
    public function get_by_promote($crew_id, $onboard_id)
    {
        $this->db->where('crew_id', $crew_id);
        $this->db->where('onboard_id', $onboard_id);
        $schedule_p = $this->db->get('schedule_p');

        if ($schedule_p->num_rows() > 0) {
            $this->load->library('sched/promotion');
            $p = new Promotion($schedule_p->row()->id);            
            return $p->getData();
        }

        return FALSE;
    }
}