<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Division_model extends MY_Model
{
    private $_table_name = 'division';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'option_code', 'exclude_ids', 'deleted'
    );
    
    protected $_search_fields = array(
        'jd_division.option', 'option_code'
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