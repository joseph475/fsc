<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-16
 */

class Search_vessel_model extends MY_Model
{
    private $_table_name = 'crew';
    private $_primary_key = 'crew_id';	

    protected $_allowed_filters = array(
        'vessel_id'     => 'onboard', 
        'end_date'      => 'onboard', 
        'start_date'    => 'onboard',
        //'disembarked' => 'onboard', 
        'isdone'        => 'onboard'
    );
    
    protected $_search_fields = array(
        'jd_crew.crew_id', 'jd_crew.fullname'
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
         // $this->db->select("
         //            crew.crew_id, jd_onboard.original_date,
         //            onboard.month_duration AS signedcontract, 
         //            CONCAT('<li><b>', CONCAT(jd_position.code, ' ',  jd_crew.fullname), '</b> <br/>', 
         //            (SELECT GROUP_CONCAT(document SEPARATOR ', ') 
         //            FROM jd_crew_docs
         //            INNER JOIN jd_document ON jd_document.id = jd_crew_docs.docs_id
         //            WHERE jd_crew_docs.published = 1 AND jd_crew_docs.crew_id = jd_onboard.crew_id
         //            GROUP BY crew_id ORDER BY jd_document.defaults, jd_document.id ), '<br/></li>') AS crew_document,
         //            (SELECT CONCAT('<ol type=\'1\'>',TRIM(GROUP_CONCAT(CONCAT('<li>', documents, '</li>') SEPARATOR '&nbsp;')), '</ol>') AS ship_document 
         //            FROM jd_vessels_docs 
         //            WHERE jd_vessels_docs.published = 1 AND jd_vessels_docs.vessel_id = jd_vessels.id
         //            GROUP BY vessel_id) AS ship_document,
         //            crew.fullname, crew.birthdate, crew.birthplace, crew.pres_address, crew.photo, crew.hash, crew.date_hired,
         //            department.option AS department, division.option AS division, onboard.isdone,
         //            position.code, position.position, CONCAT(jd_vessels.prefix, ' ', jd_vessels.vessel_name) as vessel_name, onboard.start_date, onboard.end_date, 
         //            onboard.vessel_id, vessels.code as vcode, flag.flag, onboard.disembarked, onboard.embarked, onboard.position_id,
         //            vessels.official_nos, vessels.imo_nos, vessels.gross, vessels.classification, vessels.e_year, vessels.builder,
         //            principal.fullname AS principal, principal.address AS prin_address, onboard.joining_port,
         //            (SELECT file_docs FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id  AND docs_id = 1 LIMIT 1) AS file_docs,
         //            (SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id  AND docs_id = 1 LIMIT 1) AS seaman_nos,
         //            (SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id  AND docs_id = 1 LIMIT 1) AS seaman_expiry,
         //            (SELECT endorsement FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 12 LIMIT 1) AS endorsement,
         //            (SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id  AND docs_id = 3 LIMIT 1) AS passport
         //        ",
         //        FALSE
         //    );

        $this->db->query('SET SESSION group_concat_max_len=15000');
        $this->db->join('onboard', 'crew.crew_id = onboard.crew_id', 'inner');
        $this->db->join('schedule_h', 'schedule_h.id = onboard.sched_id', 'left');
        $this->db->join('vessels', 'onboard.vessel_id = vessels.id', 'inner');  
        $this->db->join('position', 'onboard.position_id = position.id', 'inner');  
        $this->db->join('principal', 'vessels.principal_id = principal.id', 'left');    
        $this->db->join('department', 'position.department_id = department.id', 'left');    
        $this->db->join('division', 'position.division_id = division.id', 'left');  
        $this->db->join('flag', 'vessels.flag_id = flag.id', 'left');
       // $this->db->join('disembarkation', 'onboard.crew_id = disembarkation.crew_id', 'left');

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
            $this->db->select("
                    crew.crew_id, jd_onboard.original_date,
                    ROUND(DATEDIFF($array_date[0], jd_onboard.original_date)/(365/12), 2) AS duration,
                    onboard.month_duration AS signedcontract, 
                    CONCAT('<li><b>', CONCAT(jd_position.code, ' ',  jd_crew.fullname), '</b> <br/>', 
                    (SELECT GROUP_CONCAT(document SEPARATOR ', ') 
                    FROM jd_crew_docs
                    INNER JOIN jd_document ON jd_document.id = jd_crew_docs.docs_id
                    WHERE jd_crew_docs.docs_nos <> '0' AND jd_crew_docs.crew_id = jd_onboard.crew_id
                    GROUP BY crew_id ORDER BY jd_document.defaults, jd_document.id ), '<br/></li>') AS crew_document,
                    (SELECT CONCAT('<ol type=\'1\'>',TRIM(GROUP_CONCAT(CONCAT('<li>', documents, '</li>') SEPARATOR '&nbsp;')), '</ol>') AS ship_document 
                    FROM jd_vessels_docs 
                    WHERE jd_vessels_docs.published = 1 AND jd_vessels_docs.vessel_id = jd_vessels.id
                    GROUP BY vessel_id) AS ship_document,
                    crew.fullname, crew.birthdate, crew.birthplace, crew.pres_address, crew.photo, crew.hash, crew.date_hired,
                    department.option AS department, division.option AS division, onboard.isdone,
                    position.code, position.position, CONCAT(jd_vessels.prefix, ' ', jd_vessels.vessel_name) as vessel_name, onboard.start_date, onboard.end_date,jd_vessels.flag as vessel_flag, 
                    onboard.vessel_id, vessels.control_nos, vessels.code as vcode, flag.flag, onboard.disembarked, onboard.embarked, onboard.position_id,onboard.joining_port as objoin,
                    vessels.official_nos, vessels.imo_nos, vessels.gross, vessels.classification, vessels.e_year, vessels.builder,
                    principal.fullname AS principal, principal.address AS prin_address, schedule_h.joining_port,
                    (SELECT file_docs FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id  AND docs_id = 1 LIMIT 1) AS file_docs,
                    (SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id  AND docs_id = 1 LIMIT 1) AS seaman_nos,
                    (SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id  AND docs_id = 1 LIMIT 1) AS seaman_expiry,
                    (SELECT endorsement FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 12 LIMIT 1) AS endorsement,
                    (SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id  AND docs_id = 3 LIMIT 1) AS passport,
                    (SELECT vessel_name FROM jd_disembarkation WHERE jd_disembarkation.crew_id = jd_onboard.crew_id LIMIT 1) AS last_vessel

                ",
                FALSE
            );

            $this->db->where("($array_date[0] BETWEEN start_date AND (IF(disembarked = 0000-00-00, $array_date[0], disembarked)))"); 
            $this->db->where("onboard_id = (SELECT MAX(onboard_id) FROM jd_onboard 
                            WHERE crew_id = jd_crew.crew_id AND $array_date[0] BETWEEN start_date AND (IF(disembarked = 0000-00-00, $array_date[0], disembarked))
                            AND crew_id = jd_onboard.crew_id ORDER BY start_date DESC)");
            $this->db->where("disembarked <> $array_date[0]");
        }

        // if($array_date[1] == 'end_date') {
        //     $this->db->where("((IF(disembarked=0000-00-00, $array_date[0], disembarked)) >= $array_date[0])"); 
        //     $this->db->where("onboard_id = (SELECT MAX(onboard_id) FROM jd_onboard 
        //                     WHERE crew_id = jd_crew.crew_id AND ((IF(disembarked=0000-00-00, $array_date[0], disembarked)) >= $array_date[0]) 
        //                     AND crew_id = jd_onboard.crew_id ORDER BY start_date DESC)");
        // }

        
        // if($array_date[1] == 'end_date') {
        //     $this->db->where("(start_date <= $array_date[0] AND (IF(disembarked=0000-00-00, $array_date[0], disembarked)) >= $array_date[0])"); 
        //     $this->db->where("onboard_id = (SELECT MAX(onboard_id) FROM jd_onboard 
        //                     WHERE crew_id = jd_crew.crew_id AND (start_date <= $array_date[0] 
        //                     AND (IF(disembarked=0000-00-00, $array_date[0], disembarked)) >= $array_date[0]) AND crew_id = jd_onboard.crew_id ORDER BY start_date DESC)");
        // }

        return $this->fetch_all($limit, $offset, $sort, $order);
    }
}