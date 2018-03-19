<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-16
 */

class Draft_various_model extends MY_Model
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
    
    public function search($key, $value = 0, $limit = null, $offset = null, $sort = null, $order ='desc')
    {
        if (!is_array($key))
        {
            $key = array ($key);
        }

        $type = 'eq';

        $array_value = array(0, 1, 2, 3);

        foreach ($key as $field)
        {
            if (is_array($field)) {     
                if (isset($field['value'])) {
                    $value = $field['value'];
                }

                $field = $field['field'];
            }

            switch ($type) {
                case 'eq':
                    if($field == 'onboard.end_date') {
                        $array_value[0] = stripslashes($value);
                    } elseif ($field == 'onboard.vessel_id') {
                        $array_value[1] =  stripslashes($value);
                    } else {
                        $this->db->where($field, $value);
                    }
                    break;
                case 'custom':                    
                    $this->db->where($value, null, FALSE);           
                    break;
            }    
        }
       

        $this->db->query('SET SESSION group_concat_max_len=15000');
        
        $sql = "SELECT t.*, jd_crew.hash,
                        /** PRINCIPAL TABLE **/
                jd_principal.fullname AS principal, 

                /** VESSELS TABLE **/
                CONCAT(jd_vessels.prefix, ' ', jd_vessels.vessel_name) AS vessel_name, jd_vessels.official_nos, jd_vessels.imo_nos, jd_vessels.gross, jd_vessels.flag_id, 
                jd_vessels.classification, jd_vessels.e_year, jd_vessels.builder, jd_vessels.cba, jd_vessels.registered, 
                jd_vessels.certi_validity AS validity, jd_vessels.certi_validity_to AS validity_to, jd_vessels.trade, jd_vessels.hp,

                /** VESSELS TYPE TABLE **/
                jd_type.type AS vessel_type, 

                /** FLAG TABLE **/
                jd_flag.flag,  
                /** DOCUMENT AND CREW_DOCS TABLE **/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos, 
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 1 LIMIT 1) AS seaman_expiry, 
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 3 LIMIT 1) AS passport_nos, 
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 3 LIMIT 1) AS passport_expiry,
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 4 LIMIT 1) AS ph_license_expiry,
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 4 LIMIT 1) AS ph_license_nos,                        

                IF(jd_position.division_id = 1, 
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 7 LIMIT 1),
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 8 LIMIT 1)  
                ) AS coc_nos, 
                IF(jd_position.division_id = 1, 
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 7 LIMIT 1),
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 8 LIMIT 1)  
                ) AS coc_expiry, 

                CASE jd_vessels.flag_id 
                WHEN 159 THEN /**PANAMA**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 15 LIMIT 1)
                WHEN 130 THEN /**MARSHAL**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 27 LIMIT 1)
                WHEN 117 THEN /**LIBERIA**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 31 LIMIT 1)
                WHEN 15 THEN /**BAHAMAS**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 23 LIMIT 1)
                WHEN 183 THEN /**SINGAPORE**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 19 LIMIT 1)
                ELSE
                'N/A'
                END AS gmdss_nos,

                CASE jd_vessels.flag_id 
                WHEN 159 THEN /**PANAMA**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 15 LIMIT 1)
                WHEN 130 THEN /**MARSHAL**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 27 LIMIT 1)
                WHEN 117 THEN /**LIBERIA**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 31 LIMIT 1)
                WHEN 15 THEN /**BAHAMAS**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 23 LIMIT 1)
                WHEN 183 THEN /**LIBERIA**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 19 LIMIT 1)
                ELSE
                'N/A'
                END AS gmdss_expiry,

                CASE jd_position.division_id  
                WHEN 1 THEN /**OFFICER**/
                CASE jd_vessels.flag_id 
                WHEN 159 THEN /**PANAMA**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 14 LIMIT 1)
                WHEN 130 THEN /**MARSHAL**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 26 LIMIT 1)
                WHEN 117 THEN /**LIBERIA**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 30 LIMIT 1)
                WHEN 15 THEN /**BAHAMAS**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 22 LIMIT 1)
                WHEN 183 THEN /**SINGAPORE**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 18 LIMIT 1)
                ELSE
                'N/A'
                END 
                WHEN 2 THEN /**RATINGS**/
                CASE jd_vessels.flag_id 
                WHEN 159 THEN /**PANAMA**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 13 LIMIT 1)
                WHEN 130 THEN /**MARSHAL**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 25 LIMIT 1)
                WHEN 117 THEN /**LIBERIA**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 29 LIMIT 1)
                WHEN 15 THEN /**BAHAMAS**/
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 21 LIMIT 1)
                WHEN 183 THEN /**SINGAPORE**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 17 LIMIT 1)
                ELSE
                'N/A'
                END 
                END AS booklet_license,

                CASE jd_position.division_id  
                WHEN 1 THEN /**OFFICER**/
                CASE jd_vessels.flag_id 
                WHEN 159 THEN /**PANAMA**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 14 LIMIT 1)
                WHEN 130 THEN /**MARSHAL**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 26 LIMIT 1)
                WHEN 117 THEN /**LIBERIA**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 30 LIMIT 1)
                WHEN 15 THEN /**LIBERIA**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 22 LIMIT 1)
                WHEN 183 THEN /**SINGAPORE**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 18 LIMIT 1)
                ELSE
                'N/A'
                END 
                WHEN 2 THEN /**RATINGS**/
                CASE jd_vessels.flag_id 
                WHEN 159 THEN /**PANAMA**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 13 LIMIT 1)
                WHEN 130 THEN /**MARSHAL**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 25 LIMIT 1)
                WHEN 117 THEN /**LIBERIA**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 29 LIMIT 1)
                WHEN 15 THEN /**BAHAMAS**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 21 LIMIT 1)
                WHEN 183 THEN /**SINGAPORE**/
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 17 LIMIT 1)
                ELSE
                'N/A'
                END 
                END AS booklet_license_expiry,

                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 10 LIMIT 1) AS us_expiry, 
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 144 LIMIT 1) AS yellow_expiry, 
                (SELECT date_issued FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 140 LIMIT 1) AS medical_issued, 
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 140 LIMIT 1) AS medical_expiry, 
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 11 LIMIT 1) AS mcv_expiry, 
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 11 LIMIT 1) AS mvc_nos, 
                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND docs_id = 2 LIMIT 1) AS src_nos,

                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND 
                docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 1 AND published = 1)
                LIMIT 1) AS column1_nos ,
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND 
                docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 1 AND published = 1)
                LIMIT 1) AS column1_expiry ,
                (SELECT document FROM jd_document WHERE id  = (SELECT docs_id FROM jd_document_various WHERE id = 1 AND published = 1)
                ) AS column1_name,

                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND 
                docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 2 AND published = 1)
                LIMIT 1) AS column2_nos ,
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND 
                docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 2 AND published = 1)
                LIMIT 1) AS column2_expiry ,
                (SELECT document FROM jd_document WHERE id  = (SELECT docs_id FROM jd_document_various WHERE id = 2 AND published = 1)
                ) AS column2_name,

                (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND 
                docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 3 AND published = 1)
                LIMIT 1) AS column3_nos ,
                (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = t.crew_id AND 
                docs_id = (SELECT docs_id FROM jd_document_various WHERE id = 3 AND published = 1)
                LIMIT 1) AS column3_expiry ,
                (SELECT document FROM jd_document WHERE id  = (SELECT docs_id FROM jd_document_various WHERE id = 3 AND published = 1)
                ) AS column3_name

                        FROM (
                        SELECT jd_crew.crew_id, DATE_FORMAT(jd_onboard.start_date, '%m/%d/%Y') AS onboard_date, jd_onboard.vessel_id, jd_crew.fullname, jd_position.code, jd_position.id AS position_id, jd_crew.birthdate, 
                        (SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos, 
                        (SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_expiry, jd_onboard.embarked, 
                        IF(month_duration = '', 12 * (YEAR(jd_onboard.end_date) - YEAR(jd_onboard.start_date)) + (MONTH(jd_onboard.end_date) - MONTH(jd_onboard.start_date)), duration) AS duration, 
                        (SELECT endorsement FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 12 LIMIT 1) AS endorsement, jd_position.sort_order
                        FROM (jd_crew) 
                        INNER JOIN jd_onboard ON jd_crew.crew_id = jd_onboard.crew_id 
                        INNER JOIN jd_position ON jd_onboard.position_id = jd_position.id 
                        WHERE jd_onboard.vessel_id = {$array_value[1]} 
                        AND jd_crew.crew_id NOT IN (
                                    SELECT crew_id FROM jd_schedule_r WHERE vessel_id = {$array_value[1]}  AND isdisembark = 0
                                    UNION ALL
                                    SELECT crew_id FROM jd_schedule_p WHERE vessel_id = {$array_value[1]}  AND ispromoted = 0
                                    )
                        AND (start_date <= DATE_FORMAT(DATE_FORMAT({$array_value[0]}, '%Y-%m-%d'), '%Y/%m/%d') AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= DATE_FORMAT({$array_value[0]}, '%Y-%m-%d')) 
                        AND jd_onboard.onboard_id = (SELECT MAX(onboard_id) FROM jd_onboard 
                            WHERE crew_id = jd_crew.crew_id AND (start_date <= DATE_FORMAT({$array_value[0]}, '%Y-%m-%d')
                            AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= DATE_FORMAT({$array_value[0]}, '%Y-%m-%d')) AND crew_id = jd_onboard.crew_id ORDER BY start_date DESC)

                    UNION ALL

                        SELECT jd_crew.crew_id, DATE_FORMAT(jd_schedule_j.start_date, '%m/%d/%Y') AS onboard_date, jd_schedule_j.vessel_id, jd_crew.fullname, jd_position.code AS rank, jd_position.id AS position_id, jd_crew.birthdate,
                        (SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos, 
                        (SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_expiry, start_date, duration_month, 
                        (SELECT endorsement FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 12 LIMIT 1) AS endorsement, jd_position.sort_order
                        FROM (jd_crew) 
                        INNER JOIN jd_schedule_j ON jd_schedule_j.crew_id = jd_crew.crew_id
                        INNER JOIN jd_position ON jd_schedule_j.position_id = jd_position.id 
                        WHERE vessel_id = {$array_value[1]}  AND isembark = 0

                    UNION ALL

                        SELECT jd_crew.crew_id, DATE_FORMAT(jd_onboard.start_date, '%m/%d/%Y') AS onboard_date, jd_onboard.vessel_id, jd_crew.fullname, jd_position.code AS rank, jd_position.id AS position_id, jd_crew.birthdate, 
                        (SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos, 
                        (SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_expiry, start_date, 
                        jd_schedule_p.duration_month + (IF(month_duration = '', 12 * (YEAR(jd_onboard.end_date) - YEAR(jd_onboard.start_date)) + (MONTH(jd_onboard.end_date) - MONTH(jd_onboard.start_date)), duration)) AS duration, 
                        (SELECT endorsement FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 12 LIMIT 1) AS endorsement, jd_position.sort_order
                        FROM (jd_crew) 
                        INNER JOIN jd_schedule_p ON jd_schedule_p.crew_id = jd_crew.crew_id
                        INNER JOIN jd_onboard ON jd_schedule_p.crew_id = jd_onboard.crew_id 
                        INNER JOIN jd_position ON jd_schedule_p.position_new = jd_position.id 
                        WHERE jd_schedule_p.vessel_id = {$array_value[1]}  AND ispromoted = 0
                        AND (start_date <= DATE_FORMAT({$array_value[0]}, '%Y-%m-%d') AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= DATE_FORMAT({$array_value[0]}, '%Y-%m-%d')) 
                        AND jd_onboard.onboard_id = (SELECT MAX(onboard_id) FROM jd_onboard 
                            WHERE crew_id = jd_crew.crew_id AND (start_date <= DATE_FORMAT({$array_value[0]}, '%Y-%m-%d')
                            AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= DATE_FORMAT({$array_value[0]}, '%Y-%m-%d')) AND crew_id = jd_onboard.crew_id ORDER BY start_date DESC)
                ) t 

        INNER JOIN jd_crew ON jd_crew.crew_id = t.crew_id
        LEFT JOIN jd_position ON jd_position.id = t.position_id
        INNER JOIN jd_vessels ON jd_vessels.id = t.vessel_id
        LEFT JOIN jd_principal ON jd_principal.id = jd_vessels.principal_id
        LEFT JOIN jd_flag ON jd_flag.id = jd_vessels.flag_id
        LEFT JOIN jd_type_sub ON jd_type_sub.id = jd_vessels.type_id
        LEFT JOIN jd_type ON jd_type.id = jd_type_sub.type_id ";
        
        if (is_null($sort)) {
            $sql .= "ORDER BY t.sort_order, t.embarked ASC ";
        } else {
            $sql .= "ORDER BY {$sort} {$order} ";
        }

        if($limit) {
            $sql .= ' LIMIT ' . $limit . (($offset)? ', ' . $offset : '');
        }
        
        $rs = $this->db->query($sql); 
        return $rs;

    }
}