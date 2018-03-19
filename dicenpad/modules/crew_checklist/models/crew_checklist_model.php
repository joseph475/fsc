<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class crew_checklist_model extends MY_Model
{
    private $_table_name = 'crew';
    private $_primary_key = 'crew_id';  

    protected $_allowed_filters = array(
        'crew_id' => 'crew', 'published' => 'checklist', 'vessel_id' => 'onboard',  
        'end_date' => 'onboard', 'start_date' => 'onboard', 'type_id' => 'checklist'
    );
    
    protected $_search_fields = array( 
        'fullname'
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
                crew.crew_id, crew.fullname, position.code , position.position, crew.date_hired, document.classify_id,
                crew_docs.docs_nos, document.document, type.title as vessel_type, type_sub.title as type,                 
                IF(jd_crew_docs.date_issued <> "", DATE_FORMAT(jd_crew_docs.date_issued,"%e-%b-%y"), "") AS date_iss,
                IF(jd_crew_docs.date_expired <> "", DATE_FORMAT(jd_crew_docs.date_expired,"%e-%b-%y"), "") AS date_expr,
                crew_docs.date_issued, crew_docs.date_expired,
                crew_docs.remarks, crew_docs.endorsement, crew_docs.file_docs,
                checklist.officer_deck, checklist.officer_engr, checklist.rating_deck, checklist.rating_engr, 
                checklist.rating_stwd, checklist.sort_order, checklist.sub_order,
                vessels.prefix, vessels.vessel_name, vessels.company_id, onboard.start_date, onboard.end_date, 
                onboard.disembarked, onboard.embarked, onboard.position_id ',  FALSE
        );
        
        $this->db->join('onboard', 'crew.crew_id = onboard.crew_id', 'inner');       
        $this->db->join('position', 'onboard.position_id = position.id', 'inner');  
        $this->db->join('vessels', 'onboard.vessel_id = vessels.id', 'inner');        
        $this->db->join('type_sub', 'type_sub.id = vessels.type_id', 'left');
        $this->db->join('type', 'type.id = type_sub.type_id', 'left');
        $this->db->join('crew_docs', 'crew.crew_id = crew_docs.crew_id', 'inner'); 
        $this->db->join('checklist', 'crew_docs.docs_id = checklist.docs_id', 'inner');  
        $this->db->join('document', 'jd_checklist.docs_id = document.id', 'inner');  
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
            $this->db->where("end_date >= {$array_date[0]} AND start_date <= {$array_date[0]} "); 
        }
        $this->db->where("((jd_document.hasflag = 0) OR (jd_document.hasflag = 1  AND jd_document.flag_id = jd_vessels.flag_id))"); 
        $this->db->where("(jd_document.division_id = jd_position.division_id OR jd_document.division_id = 0)"); 
        
        return $this->fetch_all($limit, $offset, $sort, $order);

    }

    /**
    *
    *  Fetch all rows.
    *  @return obj
    */
    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc')
    {
        $this->_set_join();

        if (is_null($sort)) {
            $this->db->order_by($this->_table_name . '.' . $this->_primary_key . ' ' . $order);
        } else {
            $this->db->order_by($sort . ' ' . $order);
        }   

        $this->db->order_by('checklist.sub_order ');

        return $this->db->get($this->_table_name, $limit, $offset);
    }

    public function get($key, $field = '')
    {   
        $this->db->limit(1);
        return parent::get($key, $field = '');        
    }


}