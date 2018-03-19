<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Promotion_history_model extends MY_Model
{
    private $_table_name = 'promotion_history';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'crew_id', 'promotion_date', 'deleted'
    );
    
    protected $_search_fields = array(
        'lastname', 'firstname', 'fullname'
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
        $this->db->select($this->_table_name .'.*, CONCAT(lastname, ", ", firstname, " " , middlename) AS fullname,
                crew.photo, crew.hash,
                pos1.position as prev_position, pos1.code as prev_position_code, 
                pos2.position as new_position, pos2.code as new_position_code,
                vessels.vessel_name 
            ',
            FALSE
        );

        $this->db->join('crew', 'crew.crew_id = promotion_history.crew_id', 'left');  
        $this->db->join('vessels', 'vessels.id = promotion_history.vessel_id', 'left');  
        $this->db->join('position as pos1', 'pos1.id = promotion_history.prev_pos_id', 'left');  
        $this->db->join('position as pos2', 'pos2.id = promotion_history.new_pos_id', 'left'); 
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
                    if ($field == 'promotion_history.promotion_date') {
                        $array_date[1] =  'promotion_date';
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

        if($array_date[1] == 'promotion_date') {
            $this->db->where("promotion_date BETWEEN {$array_date[0]}"); 
        }
        
        return $this->fetch_all($limit, $offset, $sort, $order);
    }
   
}