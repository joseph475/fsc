<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-07-22
 */

class Vessels_docs_model extends MY_Model
{
    private $_table_name = 'vessels_docs';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'vessel_id'
    );

    protected $_search_fields = array(
        'vessel_id'
    );

	// --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    public function get_by_vessel($vessel_id)
    {
        $this->db->order_by('id', 'asc');
        $vessel_docs = $this->get($vessel_id, 'vessel_id');

        $c = array();
        if ($vessel_docs) {
            if (!is_array($vessel_docs)) {
                $vessel_docs = array($vessel_docs);
            }
            
            foreach ($vessel_docs as $value) {
                $o_c = new Vessel_docs($value);
                $c[] = $o_c->getData();
            }

            return $c;
        }

        return FALSE;
    }
}