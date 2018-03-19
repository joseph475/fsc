<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-16
 */

class Vessel_crew_model extends MY_Model
{
    private $_table_name = 'crew_vessel';
    private $_primary_key = 'onboard_id';	

    protected $_allowed_filters = array(
        'crew_id', 'vessel_id', 'status', 'isdone'
    );
    
    protected $_search_fields = array(
        'crew_id', 'fullname'
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