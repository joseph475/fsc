<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-05-6
 */

class Expired_doc_model extends MY_Model
{
    private $_table_name = 'crew';
    private $_primary_key = 'crew_id'; 

    protected $_allowed_filters = array(
        'vessel_id' => 'onboard',
        'docs_id' => 'crew_docs',
        'date_expired'=> 'crew_docs',
        'isdone' => 'onboard'
    );
    
    protected $_search_fields = array(
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
                crew.crew_id, crew.fullname, position.code , position.position, crew.date_hired,
                crew_docs.docs_nos, document.document, type.title AS vessel_type, type_sub.title AS type, 
                DATE_FORMAT(jd_crew_docs.date_issued,"%d-%b-%y") AS date_issued,
                DATE_FORMAT(jd_crew_docs.date_expired,"%d-%b-%y") AS date_expired, 
                crew_docs.date_expired, crew_docs.remarks, crew_docs.endorsement, crew_docs.file_docs,
                CONCAT(jd_vessels.prefix, " ", jd_vessels.vessel_name) as vessel_name, onboard.start_date, onboard.end_date, 
                onboard.disembarked, onboard.embarked, onboard.position_id,crew.hash, ',  FALSE
        );

        $this->db->join('crew_docs', 'crew.crew_id = crew_docs.crew_id', 'inner');
        $this->db->join('onboard', 'crew.crew_id = onboard.crew_id', 'inner');  
        $this->db->join('document', 'crew_docs.docs_id = document.id', 'inner');  
        $this->db->join('vessels', 'onboard.vessel_id = vessels.id', 'inner');            
        $this->db->join('position', 'onboard.position_id = position.id', 'inner');    
        $this->db->join('type_sub', 'type_sub.id = vessels.type_id', 'left');
        $this->db->join('type', 'type.id = type_sub.type_id', 'left');
    }

    /**
     * Search function.
     *
     * @param mixed $key The field name/s.
     * @param mixed $value Value
     * @param int $limit
     * @param int $offset
     */
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

            if($field == 'crew_docs.date_expired') {
                //$value = stripslashes($value);  
                $value2 = date('Y-m-d', strtotime("+3 months", strtotime($value)));
                //STR_TO_DATE(`jd_crew_docs`.`date_expired`, '%m/%d/%Y') BETWEEN '1970-03-31' AND '2015-06-20'
                $this->db->where("STR_TO_DATE(jd_crew_docs.date_expired, '%m/%d/%Y') BETWEEN '{$value}' AND '{$value2}'"); 
                //$this->db->where('crew_docs.date_expired >', '1970-03-31');
                continue;
            }

            switch ($type) {
                case 'eq':
                    $this->db->where($field, $value);
                    break;
                case 'ne':
                    $this->db->where($field . ' !=', $value);
                    break;
                case 'bw':
                    $this->db->like($field, $value, 'before');
                    break;
                case 'ew':
                    $this->db->like($field, $value, 'after');
                    break;
                case 'bn':
                    $this->db->not_like($field, $value, 'before');
                    break;
                case 'en':
                    $this->db->not_like($field, $value, 'after');
                    break;
                case 'cn':
                    $this->db->like($field, $value);
                    break;
                case 'ocn':
                    $this->db->or_like($field, $value);
                    break;                    
                case 'nc':
                    $this->db->not_like($field, $value);
                    break; 
                case 'gt': 
                    $this->db->where($field . ' >', $value);              
                    break;
                case 'lt': 
                    $this->db->where($field . ' <', $value);
                    break;
                case 'gte': 
                    $this->db->where($field . ' >=', $value);              
                    break;
                case 'lte': 
                    $this->db->where($field . ' <=', $value);              
                    break;                    
                case 'in': 
                    $this->db->where_in($field, $value);              
                    break;
                case 'nin': 
                    $this->db->where_not_in($field, $value);              
                    break;
                case 'custom':                    
                    $this->db->where($value, null, FALSE);           
                    break;
            }            
        }
        
        return $this->fetch_all($limit, $offset, $sort, $order);
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Fetch all rows.
    *  @return obj
    */
     function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc')
    {
        $this->_set_join();

        if (is_null($sort)) {
            $this->db->order_by('jd_crew_docs.date_expired');        
        } else {
            $this->db->order_by($sort . ' ' . $order);
        }        

        return $this->db->get($this->_table_name, $limit, $offset);
    }
   
}