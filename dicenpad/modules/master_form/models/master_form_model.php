<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-05-30
 */

class Master_form_model extends MY_Model
{
    private $_table_name = 'master_form';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'published'
    );
    
    protected $_search_fields = array(
        'title', 'control_nos'
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
        $this->db->select($this->_table_name . '.*, CONCAT(control_nos, " ", remarks) as iso,
            CONCAT(control_nos2, " ", remarks2) as iso2', FALSE); 
    }
   
}