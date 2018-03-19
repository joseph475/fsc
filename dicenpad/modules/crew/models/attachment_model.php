<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-07-9
 */

class Attachment_model extends MY_Model
{
    private $_table_name = 'crew_attachment';
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

    public function get_by_crew($crew_id)
    {
        $this->db->order_by('id', 'asc');
        $attachment = $this->get($crew_id, 'crew_id');

        $c = array();
        if ($attachment) {
            if (!is_array($attachment)) {
                $attachment = array($attachment);
            }
            
            foreach ($attachment as $attach) {
                $o_c = new Attachment($attach);
                $c[] = $o_c->getData();
            }

            return $c;
        }

        return FALSE;
    }
}