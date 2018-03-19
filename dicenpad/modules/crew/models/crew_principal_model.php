<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Crew_principal_model extends MY_Model
{
    private $_table_name = 'vw_crew_list';
    private $_primary_key = 'crew_id';	

    protected $_allowed_filters = array(
        'crew_id', 'vessel_id','principal_id', 'lastname', 'firstname', 'position_id',
        'status_id', 'department_id' 
    );
    
    protected $_search_fields = array(
        'crew_id', 'lastname', 'firstname'
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
            position.position, position.code, position.department_id, position.division_id, department.option as department,
            division.option as division, admin_options.option as status, admin_options.option_group,
            CONCAT(jd_vessels.prefix, " ", jd_vessels.vessel_name) as vessel_name,
            principal.fullname AS principal, principal.telno1, principal.email as prin_email, principal.address AS prin_address,
            (SELECT remarks FROM jd_crew_remarks 
                    WHERE jd_crew_remarks.crew_id = jd_vw_crew_list.crew_id
                    ORDER BY id DESC LIMIT  1
                ) AS manager_comment
             ',
            FALSE
        );

        $this->db->join('vessels', 'vessels.id = vw_crew_list.vessel_id', 'left');    
        $this->db->join('principal', 'principal.id = vw_crew_list.principal_id', 'left'); 
        $this->db->join('position', 'position.id = vw_crew_list.position_id', 'left');
        $this->db->join('division', 'division.id = position.division_id', 'left');    
        $this->db->join('department', 'department.id = position.department_id', 'left');  
        $this->db->join('admin_options', 'admin_options.option_id = vw_crew_list.status_id', 'left');  
    }

    public function get_by_array($array)
    {
        $this->db->where($array);
        $crew = $this->db->get('crew');
        if ($crew->num_rows() > 0) {
            $this->load->library('crew');
            $u = new Crew($crew->row()->crew_id);   
            return $u->getData();
        }

        return FALSE;
    }
   
}