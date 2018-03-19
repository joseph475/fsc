<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Agent_model extends MY_Model
{
    private $_table_name = 'agent';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'principal_id', 'published', 'status'
    );
    
    protected $_search_fields = array(
        'principal_id', 'jd_agent.fullname'
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
        $this->db->select($this->_table_name .'.*, principal.fullname as principal,
            CONCAT(jd_agent.telno1, IF(jd_agent.telno2 <>"", CONCAT(", ", jd_agent.telno2), ""), IF(jd_agent.telno3 <>"", CONCAT(", ", jd_agent.telno3), "")) AS agent_conctact,
            CONCAT(jd_agent.fax1, IF(jd_agent.fax2 <>"", CONCAT(", ", jd_agent.fax2), ""), IF(jd_agent.fax3 <>"", CONCAT(", ", jd_agent.fax3), "")) AS agent_fax',
            FALSE
        );

        $this->db->join('principal', 'principal.id = agent.principal_id', 'left');
    }
   
}