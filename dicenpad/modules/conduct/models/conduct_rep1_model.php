<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-02-21
 */

class Conduct_rep1_model extends MY_Model
{
    private $_table_name = 'conduct_report';
    private $_primary_key = 'vessel_id';	

    protected $_allowed_filters = array(
        'vessel_id', 'date_receive', 'date_receive_year'
    );
    
    protected $_search_fields = array(
        'date_receive'
    );

	// --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Fetch all rows.
    *  @return obj
    */
    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc')
    {
        $this->db->group_by('principal_id');

        return parent::fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc');
    }

}