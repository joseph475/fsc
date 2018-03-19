<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Vessels_model extends MY_Model
{
    private $_table_name = 'vessels';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'vessel_name', 'id', 'type_id', 
        'principal_id', 'flag_id', 'status'
    );
    
    protected $_search_fields = array(
        'jd_vessels.vessel_name', 
        'jd_vessels.e_year', 
        'jd_principal.fullname'
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
        $this->db->select($this->_table_name . '.*, type.id as vtype_id, type.title as vessel_type, type_sub.code as vessel_type_code,
            type_sub.title as vessel_sub_type, type_sub.code as vessel_sub_code, flag.code as flag_code, 
            flag.flag, principal.fullname AS principal, principal.telno1, principal.email as prin_email, principal.address AS prin_address',
            FALSE
        );

        $this->db->join('type_sub', 'type_sub.id = vessels.type_id', 'left');  
        $this->db->join('type', 'type.id = type_sub.type_id', 'left'); 
        $this->db->join('flag', 'flag.id = vessels.flag_id', 'left');
        $this->db->join('principal', 'vessels.principal_id = principal.id', 'left');
    }

   
}