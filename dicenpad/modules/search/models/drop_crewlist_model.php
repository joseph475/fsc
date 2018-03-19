<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-02-22
 */

class Drop_crewlist_model extends MY_Model
{
    private $_table_name = 'crew';
    private $_primary_key = 'crew_id';   

    protected $_allowed_filters = array(
        'vessel_id'     => 'vessels', 
        'end_date'      => 'onboard', 
        'start_date'    => 'onboard',
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
                        $array_value[0] =  stripslashes($value);
                    } elseif ($field == 'vessels.vessel_id') {
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
        
        $sql = "SELECT *, 
                    CONCAT('<li><b>', CONCAT(t.code, ' ',  t.fullname), '</b> <br/> ', 
                    (SELECT GROUP_CONCAT(document SEPARATOR ', ') 
                        FROM jd_crew_docs
                        INNER JOIN jd_document ON jd_document.id = jd_crew_docs.docs_id
                        WHERE jd_crew_docs.published = 1 AND jd_crew_docs.crew_id = t.crew_id
                        GROUP BY crew_id ORDER BY jd_document.defaults, jd_document.id ), '<br/></li>') AS crew_document,
                    (SELECT CONCAT('<ol type=\'1\'>',TRIM(GROUP_CONCAT(CONCAT('<li>', documents, '</li>') SEPARATOR '&nbsp;')), '</ol>') AS ship_document 
                        FROM jd_vessels_docs 
                        WHERE jd_vessels_docs.published = 1 AND jd_vessels_docs.vessel_id = {$array_value[1]}
                        GROUP BY vessel_id) AS ship_document
                        FROM (
						SELECT jd_crew.crew_id, jd_crew.fullname, jd_position.code, jd_crew.birthdate, 
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
						AND (start_date <= '{$array_value[0]}' AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= '{$array_value[0]}') 
                        AND jd_onboard.onboard_id = (SELECT MAX(onboard_id) FROM jd_onboard 
                            WHERE crew_id = jd_crew.crew_id AND (start_date <= '{$array_value[0]}' 
                            AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= '{$array_value[0]}') AND crew_id = jd_onboard.crew_id ORDER BY start_date DESC)

					UNION ALL

						SELECT jd_crew.crew_id, jd_crew.fullname, jd_position.code AS rank, jd_crew.birthdate, 
						(SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos, 
						(SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_expiry, start_date, duration_month, 
						(SELECT endorsement FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 12 LIMIT 1) AS endorsement, jd_position.sort_order
						FROM (jd_crew) 
						INNER JOIN jd_schedule_j ON jd_schedule_j.crew_id = jd_crew.crew_id
						INNER JOIN jd_position ON jd_schedule_j.position_id = jd_position.id 
						WHERE vessel_id = {$array_value[1]}  AND isembark = 0

					UNION ALL

						SELECT jd_crew.crew_id, jd_crew.fullname, jd_position.code AS rank, jd_crew.birthdate, 
						(SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos, 
						(SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_expiry, start_date, 
						jd_schedule_p.duration_month + (IF(month_duration = '', 12 * (YEAR(jd_onboard.end_date) - YEAR(jd_onboard.start_date)) + (MONTH(jd_onboard.end_date) - MONTH(jd_onboard.start_date)), duration)) AS duration, 
						(SELECT endorsement FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 12 LIMIT 1) AS endorsement, jd_position.sort_order
						FROM (jd_crew) 
						INNER JOIN jd_schedule_p ON jd_schedule_p.crew_id = jd_crew.crew_id
						INNER JOIN jd_onboard ON jd_schedule_p.crew_id = jd_onboard.crew_id 
						INNER JOIN jd_position ON jd_schedule_p.position_new = jd_position.id 
						WHERE jd_schedule_p.vessel_id = {$array_value[1]}  AND ispromoted = 0
						AND (start_date <= '{$array_value[0]}' AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= '{$array_value[0]}') 
                        AND jd_onboard.onboard_id = (SELECT MAX(onboard_id) FROM jd_onboard 
                            WHERE crew_id = jd_crew.crew_id AND (start_date <= '{$array_value[0]}' 
                            AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= '{$array_value[0]}') AND crew_id = jd_onboard.crew_id ORDER BY start_date DESC)
				) t ";
        
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


