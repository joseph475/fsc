<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-03-11
 */

class Salary_model extends MY_Model
{
    private $_table_name = 'salary';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'id', 'vessel_id', 'position_id', 'effective_year'
    );
    
    protected $_search_fields = array(
        //'parent.vessel_id'
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
        $this->db->select($this->_table_name . '.*, position.code, position.position, 
            position.sort_order, vessels.vessel_name, position.division_id,
            /** SALARY TABLE **/
            CONCAT(jd_salary.nos_hours, " Hours per Week") AS hourly_work, 
            CONCAT(jd_salary.leave_pay, " Per Month"),
            IF((jd_vessels_validity.cba = "IBF-JSU/AMOSUP IMMAJ" OR jd_vessels_validity.cba = "IBF-FKSU/AMOSUP KSA") AND jd_position.division_id = 2, 
                CONCAT("G.O.T. ", jd_salary.ot_fixed, " Per Month / Hourly Pay ", jd_salary.ot_hourly),
                CONCAT("F.O.T. ", jd_salary.ot_fixed, " Per Month") 
            ) AS overtime,
            IF(jd_vessels_validity.cba = "NON CBA", 
                "NON CBA", CONCAT(jd_vessels_validity.cba," / (Validity: ", DATE_FORMAT(STR_TO_DATE(jd_vessels_validity.validity_from, "%m/%d/%Y"), "%M %e, %Y") , " - ", DATE_FORMAT(STR_TO_DATE(jd_vessels_validity.validity_to, "%m/%d/%Y"), "%M %e, %Y"), ")")
            ) AS bargain,
            , jd_vessels_validity.validity_from, jd_vessels_validity.validity_to, jd_vessels_validity.cba,jd_salary.other_benefits AS other_benefits,jd_salary.s_allowance AS s_allowance
            ',
            FALSE
        );

        $this->db->join('position', 'salary.position_id = position.id', 'inner');
        $this->db->join('vessels', 'salary.vessel_id = vessels.id', 'inner');  
        $this->db->join('vessels_validity', 'vessels_validity.vessel_id = salary.vessel_id AND jd_vessels_validity.validity_year = jd_salary.effective_year', 'left');    
    }
}

// IF(jd_vessels.cba = "IBF-JSU/AMOSUP IMMAJ" AND jd_position.division_id = 2, 
// CONCAT("G.O.T. ", jd_salary.ot_fixed, " Per Month / Hourly Pay ", jd_salary.ot_hourly), 
// CONCAT("F.O.T. ", jd_salary.ot_fixed, " Per Month") 
// ) AS overtime,
// IF(jd_vessels.cba = "IBF-JSU/AMOSUP IMMAJ", 
// CONCAT("IBF-JSU/AMOSUP IMMAJ / (Validity: ", DATE_FORMAT(jd_vessels.certi_validity, "%M %e, %Y") , " - ", DATE_FORMAT(jd_vessels.certi_validity_to, "%M %e, %Y"), ")"), 
// "NON-CBA"
// ) AS bargain,