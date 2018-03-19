<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Crew_model extends MY_Model
{
    private $_table_name = 'crew';
    private $_primary_key = 'crew_id';	

    protected $_allowed_filters = array(
        'crew_id','payroll_id','profit_id', 'lastname', 'firstname', 'position_id',
        'status_id', 'department_id' => 'position'
    );
    
    protected $_search_fields = array(
        'crew_id', 'fullname', 'lastname', 'firstname'
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
        $this->db->select($this->_table_name . '.*, 
            CONCAT(birthplace, ", ", birth_province) AS birthplace2, 
            CONCAT(benef_lname, ", ", benef_fname, " " , benef_mname) AS beneficiary,
                (SELECT IF(course="", vocational, course) FROM jd_crew_education 
                    WHERE jd_crew_education.crew_id = jd_crew.crew_id
                    AND jd_crew_education.highest = 1 AND (jd_crew_education.course <> "" OR jd_crew_education.vocational <> "")
                    ORDER BY id DESC LIMIT  1
                ) AS course, 
                (SELECT qualification FROM jd_crew_education 
                    WHERE jd_crew_education.crew_id = jd_crew.crew_id
                    AND jd_crew_education.highest = 1 AND (jd_crew_education.course <> "" OR jd_crew_education.vocational <> "")
                    ORDER BY id DESC LIMIT  1
                ) AS attainment, 
                (SELECT remarks FROM jd_crew_remarks 
                    WHERE jd_crew_remarks.crew_id = jd_crew.crew_id
                    ORDER BY id DESC LIMIT  1
                ) AS manager_comment, 
                (SELECT CONCAT(jd_vessels.prefix, " ", jd_vessels.vessel_name) as vessel_name FROM jd_onboard 
                    LEFT JOIN jd_vessels ON jd_vessels.id = jd_onboard.vessel_id
                    WHERE jd_onboard.crew_id = jd_crew.crew_id 
                    ORDER BY jd_onboard.end_date DESC LIMIT  1
                ) AS vessel_name, 
                (SELECT jd_vessels.id FROM jd_onboard 
                    LEFT JOIN jd_vessels ON jd_vessels.id = jd_onboard.vessel_id
                    WHERE jd_onboard.crew_id = jd_crew.crew_id 
                    ORDER BY jd_onboard.end_date DESC LIMIT  1
                ) AS vessel_id, 
                (SELECT jd_flag.flag FROM jd_onboard 
                    LEFT JOIN jd_vessels ON jd_vessels.id = jd_onboard.vessel_id
                    LEFT JOIN jd_flag ON jd_flag.id = jd_vessels.flag_id
                    WHERE jd_onboard.crew_id = jd_crew.crew_id AND jd_onboard.isdone = 0 
                    ORDER BY jd_onboard.end_date DESC LIMIT  1
                ) AS flag,
                (SELECT jd_flag.id FROM jd_onboard 
                    LEFT JOIN jd_vessels ON jd_vessels.id = jd_onboard.vessel_id
                    LEFT JOIN jd_flag ON jd_flag.id = jd_vessels.flag_id
                    WHERE jd_onboard.crew_id = jd_crew.crew_id AND jd_onboard.isdone = 0 
                    ORDER BY jd_onboard.end_date DESC LIMIT  1
                ) AS flag_id,
                position.position, position.code, position.department_id, position.division_id, department.option as department,
                division.option as division, admin_options.option as status, admin_options.option_group,
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos,
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 2 LIMIT 1) AS src_nos,
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 4 LIMIT 1) AS ph_license_nos,
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 7 LIMIT 1) AS marina_nos,
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 3 LIMIT 1) AS passport_nos, 
                (SELECT date_issued FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 140 LIMIT 1) AS date_issued, 
                (SELECT CONCAT(prefix, " ",vessel_name) FROM jd_schedule_j
                INNER JOIN jd_vessels ON jd_vessels.id = jd_schedule_j.vessel_id
                WHERE jd_schedule_j.isembark = 0 AND jd_schedule_j.crew_id = jd_crew.crew_id LIMIT 1) srp_vessel,
                (SELECT jd_schedule_h.control_nos FROM jd_schedule_j
                INNER JOIN jd_schedule_h ON jd_schedule_h.id = jd_schedule_j.sched_id
                WHERE jd_schedule_j.isembark = 0 AND jd_schedule_j.crew_id = jd_crew.crew_id 
                AND jd_schedule_j.crew_id NOT IN (SELECT crew_id FROM jd_onboard WHERE crew_id = jd_crew.crew_id AND isdone = 0) LIMIT 1) srp_reference,
                DATE_FORMAT((SELECT date_issued FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 140 LIMIT 1), "%m/%d/%Y" ) AS medical_issued  ',
            FALSE
        );

        $this->db->join('position', 'position.id = crew.position_id', 'left');
        $this->db->join('division', 'division.id = position.division_id', 'left');    
        $this->db->join('department', 'department.id = position.department_id', 'left');  
        $this->db->join('admin_options', 'admin_options.option_id = crew.status_id', 'left');  
    }

    public function get_by_array($array)
    {
        $this->db->where($array);
        $crew = $this->db->get('crew');
        if ($crew->num_rows() > 0) {
            $this->load->library('crew');
            $u = new Crew($crew->row()->crew_id);   
            return $u->getData();
        }

        return FALSE;
    }
   
}