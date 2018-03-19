<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-16
 */

class Onboard_model extends MY_Model
{
    private $_table_name = 'onboard';
    private $_primary_key = 'onboard_id';	

    protected $_allowed_filters = array(
        'crew_id', 'vessel_id', 'status' => 'vessels', 'isdone', 'department_id' => 'position'
    );
    
    protected $_search_fields = array(
        'jd_onboard.crew_id', 'jd_crew.fullname'
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
        $this->db->select('
                    /** ONBOARD TABLE **/
                        jd_onboard.onboard_id, jd_onboard.crew_id, jd_onboard.salary_id, jd_onboard.remarks,
                        jd_onboard.vessel_id, jd_onboard.disembarked, jd_onboard.embarked, jd_onboard.position_id, 
                        jd_onboard.start_date, jd_onboard.end_date, jd_onboard.joining_port, jd_onboard.point_of_hire,
                        DATE_FORMAT(jd_onboard.start_date, "%m/%d/%Y" ) AS onboard_date, 
                        12 * (YEAR(jd_onboard.end_date) - YEAR(jd_onboard.start_date)) + (MONTH(jd_onboard.end_date) - MONTH(jd_onboard.start_date)) AS duration,

                    /** CREW TABLE **/
                        jd_crew.lastname, jd_crew.firstname, jd_crew.middlename,
                        jd_crew.fullname, jd_crew.birthdate, jd_crew.birthplace, jd_crew.birth_province, jd_crew.pres_address, jd_crew.gender, jd_crew.photo, jd_crew.hash, 
                        (SELECT course FROM jd_crew_education WHERE jd_crew_education.crew_id = jd_crew.crew_id ORDER BY YEAR DESC LIMIT 1) AS attainment, 
                    
                    /** POSITION TABLE **/
                        jd_position.alternate as position, jd_position.code, jd_position.department_id,
                    
                    /** PRINCIPAL TABLE **/
                        jd_principal.fullname AS principal, jd_principal.address AS prin_address, 
                        CONCAT(
                            jd_principal.telno1, 
                            IF(jd_principal.telno2 <> "", CONCAT(", ", jd_principal.telno2), ""), 
                            IF(jd_principal.telno3 <>"", CONCAT(", ", jd_principal.telno3), "")
                        ) AS principal_tel, 

                    /** DEPARTMENT TABLE **/
                        jd_department.option AS department, 
                        
                    /** VESSELS TABLE **/
                        CONCAT(jd_vessels.prefix, " ", jd_vessels.vessel_name) as vessel_name, jd_vessels.official_nos, jd_vessels.imo_nos, jd_vessels.gross, jd_vessels.flag_id, 
                        jd_vessels.classification, jd_vessels.e_year, jd_vessels.builder, jd_vessels.cba, jd_vessels.registered, 
                        jd_vessels.certi_validity as validity, jd_vessels.certi_validity_to as validity_to, jd_vessels.trade, , jd_vessels.hp,
                        jd_vessels.company_id,
                    /** VESSELS TYPE TABLE **/
                        jd_type.title AS vessel_type, 
                        jd_type_sub.title AS type, 
                        
                    /** FLAG TABLE **/
                        jd_flag.flag, 
                        
                    /** SALARY TABLE **/
                        jd_salary.basic_salary, jd_salary.nos_hours,  jd_salary.ot_fixed, jd_salary.other_benefits,
                        jd_salary.ot_hourly, jd_salary.s_allowance, jd_salary.t_allowance, 
                        CONCAT(jd_salary.nos_hours, " Hours per Week") AS hourly_work, 
                        CONCAT(jd_salary.leave_pay, " Per Month") leave_pay,
                        IF((jd_vessels.cba = "IBF-JSU/AMOSUP IMMAJ" OR jd_vessels.cba = "IBF-FJSU/AMOSUP IMMAJ") AND jd_position.division_id = 2, 
                            CONCAT("G.O.T. ", jd_salary.ot_fixed, " Per Month / Hourly Pay ", jd_salary.ot_hourly), 
                            CONCAT("F.O.T. ", jd_salary.ot_fixed, " Per Month") 
                        ) AS overtime,

                        IF(jd_vessels.cba = "NON CBA", 
                            "NON CBA", CONCAT(jd_vessels.cba, " / (Validity: ", DATE_FORMAT(jd_vessels.certi_validity, "%M %e, %Y") , " - ", DATE_FORMAT(jd_vessels.certi_validity_to, "%M %e, %Y"), ")") 
                            
                        ) AS bargain,

                    /** DOCUMENT AND CREW_DOCS TABLE **/
                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos, 
                        DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1), "%m/%d/%Y" ) AS seaman_expiry, 
                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 3 LIMIT 1) AS passport_nos, 
                        DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 3 LIMIT 1), "%m/%d/%Y" ) AS passport_expiry,
                        DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 4 LIMIT 1), "%m/%d/%Y" ) AS ph_license_expiry,
                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 4 LIMIT 1) AS ph_license_nos,                        

                        IF(jd_position.division_id = 1, 
                            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 7 LIMIT 1),
                            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 8 LIMIT 1)  
                        ) AS coc_nos, 
                        DATE_FORMAT(
                        IF(jd_position.division_id = 1, 
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 7 LIMIT 1),
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 8 LIMIT 1)  
                        ), "%m/%d/%Y") AS coc_expiry, 

                        CASE jd_vessels.flag_id 
                        WHEN 159 THEN /**PANAMA**/
                            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 15 LIMIT 1)
                        WHEN 130 THEN /**MARSHAL**/
                            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 27 LIMIT 1)
                        WHEN 117 THEN /**LIBERIA**/
                            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 31 LIMIT 1)
                        WHEN 15 THEN /**BAHAMAS**/
                            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 23 LIMIT 1)
                        WHEN 183 THEN /**SINGAPORE**/
                            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 19 LIMIT 1)
                        ELSE
                           "N/A"
                        END AS gmdss_nos,

                        CASE jd_vessels.flag_id 
                        WHEN 159 THEN /**PANAMA**/
                            DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 15 LIMIT 1), "%m/%d/%Y" )
                        WHEN 130 THEN /**MARSHAL**/
                            DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 27 LIMIT 1), "%m/%d/%Y" )
                        WHEN 117 THEN /**LIBERIA**/
                            DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 31 LIMIT 1), "%m/%d/%Y" )
                        WHEN 15 THEN /**MARSHAL**/
                            DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 23 LIMIT 1), "%m/%d/%Y" )
                        WHEN 183 THEN /**LIBERIA**/
                            DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 19 LIMIT 1), "%m/%d/%Y" )
                        ELSE
                           "N/A"
                        END AS gmdss_expiry,

                        CASE jd_position.division_id  
                        WHEN 1 THEN /**OFFICER**/
                            CASE jd_vessels.flag_id 
                            WHEN 159 THEN /**PANAMA**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 14 LIMIT 1)
                            WHEN 130 THEN /**MARSHAL**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 26 LIMIT 1)
                            WHEN 117 THEN /**LIBERIA**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 30 LIMIT 1)
                            WHEN 15 THEN /**LIBERIA**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 22 LIMIT 1)
                            WHEN 183 THEN /**SINGAPORE**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 18 LIMIT 1)
                            ELSE
                              "N/A"
                            END 
                        WHEN 2 THEN /**RATINGS**/
                            CASE jd_vessels.flag_id 
                            WHEN 159 THEN /**PANAMA**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 13 LIMIT 1)
                            WHEN 130 THEN /**MARSHAL**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 25 LIMIT 1)
                            WHEN 117 THEN /**LIBERIA**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 29 LIMIT 1)
                            ELSE
                                "N/A"
                            END 
                        END AS booklet_license,

                        CASE jd_position.division_id  
                        WHEN 1 THEN /**OFFICER**/
                            CASE jd_vessels.flag_id 
                            WHEN 159 THEN /**PANAMA**/
                                DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 14 LIMIT 1), "%m/%d/%Y" )
                            WHEN 130 THEN /**MARSHAL**/
                                DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 26 LIMIT 1), "%m/%d/%Y" )
                            WHEN 117 THEN /**LIBERIA**/
                                DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 30 LIMIT 1), "%m/%d/%Y" )
                            WHEN 15 THEN /**LIBERIA**/
                                DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 22 LIMIT 1), "%m/%d/%Y" )
                            WHEN 183 THEN /**SINGAPORE**/
                                DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 18 LIMIT 1), "%m/%d/%Y" )
                            ELSE
                                "N/A"
                            END 
                        WHEN 2 THEN /**RATINGS**/
                            CASE jd_vessels.flag_id 
                            WHEN 159 THEN /**PANAMA**/
                                DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 13 LIMIT 1), "%m/%d/%Y" )
                            WHEN 130 THEN /**MARSHAL**/
                                DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 25 LIMIT 1), "%m/%d/%Y" )
                            WHEN 117 THEN /**LIBERIA**/
                                DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 29 LIMIT 1), "%m/%d/%Y" )
                            ELSE
                                "N/A"
                            END 
                        END AS booklet_license_expiry,

                        DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 10 LIMIT 1), "%m/%d/%Y" ) AS us_expiry, 
                        DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 144 LIMIT 1), "%m/%d/%Y" ) AS yellow_expiry, 
                        DATE_FORMAT((SELECT date_issued FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 140 LIMIT 1), "%m/%d/%Y" ) AS medical_issued, 
                        DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 140 LIMIT 1), "%m/%d/%Y" ) AS medical_expiry, 
                        DATE_FORMAT((SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 11 LIMIT 1), "%m/%d/%Y" ) AS mcv_expiry, 
                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 2 LIMIT 1) AS src_nos 
            ',
            FALSE
        );

        $this->db->join('crew', 'crew.crew_id = onboard.crew_id', 'left');
        $this->db->join('position', 'position.id = crew.position_id', 'left');  
        $this->db->join('department', 'department.id = position.department_id', 'left');  
        $this->db->join('vessels', 'vessels.id = onboard.vessel_id', 'left');    
        $this->db->join('principal', 'principal.id = vessels.principal_id', 'left');    
        $this->db->join('salary', 'salary.id = onboard.salary_id', 'left');  
        $this->db->join('flag', 'flag.id = vessels.flag_id', 'left');     
        $this->db->join('type_sub', 'type_sub.id = vessels.type_id', 'left');
        $this->db->join('type', 'type.id = type_sub.type_id', 'left');
    }
    
    function update_prevboard_status($array = array(), $id)
    {
        $this->db->where($this->_primary_key, $id);

        return $this->db->update($this->_table_name, $array);
    }
}