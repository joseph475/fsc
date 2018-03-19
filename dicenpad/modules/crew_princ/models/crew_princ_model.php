<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-16
 */

class Crew_princ_model extends MY_Model
{
    private $_table_name = 'onboard';
    private $_primary_key = 'onboard_id';	

    protected $_allowed_filters = array(
        'crew_id', 'vessel_id', 'position_id', 'principal_id', 'isdone', 'department_id' => 'position', 'end_date'
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
                    /** ONBOARD TABLE jd_onboard.*, **/
                        
                        DATE_FORMAT(jd_onboard.start_date, "%m/%d/%Y" ) AS onboard_date, 
                        DATE_FORMAT(DATE_ADD(jd_onboard.start_date, INTERVAL jd_onboard.month_duration MONTH), "%m/%d/%Y" ) sea_expiry,
                    /** CREW TABLE **/
                        jd_crew.fullname, jd_crew.hash, jd_crew.birthdate, jd_crew.date_hired, jd_crew.crew_id, jd_crew.payroll_id, jd_crew.profit_id, 
                    
                    /** POSITION TABLE **/
                        jd_position.position, jd_position.code,
                    
                    /** PRINCIPAL TABLE **/
                        jd_principal.fullname AS principal, 
                        
                    /** VESSELS TABLE **/
                        CONCAT(jd_vessels.prefix, " ", jd_vessels.vessel_name) as vessel_name, jd_vessels.official_nos, jd_vessels.imo_nos, jd_vessels.gross, jd_vessels.flag_id, 
                        jd_vessels.classification, jd_vessels.e_year, jd_vessels.builder, jd_vessels.cba, jd_vessels.registered, 
                        jd_vessels.certi_validity as validity, jd_vessels.certi_validity_to as validity_to, jd_vessels.trade, jd_vessels.hp,
                        
                    /** VESSELS TYPE TABLE **/
                        jd_type.type AS vessel_type, 
                        
                    /** FLAG TABLE **/
                        jd_flag.flag
 
            ',
            FALSE
        );

        $this->db->join('crew', 'crew.crew_id = onboard.crew_id', 'inner');
        $this->db->join('position', 'position.id = onboard.position_id', 'left');  
        //$this->db->join('department', 'department.id = position.department_id', 'left');  
        $this->db->join('vessels', 'vessels.id = onboard.vessel_id', 'inner');    
        $this->db->join('principal', 'principal.id = vessels.principal_id', 'left');    
        //$this->db->join('salary', 'salary.id = onboard.salary_id', 'left');  
        $this->db->join('flag', 'flag.id = vessels.flag_id', 'left');
        $this->db->join('type_sub', 'type_sub.id = vessels.type_id', 'left');
        $this->db->join('type', 'type.id = type_sub.type_id', 'left');
    }

    public function search($key, $value = null, $limit = null, $offset = null, $sort = null, $order ='desc')
    {
        if ($key == '') {
            return $this->fetch_all($limit, $offset, $sort, $order);
        }

        if (!is_array($key))
        {
            $key = array ($key);
        }
        
        $type = 'eq';

        $array_date = array(0, 1);


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

                if (isset($field['searchVal']) && $field['searchVal'] != 'null') {
                    foreach ($this->_search_fields as $f) {
                        $like[] = $f.'  LIKE "%'.$params['searchVal'].'%"';                
                    }
                    $type = 'custom';
                    $field = '';
                    $value = '(' . implode(' OR ', $like) . ')';
                }
            }

            switch ($type) {
                case 'eq':
                    if ($field == 'onboard.end_date') {
                        $array_date[1] =  'end_date';
                        $array_date[0] =  stripslashes($value);
                    } else {
                        $this->db->where($field, $value);
                    }
                    break;
                case 'custom':  
                    $this->db->where($value, null, FALSE);           
                    break;
            }                
        }
        if($array_date[1] == 'end_date') {
            $this->db->where("($array_date[0] BETWEEN start_date AND (IF(disembarked = 0000-00-00, $array_date[0], disembarked)))"); 
            $this->db->where("onboard_id = (SELECT MAX(onboard_id) FROM jd_onboard 
                            WHERE crew_id = jd_crew.crew_id AND $array_date[0] BETWEEN start_date AND (IF(disembarked = 0000-00-00, $array_date[0], disembarked))
                            AND crew_id = jd_onboard.crew_id ORDER BY start_date DESC)");
            $this->db->where("disembarked <> $array_date[0]");
        }

        // if($array_date[1] == 'end_date') {
        //     //$this->db->where("(start_date <= $array_date[0] AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= $array_date[0])"); 
        //     $this->db->where("($array_date[0] BETWEEN start_date AND (IF(disembarked = 0000-00-00, $array_date[0], disembarked)))");
        // }

        return $this->fetch_all($limit, $offset, $sort, $order);

    }
}