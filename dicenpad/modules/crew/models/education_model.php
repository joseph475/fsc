<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-02-22
 */

class education_model extends MY_Model
{
    private $_table_name = 'crew_education';
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

    public function get_by_crew($crew, $limit = null, $offset = null, $sort = null, $order = 'desc')
    {                
        $search = array(
            array(
                'type'  => 'eq',
                'field' => 'crew_id',
                'value' => $crew
            )
        );

        $ci =& get_instance();
        
        $o_educs = $this->search($search, null, $limit, $offset, $sort, $order);

        if ($o_educs->num_rows() == 0) {
            return FALSE;
        } else {
            $education = array();
            $this->load->library('crew/education');

            foreach ($o_educs->result() as $reduc) {
                $cache = Cache::get_instance();
                $educ = $cache::get('educ' . $reduc->id);

                if (!$educ) {
                    $o_educ = new Education($reduc->id);
                    $educ = $o_educ->getData();
                    $cache::save('educ' . $reduc->id, $educ);
                }

                $education[] = $educ;
            }

            return $education;
        }
    }
}