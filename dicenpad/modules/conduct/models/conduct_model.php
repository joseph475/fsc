<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-02-21
 */

class Conduct_model extends MY_Model
{
    private $_table_name = 'conduct';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'crew_id', 'date_receive', 'date_year'
    );
    
    protected $_search_fields = array(
        'date_receive', 'jd_crew.lastname', 'jd_crew.firstname', 'jd_crew.fullname'
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
        $this->db->select($this->_table_name . '.*, DATE_FORMAT(date_receive, "%d %b %y") AS date_received, CONCAT(lastname, ", ", firstname, " " , middlename) as fullname, position.code, position.position, 
                position.position, position.code, crew.birthdate, crew.birthplace, crew.pres_address, crew.crew_id, crew.gender, crew.photo, crew.hash,
                principal.fullname as principal, principal.address as prin_address, department.option as department,                      
                CONCAT(jd_principal.telno1, IF(jd_principal.telno2 <>"", CONCAT(", ", jd_principal.telno2), ""), IF(jd_principal.telno3 <>"", CONCAT(", ", jd_principal.telno3), "")) AS principal_tel,             
                vessels.vessel_name, vessels.official_nos, vessels.imo_nos, vessels.gross, flag.flag
                ', FALSE
        );

        $this->db->join('crew', 'crew.crew_id = conduct.crew_id', 'left');  
        $this->db->join('position', 'position.id = crew.position_id', 'left');   
        $this->db->join('vessels', 'vessels.id = conduct.vessel_id', 'left'); 
        $this->db->join('flag', 'flag.id = vessels.flag_id', 'left'); 
        $this->db->join('principal', 'principal.id = vessels.principal_id', 'left'); 
        $this->db->join('department', 'department.id = position.department_id', 'left'); 
    }


}