<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-04-11
 */

class Repat_model extends MY_Model
{
    private $_table_name = 'schedule_r';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'sched_id', 'isdisembark'
    );
    
    protected $_search_fields = array(
        'sched_id'
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
        $this->db->select($this->_table_name . '.*, crew.crew_id, crew.hash, crew.fullname, jd_position.code , jd_position.position,crew.birthdate, 
                        DATE_FORMAT(jd_onboard.original_date, "%m/%d/%Y") AS joining_date,
                        DATE_FORMAT(jd_onboard.disembarked, "%m/%d/%Y") as disembarked, DATE_FORMAT(jd_onboard.arrival_date, "%m/%d/%Y") as arrival_date,
                        DATE_FORMAT(jd_onboard.next_joining, "%m/%d/%Y") as next_joining, DATE_FORMAT(jd_onboard.unfinished_hearing1, "%m/%d/%Y") as unfinished_hearing1,
                        DATE_FORMAT(jd_onboard.unfinished_hearing2, "%m/%d/%Y") as unfinished_hearing2, DATE_FORMAT(jd_onboard.unfinished_hearing3, "%m/%d/%Y") as unfinished_hearing3,
                        DATE_FORMAT(jd_onboard.unfinished_hearing4, "%m/%d/%Y") as unfinished_hearing4, DATE_FORMAT(jd_onboard.pi_approval, "%m/%d/%Y") as pi_approval,
                        DATE_FORMAT(jd_onboard.pi_submission, "%m/%d/%Y") as pi_submission, DATE_FORMAT(jd_onboard.pi_fit, "%m/%d/%Y") as pi_fit,
                        onboard.pi_settlement, onboard.pi_progress3, onboard.pi_progress2, onboard.pi_progress1, onboard.pi_sick2, onboard.pi_sick1,
                        onboard.pi_hospital3, onboard.pi_hospital2, onboard.pi_hospital1, onboard.pi_club, onboard.unfinished_settlement, onboard.unfinished_insurance,
                        onboard.unfinished_surety, onboard.unfinished_legal, onboard.unfinished_case, onboard.unfinished_remarks, onboard.unfinished_hearing4,
                        onboard.unfinished_hearing3, onboard.unfinished_hearing2, onboard.unfinished_hearing1, onboard.unfinished_accounts3, onboard.unfinished_accounts2,
                        onboard.unfinished_accounts1, onboard.finished_others, onboard.remarks as onboard_remarks, onboard.performance_grade, onboard.reason, onboard.port, 
                        onboard.finished_remarks, onboard.duration, schedule_h.control_nos,
						(select docs_nos from jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 3) AS passport,
						(SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1) AS sirbno',
						FALSE
        );

        $this->db->join('onboard', 'onboard.onboard_id = schedule_r.onboard_id', 'left');
        $this->db->join('schedule_h', 'schedule_h.id = onboard.sched_id', 'left');
        $this->db->join('crew', 'crew.crew_id = schedule_r.crew_id', 'INNER');
        $this->db->join('position', 'position.id = schedule_r.position_id', 'INNER');  
    }

    function remove($key)
    {
        if (!is_array($key))
        {
            $key = array($key);
        }


        $this->load->library('sched/repat');
        $repat = new Repat($key); 
        $repat->load($key, $this->_primary_key);  

        if($repat->id){
            $this->load->library('crew');
            $crew = new Crew($repat->crew_id); 
            $crew->status_id    = 3;
            $crew->save();

            $this->load->library('Onboard2');
            $onboard = new Onboard2($repat->onboard_id); 

            $onboard->port              = '';    
            $onboard->reason            = '';  
            $onboard->performance_grade = '';  
            $onboard->disembarked       = '0000-00-00';
            $onboard->arrival_date      = '0000-00-00';
            $onboard->next_joining      = '0000-00-00';

            $onboard->finished_remarks          = '';  
            $onboard->finished_others           = '';  
            $onboard->unfinished_accounts1      = '';  
            $onboard->unfinished_accounts2      = '';  
            $onboard->unfinished_accounts3      = '';  
            $onboard->unfinished_hearing1       = '0000-00-00';
            $onboard->unfinished_hearing2       = '0000-00-00';
            $onboard->unfinished_hearing3       = '0000-00-00';
            $onboard->unfinished_hearing4       = '0000-00-00';
            $onboard->unfinished_remarks        = '';
            $onboard->unfinished_case           = '';
            $onboard->unfinished_legal          = '';
            $onboard->unfinished_surety         = '';
            $onboard->unfinished_insurance      = '';
            $onboard->unfinished_settlement     = '';
           
            $onboard->pi_club                   = '';
            $onboard->pi_hospital1              = '';
            $onboard->pi_hospital2              = '';
            $onboard->pi_hospital3              = '';
            $onboard->pi_progress1              = '';
            $onboard->pi_progress2              = '';
            $onboard->pi_progress3              = '';
            $onboard->pi_sick1                  = '';
            $onboard->pi_sick2                  = '';
            $onboard->pi_fit                    = '0000-00-00';
            $onboard->pi_submission             = '0000-00-00';
            $onboard->pi_approval               = '0000-00-00';
            $onboard->pi_settlement             = '0000-00-00';
            $onboard->isdone                    = 0;
            $onboard->save();
        }
        
        return parent::delete($repat->id);       
    }    
}