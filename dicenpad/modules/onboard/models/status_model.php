<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-16
 */

class Status_model extends MY_Model
{
    private $_table_name = 'crew';
    private $_primary_key = 'crew_id';	

    protected $_allowed_filters = array(
        'crew_id'       => 'crew_id', 
        'vessel_id'     => 'onboard', 
        'status'        => 'vessels', 
        'isdone'        => 'onboard', 
        'end_date'      => 'onboard', 
        'start_date'    => 'onboard' 
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
        $this->db->select('fullname, hash, crew.crew_id, position.code, position.position, 
            CONCAT(jd_vessels.prefix, " ", jd_vessels.vessel_name) AS vessel_name, flag.flag,
            CONCAT(12 * (YEAR(jd_onboard.end_date) - YEAR(jd_onboard.start_date)) + (MONTH(jd_onboard.end_date) - MONTH(jd_onboard.start_date)), " Months") AS duration,
            onboard.start_date, onboard.end_date, onboard.embarked, onboard.disembarked, department.option as department, onboard.remarks,
            (SELECT remarks FROM jd_crew_remarks 
                    WHERE jd_crew_remarks.crew_id = jd_crew.crew_id
                    ORDER BY id DESC LIMIT  1
                ) AS manager_comment, 
            (SELECT docs_nos FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos,
            (SELECT date_expired FROM jd_crew_docs WHERE jd_crew_docs.crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_expiry',
            FALSE
        );

        $this->db->join('onboard', 'crew.crew_id = onboard.crew_id', 'INNER');
        $this->db->join('position', 'position.id = onboard.position_id', 'INNER');  
        $this->db->join('department', 'department.id = position.department_id', 'left');  
        $this->db->join('vessels', 'vessels.id = onboard.vessel_id', 'INNER');    
        $this->db->join('flag', 'flag.id = vessels.flag_id', 'left');
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
                    } elseif ($field == 'onboard.start_date') {
                        $array_date[1] =  'start_date';
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

        if($array_date[1] == 'start_date'){
            $this->db->where("CAST(embarked AS DATE) BETWEEN {$array_date[0]}"); 
        }

        if($array_date[1] == 'end_date') {
            $this->db->where("CAST(disembarked AS DATE) BETWEEN {$array_date[0]}"); 
        }
        
        return $this->fetch_all($limit, $offset, 'jd_position.sort_order', 'asc');
    }
    
}