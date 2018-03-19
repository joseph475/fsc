<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Document_various_model extends MY_Model
{
    private $_table_name = 'document_various';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'docs_id'
    );
    
    protected $_search_fields = array(
        'docs_id'
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
        $this->db->select($this->_table_name . '.*, document.document',
            FALSE
        );

        $this->db->join('document', 'document.id = document_various.docs_id', 'left');
    }
   
}