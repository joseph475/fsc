<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Principal_model extends MY_Model
{
    private $_table_name = 'principal';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'id', 'fullname', 'code', 'status'
    );
    
    protected $_search_fields = array(
        'id', 'fullname', 'code'
    );

	// --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }
   
}