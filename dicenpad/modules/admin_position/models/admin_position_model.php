<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class admin_position_model extends MY_Model
{
    private $_table_name = 'admin_position';
    private $_primary_key = 'position_id';	

    protected $_allowed_filters = array(
        'position_code', 'inactive'
    );
    
    protected $_search_fields = array(
        'position'
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