<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Flag_model extends MY_Model
{
    private $_table_name = 'flag';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'code', 'exclude_ids', 'published'
    );
    
    protected $_search_fields = array(
        'code', 'flag'
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