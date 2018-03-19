<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-06-3
 */

class Received_model extends MY_Model
{
    private $_table_name = 'received';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'crew_id', 'date_received', 'date_sent', 'vessel_id'
    );
    
    protected $_search_fields = array(
        'date_received','lastname', 'firstname', 'date_check',
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
                IF(jd_received.date_received <> "", DATE_FORMAT(jd_received.date_received, "%m/%d/%Y"), "") AS dr,
                IF(jd_received.date_expired <> "", DATE_FORMAT(jd_received.date_expired, "%m/%d/%Y"), "") AS de,
                IF(jd_received.date_check <> "", DATE_FORMAT(jd_received.date_check, "%m/%d/%Y"), "") AS dc,
                CONCAT(lastname, ", ", firstname, " " , middlename) as fullname, position.code, position.position, 
                position.position, position.code, crew.birthdate, crew.birthplace, crew.pres_address, crew.crew_id, crew.gender, crew.photo, crew.hash,
                principal.fullname as principal, principal.address as prin_address, department.option as department,                      
                CONCAT(jd_principal.telno1, IF(jd_principal.telno2 <>"", CONCAT(", ", jd_principal.telno2), ""), IF(jd_principal.telno3 <>"", CONCAT(", ", jd_principal.telno3), "")) AS principal_tel,             
                vessels.vessel_name, vessels.official_nos, vessels.imo_nos, vessels.gross, flag.flag
                ', FALSE
        );

        $this->db->join('crew', 'crew.crew_id = received.crew_id', 'left');  
        $this->db->join('position', 'position.id = received.position_id', 'left');   
        $this->db->join('vessels', 'vessels.id = received.vessel_id', 'left'); 
        $this->db->join('flag', 'flag.id = vessels.flag_id', 'left'); 
        $this->db->join('principal', 'principal.id = vessels.principal_id', 'left'); 
        $this->db->join('department', 'department.id = position.department_id', 'left'); 

        
        //(SELECT GROUP_CONCAT(document SEPARATOR ", ") AS document FROM jd_received_docs
        //LEFT JOIN jd_document ON jd_document.id = jd_received_docs.docs_id 
        //WHERE jd_received_docs.sr_id = jd_received.id) AS document,
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
                    if ($field == 'received.date_sent') {
                        $array_date[1] =  'date_sent';
                        $array_date[0] = stripslashes($value);
                    } elseif ($field == 'received.date_received') {
                        $array_date[1] =  'date_received';
                        $array_date[0] = stripslashes($value);
                    } else {
                        $this->db->where($field, $value);
                    }
                    break;
                case 'custom':                    
                    $this->db->where($value, null, FALSE);           
                    break;
            }                
        }

        if($array_date[1] == 'date_sent'){
            $this->db->where("CAST(date_sent as datetime) BETWEEN {$array_date[0]}"); 
        }

        if($array_date[1] == 'date_received') {
            $this->db->where("CAST(date_received as datetime) BETWEEN {$array_date[0]}"); 
        }
        
        return $this->fetch_all($limit, $offset, $sort, $order);
    }
}