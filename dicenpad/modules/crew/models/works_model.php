<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-02-22
 */

class Works_model extends MY_Model
{
    private $_table_name = 'crew_employment';
    private $_primary_key = 'id';   

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

    public function _set_join()
    {
        $this->db->select($this->_table_name . '.*,
                        CONCAT ((12 * (YEAR(disembarked) - YEAR(embarked)) + (MONTH(disembarked) - MONTH(embarked))), " MONS") AS duration 
                        ', FALSE
        ); 
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

        $o_works = $this->search($search, null, $limit, $offset, $sort, $order);   

        if ($o_works->num_rows() == 0) {
            return FALSE;
        } else {
            $works = array();
            $this->load->library('crew/works');

            foreach ($o_works->result() as $rwork) {
                $cache = Cache::get_instance();
                $work = $cache::get('work' . $rwork->id);

                if (!$work) {
                    $o_work = new Works($rwork->id);
                    $work = $o_work->getData();
                    $cache::save('work' . $rwork->id, $work);
                }

                $works[] = $work;
            }

            return $works;
        }
    }

    public function check_works ($param)
    {   
        $sql  = "SELECT crew_id FROM jd_crew_employment ";
        $sql .= "WHERE crew_id = " . $param['crew_id'];
        $sql .= " AND '" . $param['entry'] . "' BETWEEN embarked AND disembarked ";
        $sql .= "ORDER BY embarked DESC";

        $work = $this->db->query($sql);
        if ($work->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }
}