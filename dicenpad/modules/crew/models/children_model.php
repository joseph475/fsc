<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-02-22
 */

class Children_model extends MY_Model
{
    private $_table_name = 'crew_child';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'crew_id'
    );

    protected $_search_fields = array(
        'crew_id'
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
        $this->db->select($this->_table_name . '.*, DATE_FORMAT(child_birthdate, "%m/%d/%y") AS child_birthdate',
            FALSE
        );
    }

    public function get_by_crew($crew_id)
    {
        $this->db->order_by('id', 'asc');
        $children = $this->get($crew_id, 'crew_id');

        $c = array();
        if ($children) {
            if (!is_array($children)) {
                $children = array($children);
            }
            
            foreach ($children as $child) {
                $o_c = new Children($child);
                $c[] = $o_c->getData();
            }

            return $c;
        }

        return FALSE;
    }
}