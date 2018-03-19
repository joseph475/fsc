<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-02-22
 */

class Work_history_model extends MY_Model
{
    private $_table_name = 'work_history';
    private $_primary_key = 'crew_id';   

    protected $_allowed_filters = array(
        'crew_id'
    );
    
    // --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    public function search($key, $value = 0, $limit = null, $offset = null, $sort = null, $order ='desc')
    {
        if (!is_array($key))
        {
            $key = array ($key);
        }

        foreach ($key as $field)
        {
            if (is_array($field)) {     
                if (isset($field['value'])) {
                    $value = $field['value'];
                }

                $field = $field['field'];
            }
        }

        $sql = "SELECT * FROM (SELECT crew_id, company, vessel, flag, rank, grt, type as TYPE, engine as ENGINE, 
                trade, embarked, disembarked, remarks, 1 AS isdone, 0 AS vessel_id, '' as ex_vessel
                FROM jd_crew_employment
                WHERE crew_id = {$value} AND crew_id NOT IN 
                    (SELECT crew_id FROM jd_onboard WHERE 
                        crew_id = jd_crew_employment.crew_id AND 
                        embarked = jd_crew_employment.embarked
                    )
                UNION ALL 
                SELECT crew_id, jd_admin_company.company, jd_vessels.vessel_name AS vessel, jd_flag.flag, jd_position.code AS rank, 
                jd_vessels.gross AS grt, jd_type_sub.title AS TYPE, jd_vessels.engine as ENGINE, 
                jd_onboard.trade, embarked, IF(extension_date = '0000-00-00', disembarked, CONCAT(disembarked, '<br/> <small>promoted/change position</small>')) disembarked,
                jd_onboard.remarks, isdone, jd_onboard.vessel_id, jd_vessels.ex_vessel_name AS ex_vessel
                FROM jd_onboard 
                INNER JOIN jd_vessels ON jd_vessels.id = jd_onboard.vessel_id 
                INNER JOIN jd_position ON jd_position.id = jd_onboard.position_id
                INNER JOIN jd_salary ON jd_salary.id = jd_onboard.salary_id
                LEFT JOIN jd_schedule_h ON jd_schedule_h.id = jd_onboard.sched_id
                LEFT JOIN jd_admin_company ON jd_admin_company.company_id = jd_schedule_h.company_id
                LEFT JOIN jd_type_sub ON jd_type_sub.id = jd_vessels.type_id
                LEFT JOIN jd_flag ON jd_flag.id = jd_vessels.flag_id
                WHERE crew_id = {$value}) t1 ";
        
        if (is_null($sort)) {
            $sql .= "ORDER BY embarked DESC ";
        } else {
            $sql .= "ORDER BY {$sort} {$order} ";
        }

        if($limit) {
            $sql .= ' LIMIT ' . $limit . (($offset)? ', ' . $offset : '');
        }

        $rs = $this->db->query($sql); 
        return $rs;

    }

    public function get_by_crew($crew, $limit = null, $offset = null, $sort = 'embarked', $order = 'desc')
    {            

        $search = array(
            array(
                'type'  => 'eq',
                'field' => 'crew_id',
                'value' => $crew
            )
        );

        $ci =& get_instance();

        $statement = "SELECT * FROM (SELECT crew_id, company, vessel, flag, rank, grt, type, engine , 
                trade, embarked, disembarked, remarks, 1 AS isdone, 0 AS vessel_id,
                CONCAT ((12 * (YEAR(disembarked) - YEAR(embarked)) + (MONTH(disembarked) - MONTH(embarked))), ' MONS') AS duration
                FROM jd_crew_employment
                WHERE crew_id = {$crew} AND crew_id NOT IN 
                    (SELECT crew_id FROM jd_onboard WHERE 
                        crew_id = jd_crew_employment.crew_id AND 
                        embarked = jd_crew_employment.embarked
                    )
                UNION ALL 
                SELECT crew_id, jd_admin_company.company, jd_vessels.vessel_name AS vessel, jd_flag.flag, jd_position.code AS rank, 
                jd_vessels.gross AS grt, jd_type_sub.title as type , jd_vessels.engine , 
                jd_onboard.trade, embarked, disembarked, jd_onboard.remarks, isdone, jd_onboard.vessel_id,
                CONCAT ((12 * (YEAR(IF(disembarked='0000-00-00', end_date, disembarked)) - YEAR(embarked)) + (MONTH(IF(disembarked='0000-00-00', end_date, disembarked)) - MONTH(embarked))), ' MONS') AS duration
                FROM jd_onboard 
                INNER JOIN jd_vessels ON jd_vessels.id = jd_onboard.vessel_id 
                INNER JOIN jd_position ON jd_position.id = jd_onboard.position_id
                INNER JOIN jd_salary ON jd_salary.id = jd_onboard.salary_id
                LEFT JOIN jd_schedule_h ON jd_schedule_h.id = jd_onboard.sched_id
                LEFT JOIN jd_admin_company ON jd_admin_company.company_id = jd_schedule_h.company_id
                LEFT JOIN jd_type_sub ON jd_type_sub.id = jd_vessels.type_id
                LEFT JOIN jd_flag ON jd_flag.id = jd_vessels.flag_id
                WHERE crew_id = {$crew}) t1 ORDER BY embarked desc LIMIT 10";

        $o_works = $this->db->query($statement);

        //$o_works = $this->search($search, null, $limit, $offset, $sort, $order);


        if ($o_works->num_rows() == 0) {
            return FALSE;
        } else {
            $works = array();
            $this->load->library('crew/work_history');
            return $o_works->result();

            // foreach ($o_works->result() as $rwork) {
            //     $cache = Cache::get_instance();
            //     $work = $cache::get('work_history' . $rwork->crew_id);

            //     if (!$work) {
            //         $o_work = new Work_history($crew->crew_id);
            //         $work = $o_work->getData();
            //         $cache::save('work_history' . $rwork->crew_id, $work);
            //     }

            //     $works[] = $work;
            // }

            // return $works;
        }
    }
}