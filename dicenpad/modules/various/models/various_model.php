<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-16
 */

class Various_model extends MY_Model
{
    private $_table_name = 'onboard';
    private $_primary_key = 'onboard_id';	

    protected $_allowed_filters = array(
        'crew_id', 'vessel_id', 'isdone', 'department_id' => 'position', 'end_date'
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
                        jd_crew.fullname, jd_crew.hash,
                    
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
                        jd_flag.flag,                        
                  

                    /** DOCUMENT AND CREW_DOCS TABLE **/
                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos, 
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_expiry, 
                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 3 LIMIT 1) AS passport_nos, 
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 3 LIMIT 1) AS passport_expiry,
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 4 LIMIT 1) AS ph_license_expiry,
                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 4 LIMIT 1) AS ph_license_nos,                        

                        IF(jd_position.division_id = 1, 
                            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 7 LIMIT 1),
                            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 8 LIMIT 1)  
                        ) AS coc_nos, 
                        IF(jd_position.division_id = 1, 
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 7 LIMIT 1),
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 8 LIMIT 1)  
                        ) AS coc_expiry, 

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
                         WHEN 104 THEN /**JAPAN**/
                            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 249 LIMIT 1)
                        ELSE
                           "-"
                        END AS gmdss_nos,

                        CASE jd_vessels.flag_id 
                        WHEN 159 THEN /**PANAMA**/
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 15 LIMIT 1)
                        WHEN 130 THEN /**MARSHAL**/
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 27 LIMIT 1)
                        WHEN 117 THEN /**LIBERIA**/
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 31 LIMIT 1)
                        WHEN 15 THEN /**BAHAMAS**/
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 23 LIMIT 1)
                        WHEN 183 THEN /**LIBERIA**/
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 19 LIMIT 1)
                        WHEN 104 THEN /**Japan**/
                            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 249 LIMIT 1)
                        ELSE
                           "-"
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
                            WHEN 15 THEN /**BAHAMAS**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 22 LIMIT 1)
                            WHEN 183 THEN /**SINGAPORE**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 18 LIMIT 1)
                            WHEN 104 THEN /**JAPAN**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 250 LIMIT 1)    
                            ELSE
                              "-"
                            END 
                        WHEN 2 THEN /**RATINGS**/
                            CASE jd_vessels.flag_id 
                            WHEN 159 THEN /**PANAMA**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 13 LIMIT 1)
                            WHEN 130 THEN /**MARSHAL**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 25 LIMIT 1)
                            WHEN 117 THEN /**LIBERIA**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 29 LIMIT 1)
                            WHEN 15 THEN /**BAHAMAS**/
                                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 21 LIMIT 1)
                            WHEN 183 THEN /**SINGAPORE**/
                               (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 17 LIMIT 1)
                            WHEN 104 THEN /**Japan**/
                               (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 249 LIMIT 1)
                            ELSE
                                "-"
                            END 
                        END AS booklet_license,
                        CASE jd_position.division_id  
                        WHEN 1 THEN /**OFFICER**/
                            CASE jd_vessels.flag_id 
                            WHEN 159 THEN /**PANAMA**/
                               (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 14 LIMIT 1)
                            WHEN 130 THEN /**MARSHAL**/
                                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 26 LIMIT 1)
                            WHEN 117 THEN /**LIBERIA**/
                                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 30 LIMIT 1)
                            WHEN 15 THEN /**LIBERIA**/
                                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 22 LIMIT 1)
                            WHEN 183 THEN /**SINGAPORE**/
                                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 18 LIMIT 1)
                            WHEN 104 THEN /**Japan**/
                              (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 250 LIMIT 1)
                            ELSE
                                "-"
                            END 
                        WHEN 2 THEN /**RATINGS**/
                            CASE jd_vessels.flag_id 
                            WHEN 159 THEN /**PANAMA**/
                                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 13 LIMIT 1)
                            WHEN 130 THEN /**MARSHAL**/
                                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 25 LIMIT 1)
                            WHEN 117 THEN /**LIBERIA**/
                               (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 29 LIMIT 1)
                            WHEN 15 THEN /**BAHAMAS**/
                               (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 21 LIMIT 1)
                            WHEN 183 THEN /**SINGAPORE**/
                               (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 17 LIMIT 1)
                            WHEN 104 THEN /**Japan**/
                                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 249 LIMIT 1)
                            ELSE
                                "-"
                            END 
                        END AS booklet_license_expiry,

                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 10 LIMIT 1) AS us_expiry, 
                        (SELECT date_issued FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 144 LIMIT 1) AS yellow_issued, 
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 144 LIMIT 1) AS yellow_expiry, 
                        (SELECT date_issued FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 140 LIMIT 1) AS medical_issued, 
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 140 LIMIT 1) AS medical_expiry, 
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 11 LIMIT 1) AS mcv_expiry, 
                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 11 LIMIT 1) AS mvc_nos, 
                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 2 LIMIT 1) AS src_nos,

                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND 
                        docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 1 AND published = 1)
                        LIMIT 1) AS column1_nos ,
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND 
                        docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 1 AND published = 1)
                        LIMIT 1) AS column1_expiry ,
                        (SELECT document FROM jd_document WHERE id  = (SELECT docs_id FROM jd_document_various WHERE id = 1 AND published = 1)
                        ) AS column1_name,

                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND 
                        docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 2 AND published = 1)
                        LIMIT 1) AS column2_nos ,
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND 
                        docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 2 AND published = 1)
                        LIMIT 1) AS column2_expiry ,
                        (SELECT document FROM jd_document WHERE id  = (SELECT docs_id FROM jd_document_various WHERE id = 2 AND published = 1)
                        ) AS column2_name,

                        (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND 
                        docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 3 AND published = 1)
                        LIMIT 1) AS column3_nos ,
                        (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND 
                        docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 3 AND published = 1)
                        LIMIT 1) AS column3_expiry ,
                        (SELECT document FROM jd_document WHERE id  = (SELECT docs_id FROM jd_document_various WHERE id = 3 AND published = 1)
                        ) AS column3_name
 
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
    
    function update_prevboard_status($array = array(), $id)
    {
        $this->db->where($this->_primary_key, $id);

        return $this->db->update($this->_table_name, $array);
    }
}