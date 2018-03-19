<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-10-05
 */

class Users_model extends MY_Model
{
    private $_table_name = 'user';
    private $_primary_key = 'user_id';	

    protected $_allowed_filters = array(
        'department_id' => 'user_ref', 
        'position_id' => 'user_ref', 
        'company_id' => 'user_ref', 
        'role_id' => 'user_ref', 
        'exclude_ids'
    );
    
    protected $_search_fields = array(
        'CONCAT(first_name," ",last_name)', 
        'department', 
        'position', 
        'company'
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
        $this->db->select($this->_table_name . '.*,CONCAT(first_name, " ", last_name) as fullname, principal.fullname as principal_name,
            user_ref.position_id, user_ref.company_id, user_ref.division_id, user_ref.role_id, user_ref.principal_id, user_ref.job_title_id, user_ref.department_id, admin_position.position,
            admin_company.company, admin_department.department, user_about.photo, admin_role.role, admin_role.role_code',
            FALSE
        );
        //
        $this->db->join('user_ref', 'user_ref.user_id = user.user_id', 'left');
        $this->db->join('user_about', 'user_about.user_id = user.user_id', 'left');
        $this->db->join('admin_position', 'admin_position.position_id = user_ref.position_id', 'left');
        $this->db->join('admin_company', 'admin_company.company_id = user_ref.company_id', 'left');
        $this->db->join('admin_department', 'admin_department.department_id = user_ref.department_id', 'left');  
        $this->db->join('admin_role', 'admin_role.role_id = user_ref.role_id', 'left');      
        $this->db->join('principal', 'user_ref.principal_id = principal.id', 'left');      
    }

    // --------------------------------------------------------------------

    // /**
    // *
    // *  Handle saving or creating of new database entries.
    // *  @param $params array Data to be stored.
    // *  @return int
    // */
    // function do_save($params)
    // {        
    //     $id = parent::do_save($params);

    //     if ($id) {  

    //         $ref_model = new DummyModel('user_ref', 'user_id');

    //         $params['user_id'] = $id;
    //         $params['company_id'] = 2;
    //         $params['modified'] = date('Y-m-d H:i:s');

    //         $fields = $this->db->list_fields($ref_model->get_table_name());
            
    //         // Save only fields on database, so we don't have to use unset($params[]) to often.
    //         $valid_fields = array_intersect($fields, array_keys($params));
            
    //         $data = array();

    //         foreach ($valid_fields as $field) {
    //             if (!is_array($params[$field])) {
    //                 $_POST[$field] = $data[$field] = $params[$field];            
    //             }
    //         }   
            
    //         $ref_model->do_save($data); 

    //         $ref_model = new DummyModel('user_signature', 'user_id');

    //         $params2['user_id'] = $id;
    //         $params2['poea1'] = 'Baronda, Edgar C';
    //         $params2['poea2'] = 'Gatchalian, Antonio C';
    //         $params2['expire_doc'] = 'Dela Cruz, Maria Janis M';
    //         $params2['check1'] = 'Dela Cruz, Maria Janis M';
    //         $params2['check2'] = 'Bondoc, J M';

    //         $fields = $this->db->list_fields($ref_model->get_table_name());
            
    //         // Save only fields on database, so we don't have to use unset($params2[]) to often.
    //         $valid_fields = array_intersect($fields, array_keys($params2));
            
    //         $data2 = array();

    //         foreach ($valid_fields as $field) {
    //             if (!is_array($params2[$field])) {
    //                 $_POST[$field] = $data2[$field] = $params2[$field];            
    //             }
    //         }   
            
    //         $ref_model->do_save($data2); 

    //         return $id;
    //     }

    //     return FALSE;
    // }

    // --------------------------------------------------------------------

    /**
     * Adds a new record.
     *
     * @param array $params
     * @return mixed
     */
    function do_create($params) 
    {
        if (!isset($params['login'])) {
            $params['login'] = $params['first_name'] . $params['last_name'];            
        }

        $params['password'] = md5($params['password']);

        return parent::do_create($params);
    }

    // --------------------------------------------------------------------
    
    /**
     * Get user by employee ID.
     * 
     * @param  int $employee_id [Employee ID]
     * @return mixed FALSE if none, User object
     */
    public function get_by_employee_id($employee_id)
    {
        $this->db->where('employee_id', $employee_id);
        $ref = $this->db->get('user_ref');

        if ($ref->num_rows() == 0) {
            return FALSE;
        } else {
            $this->load->library('user');
            
            return new User($ref->row()->user_id);
        }
    } 

    // --------------------------------------------------------------------
    
    /**
     * Get array of username and passwords.
     *      
     * @return array
     */    
    public function get_login_array()
    {
        $this->db->select('login,password');
        $results = $this->db->get('user');
        $logins = array();
        if ($results->num_rows() > 0) {
            foreach ($results->result() as $user) {
                $logins[$user->login] = $user->password;
            }
        }

        return $logins;
    }

    // --------------------------------------------------------------------
    
    /**
     * Get by username and password.
     *      
     * @return array
     */    
    public function get_by_login($login, $password)
    {
        $this->db->where('login', $login);
        $this->db->where('password', $password);
        $user = $this->db->get('user');

        if ($user->num_rows() > 0) {
            $this->load->library('user');
            $u = new User($user->row()->user_id);            
            return $u->getData();
        }

        return FALSE;
    }

    public function delete($key)
    {
        if (!is_array($key))
        {
            $key = array($key);
        }

        $this->db->where_in('user_ref.user_id', $key);
        $this->db->delete('user_ref');
        $this->db->where_in('user_about.user_id', $key);
        $this->db->delete('user_about');
        $this->db->where_in('user_contact.user_id', $key);
        $this->db->delete('user_contact');
        $this->db->where_in('user_signature.user_id', $key);
        $this->db->delete('user_signature');

        parent::delete($key);  
    }
    
}