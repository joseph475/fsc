<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Ship_crew_document_model extends MY_Model
{
    private $_table_name = 'schedule_h';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'joining_date' => 'schedule_h',
        'vessel_id' => 'schedule_h',
        'control_nos' => 'schedule_h'

    );
    
    protected $_search_fields = array(
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
        $this->db->query('SET group_concat_max_len= 100000000');
        $this->db->select('jd_schedule_h.control_nos, jd_schedule_j.crew_id, CONCAT(lastname, " ", firstname, " ", middlename) AS fullname,  
                        jd_position.code, jd_position.position, joining_date, repat_date, vessel_id, vessel_name,
                        CONCAT(
                            "<li><b>", CONCAT(jd_position.code, " ",lastname, " ", firstname, " ", middlename), "</b> <br/> ",
                            (SELECT GROUP_CONCAT(document SEPARATOR ", ") FROM jd_crew_docs 
                            LEFT JOIN jd_document ON jd_document.id = jd_crew_docs.docs_id
                            WHERE jd_crew_docs.published = 1 AND jd_crew_docs.crew_id = jd_schedule_j.crew_id
                            AND jd_schedule_j.sched_id = jd_schedule_h.id
                            GROUP BY crew_id ORDER BY jd_document.defaults, jd_document.id ), "<br/></li>"
                        ) AS crew_document ,
                        (SELECT CONCAT("<ol type=\"1\">",TRIM(GROUP_CONCAT(CONCAT("<li>", documents, "</li>") SEPARATOR "&nbsp;")), "</ol>") AS ship_document FROM jd_vessels_docs 
                        WHERE jd_vessels_docs.published = 1 AND jd_vessels_docs.vessel_id = jd_schedule_h.vessel_id
                        GROUP BY vessel_id) AS ship_document',
            FALSE
        );

        $this->db->join('schedule_j', 'schedule_j.sched_id = schedule_j.sched_id', 'left');
        $this->db->join('crew', 'crew.crew_id = schedule_j.crew_id', 'left');   
        $this->db->join('position', 'position.id = crew.position_id', 'left');
        $this->db->join('vessels', 'vessels.id = schedule_h.vessel_id', 'left');        
    }

    /**
     * Search function.
     *
     * @param mixed $key The field name/s.
     * @param mixed $value Value
     * @param int $limit
     * @param int $offset
     */
    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc')
    {   
        $this->db->where('isembark', 1);

        return parent::fetch_all($limit = $limit, $offset = $offset, $sort = 'jd_position.sort_order', $order = $order);
    }
   
}