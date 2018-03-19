<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-10-23
 */

class Contact_model extends MY_Model
{
    private $_table_name = 'user_contact';
    private $_primary_key = 'id';	

	// --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    public function get_by_user($user_id)
    {
        $this->db->order_by('is_primary', 'desc');
        $contacts = $this->get($user_id, 'user_id');

        $c = array();
        if ($contacts) {
            if (!is_array($contacts)) {
                $contacts = array($contacts);
            }
            
            foreach ($contacts as $contact) {
                $o_c = new Contact($contact);
                $c[] = $o_c->getData();
            }

            return $c;
        }

        return FALSE;
    }
}