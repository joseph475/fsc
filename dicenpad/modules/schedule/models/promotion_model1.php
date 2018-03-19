<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-10
 */

class Promotion_model extends MY_Model
{
    private $_table_name = 'schedule_p';
    private $_primary_key = 'id';   

    protected $_allowed_filters = array(
        'sched_id'
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
        $this->db->select($this->_table_name . '.*, crew.crew_id, crew.hash, crew.photo, crew.fullname, 
                        DATE_FORMAT(DATE_ADD(jd_schedule_h.joining_date, INTERVAL (IF(duration_month=0, 0, duration_month)) MONTH ), "%m/%d/%Y") AS est_end_date, 
                        pos1.code as old_pos, pos2.code as new_pos, pos2.position as new_position, 
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 1 ) AS sirb, 
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 3 ) AS passport_expired, 
                        IF(pos2.division_id = 1, 
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 7 ),
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 8 )  
                        ) AS coc_expired, 
                        (SELECT date_issued FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 140 ) AS medical_issued,
                        IF(jd_schedule_p.ispromoted = 1, onb2.oec_nos, jd_onboard.oec_nos) oec_nos,
                        IF(jd_schedule_p.ispromoted = 1, onb2.pdos_nos, jd_onboard.pdos_nos) pdos_nos,
                        IF(jd_schedule_p.ispromoted = 1, onb2.pdos_date, jd_onboard.pdos_date) pdos_date,
                        onboard.joining_port, onb2.joining_port joining_port2,
                        onboard.reference, duration_month, jd_onboard.start_date,
                        DATE_FORMAT(jd_onboard.extension_date, "%m/%d/%Y") AS extension_date,
                        DATE_FORMAT(DATE_ADD(jd_onboard.end_date, INTERVAL duration_month MONTH),"%m/%d/%Y") AS end_date,
                        jd_onboard.duration, 
                        IF(duration_month = 0, "Promotion Only", CONCAT(duration_month, IF(duration_month > 1, " Months", " Month"))) AS extension,
                        salary.id AS salary_id, schedule_h.control_nos',
                        FALSE);

        $this->db->join('crew', 'crew.crew_id = schedule_p.crew_id', 'inner');
        $this->db->join('schedule_h', 'schedule_h.id = schedule_p.sched_id', 'left');   
        $this->db->join('onboard', 'onboard.onboard_id = schedule_p.onboard_id', 'left'); 
        $this->db->join('onboard as onb2', 'onb2.onboard_id = schedule_p.onboard_id2', 'left');  
        $this->db->join('salary', 'salary.id = schedule_p.salary_id', 'inner');   
        $this->db->join('position as pos1', 'pos1.id = schedule_p.position_old', 'left'); 
        $this->db->join('position as pos2', 'pos2.id = schedule_p.position_new', 'left');   
    }

    function remove($key)
    {
        if (!is_array($key))
        {
            $key = array($key);
        }

        $this->load->library('sched/promotion');
        $promotion = new Promotion($key); 
        $promotion->load($key, $this->_primary_key);  

        if($promotion->id){

            $this->load->library('Onboard2');
            $onboard = new Onboard2($promotion->onboard_id); 

            $onboard->remarks              = '';    
            $onboard->extension_date       = '0000-00-00';
            $onboard->disembarked          = '0000-00-00';
            $onboard->isdone               = 0;
            $onboard->save();

            // ------- UPDATE CREW TAG STATUS AS ONBOARD
            $this->load->library('crew');
            $crew = new Crew($onboard->crew_id); 
            $crew->position_id      = $promotion->position_old;  
            $crew->position_old     = $promotion->old_pos;
            $crew->date_modified    = date('Y-m-d H:i:s');
            $crew->save();

            $onboard = new Onboard2($promotion->onboard_id2); 

            if (!$onboard->hasData()) {
                // Throw a 404 if this onboard does not exist.
                $this->response(FALSE);
            } else {
                $onboard->delete();
            }
        }
        
        return parent::delete($promotion->id);       
    }  
}