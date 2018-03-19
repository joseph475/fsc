<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-06-18
 */

class Send_model extends MY_Model
{
    private $_table_name = 'send_received';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'crew_id', 'date_received', 'date_sent'
    );
    
    protected $_search_fields = array(
        'date_received','lastname', 'firstname', 'date_sent',
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
        $this->db->select($this->_table_name . '.*, IF(jd_send_received.date_received <> "", DATE_FORMAT(date_received, "%d %b %y"), "") AS dr, 
                IF(jd_send_received.date_sent <> "", DATE_FORMAT(date_sent, "%d %b %y"), "") AS ds, DATE_FORMAT(date_check, "%d %b %y") AS dc, 
                IF(jd_send_received.date_received <> "", DATE_FORMAT(date_received, "%m/%d/%Y"), "") AS dte_rec, 
                IF(jd_send_received.date_check <> "", DATE_FORMAT(date_check, "%m/%d/%Y"), "") AS dte_check,   
                CONCAT(lastname, ", ", firstname, " " , middlename) as fullname, position.code, position.position, 
                position.position, position.code, crew.birthdate, crew.birthplace, crew.pres_address, crew.crew_id, crew.gender, crew.photo, crew.hash,
                principal.fullname as principal, principal.address as prin_address, department.option as department,                      
                CONCAT(jd_principal.telno1, IF(jd_principal.telno2 <>"", CONCAT(", ", jd_principal.telno2), ""), IF(jd_principal.telno3 <>"", CONCAT(", ", jd_principal.telno3), "")) AS principal_tel,             
                vessels.vessel_name, vessels.official_nos, vessels.imo_nos, vessels.gross, flag.flag
                ', FALSE
        );

        $this->db->join('crew', 'crew.crew_id = send_received.crew_id', 'left');  
        $this->db->join('position', 'position.id = crew.position_id', 'left');   
        $this->db->join('vessels', 'vessels.id = send_received.vessel_id', 'left'); 
        $this->db->join('flag', 'flag.id = vessels.flag_id', 'left'); 
        $this->db->join('principal', 'principal.id = vessels.principal_id', 'left'); 
        $this->db->join('department', 'department.id = position.department_id', 'left'); 

        
        //(SELECT GROUP_CONCAT(document SEPARATOR ", ") AS document FROM jd_send_received_docs
        //LEFT JOIN jd_document ON jd_document.id = jd_send_received_docs.docs_id 
        //WHERE jd_send_received_docs.sr_id = jd_send_received.id) AS document,
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
                    if ($field == 'send_received.date_sent') {
                        $array_date[1] =  'date_sent';
                        $array_date[0] = stripslashes($value);
                    } elseif ($field == 'send_received.date_received') {
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