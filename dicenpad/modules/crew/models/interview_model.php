<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-10-23
 */

class Interview_model extends MY_Model
{
    private $_table_name = 'crew_interview';
    private $_primary_key = 'id';	

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
        $this->db->select($this->_table_name . '.*, position.position as rank_interview, 
            CONCAT(jd_vessels.prefix, " ", jd_vessels.vessel_name) as vesselname_interview ', FALSE
        );

        $this->db->join('position', 'crew_interview.position_id = position.id', 'left'); 
        $this->db->join('vessels', 'crew_interview.vessel_id = vessels.id', 'left');    
    }
}