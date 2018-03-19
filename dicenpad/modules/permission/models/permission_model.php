<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Permission_model extends MY_Model
{
    private $_table_name = 'admin_permission';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'type_id'
    );
    
    protected $_search_fields = array( 
        'jd_admin_resource.resource_code'
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
        $this->db->select($this->_table_name . '.*, admin_role.role_code, admin_role.role, admin_role.role_order, 
            admin_resource.resource_code, admin_resource.resource, admin_resource.default_value', FALSE
        );

        $this->db->join('admin_role', 'admin_role.role_id = admin_permission.type_id', 'left');
        $this->db->join('admin_resource', 'admin_resource.resource_id = admin_permission.resource_id', 'left');    
    }
}