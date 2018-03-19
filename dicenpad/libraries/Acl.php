<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Acl
{
	// Set the instance variable
	var $CI;

	function __construct()
	{
		// Get the instance
		$this->CI =& get_instance();

		// Set the include path and require the needed files
		$this->acl = new Zend_Acl();

		$sess = $this->CI->session->userdata;

		// Set the default ACL
		$this->acl->addRole(new Zend_Acl_Role('default'));
		$this->CI->db->cache_on();
		$query = $this->CI->db->get('admin_resource');		

		foreach($query->result() AS $row){
			$this->acl->add(new Zend_Acl_Resource($row->resource_code));
			if($row->default_value == 'true'){
				$this->acl->allow('default', $row->resource_code);
			}
		}

		// Get the ACL for the roles
		$this->CI->db->order_by("role_order", "ASC");
		if(isset($sess['role_id'])) $this->CI->db->where("role_id", $sess['role_id']);
		$query = $this->CI->db->get('admin_role');

		foreach($query->result() AS $row){
			$role = (string)$row->role;
			$this->acl->addRole(new Zend_Acl_Role($role), 'default');
			$this->CI->db->from('admin_permission');
			$this->CI->db->join('admin_resource', 'admin_resource.resource_id = admin_permission.resource_id');
			$this->CI->db->where('type', 'role');
			$this->CI->db->where('type_id', $row->role_id);
			$subquery = $this->CI->db->get();
			foreach($subquery->result() AS $subrow){
				$this->acl->{$subrow->i_read}($role, null, $subrow->resource_code . '_READ');
				$this->acl->{$subrow->i_delete}($role, null, $subrow->resource_code . '_DELETE');
				$this->acl->{$subrow->i_update}($role, null, $subrow->resource_code . '_UPDATE');
				$this->acl->{$subrow->i_insert}($role, null, $subrow->resource_code . '_INSERT');
				$this->acl->{$subrow->i_print}($role, null, $subrow->resource_code . '_PRINT');			
			}

			// Get the ACL for the users
			$this->CI->db->from('user_ref');			
			$this->CI->db->join('user', 'user.user_id = user_ref.user_id');
			$this->CI->db->where('role_id', $row->role_id);
			if(isset($sess['user_id'])) $this->CI->db->where("user.user_id", $sess['user_id']);
			$userquery = $this->CI->db->get();
		
			foreach($userquery->result() AS $userrow){
				$this->acl->addRole(new Zend_Acl_Role($userrow->login), $role);				
			}
		}
		$this->CI->db->cache_off();
		
	}

	// Function to check if the current or a preset role has access to a resource
	function check_acl($resource, $role = '')
	{		
		if (empty($role)) {
			if (isset($this->CI->session->userdata['login'])) {
				$role = $this->CI->session->userdata['login'];
			}
		}

		if (empty($role)) {
			return false;
		}
		
		// Check if user has all_access
		if ($this->acl->isAllowed($role, null, 'ALL_ACCESS_READ')) 
		{
			//return true;
		}

		return $this->acl->isAllowed($role, null, $resource);
	}
}