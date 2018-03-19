<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-03-25
 */

class Schedule_model extends MY_Model
{
    private $_table_name = 'schedule_h';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'vessel_id' => 'schedule_h', 
        'exclude_ids'
    );
    
    protected $_search_fields = array( 
        'jd_vessels.vessel_name', 'jd_schedule_h.control_nos'
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
        $this->db->select('schedule_h.id, schedule_h.terminal, schedule_h.arrival_time,  admin_company.company_id, schedule_h.control_nos, schedule_h.airport, schedule_h.visa, schedule_h.remarks, schedule_h.airfare1, 
                schedule_h.airfare2, schedule_h.is_approve, schedule_h.advised_agent, schedule_h.final_flight, schedule_h.final_dispatch,
                CONCAT("$ ", schedule_h.airfare1, " / Each Crew") as afre1, CONCAT("$ ", schedule_h.airfare2, " / Each Crew") as afre2, schedule_h.revision,
                CONCAT(prefix, " ", vessel_name) as vessel_name, schedule_h.vessel_id, principal.fullname AS principal, agent1.fullname AS handling_agent, 
                CONCAT(agent1.telno1, IF(agent1.telno2 <>"", CONCAT(", ", agent1.telno2), ""), IF(agent1.telno3 <>"", CONCAT(", ", agent1.telno3), "")) AS handling_agent_conctact,
                CONCAT(agent1.fax1, IF(agent1.fax2 <>"", CONCAT(", ", agent1.fax2), ""), IF(agent1.fax3 <>"", CONCAT(", ", agent1.fax3), "")) AS handling_agent_fax,
                agent1.email AS handling_agent_email, agent2.fullname AS charter_agent, vessels.code as vcode,
                CONCAT(agent2.telno1, IF(agent2.telno2 <>"" , CONCAT(", ", agent2.telno2), ""), IF(agent2.telno3 <>"", CONCAT(", ", agent1.telno3), "")) AS charter_agent_conctact,
                CONCAT(agent2.fax1, IF(agent2.fax2 <>"", CONCAT(", ", agent2.fax2), ""), IF(agent2.fax3 <>"", CONCAT(", ", agent2.fax3), "")) AS charter_agent_fax,
                agent2.email AS charter_agent_email, joining_port, prev_port, next_port, schedule_h.han_agent_id, schedule_h.cha_agent_id,
                DATE_FORMAT(jd_schedule_h.joining_date,"%m/%d/%Y") AS j_date, jd_schedule_h.joining_date, 
                DATE_FORMAT(jd_schedule_h.repat_date,"%m/%d/%Y") AS r_date, jd_schedule_h.repat_date,
                DATE_FORMAT(jd_schedule_h.srp_date,"%m/%d/%Y") AS s_date,
                DATE_FORMAT(jd_schedule_h.approval_date,"%m/%d/%Y") AS a_date,
                DATE_FORMAT(jd_schedule_h.joining_date,"%M %d, %Y") AS j_date1,
                DATE_FORMAT(jd_schedule_h.repat_date,"%M %d, %Y") AS r_date1, on_signers, off_signers,
                CONCAT((SELECT COUNT(*) FROM jd_schedule_j WHERE jd_schedule_j.sched_id = jd_schedule_h.id AND jd_schedule_j.isembark = 1 ), " Crew/s") AS onsigners,
                CONCAT((SELECT COUNT(*) FROM jd_schedule_r WHERE jd_schedule_r.sched_id = jd_schedule_r.id AND jd_schedule_r.isdisembark = 1 ), " Crew/s") AS offsigners
            ', FALSE
        );
        $this->db->join('vessels', 'schedule_h.vessel_id = vessels.id', 'left');
        $this->db->join('principal', 'principal.id = vessels.principal_id', 'left');  
        $this->db->join('agent AS agent1', 'agent1.id = schedule_h.han_agent_id', 'left');
        $this->db->join('agent AS agent2', 'agent2.id = schedule_h.cha_agent_id', 'left');
        $this->db->join('admin_company', 'admin_company.company_id = schedule_h.company_id', 'left');
    }
}