<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-16
 */

class Flight_model extends MY_Model
{
    private $_table_name = 'schedule_flight';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'sched_id', 'flight_date', 'type'
    );
    
    protected $_search_fields = array(
        'sched_id', 'flight_date'
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
        $this->db->select($this->_table_name .".*, IF(flight_date = '', '', DATE_FORMAT(flight_date, '%d-%b-%y')) AS fd, 
                    CONCAT(
                        IF(origin = '', '', origin), 
                        IF(destination = '', '', CONCAT(IF(origin = '', '', '/'), destination))
                    ) 
                    AS orides",
            FALSE
        );

        $this->db->join('schedule_h', 'schedule_h.id = schedule_flight.sched_id', 'left');  
    }

    
}