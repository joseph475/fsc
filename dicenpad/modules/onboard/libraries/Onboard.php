<?php
/**
 * This class represents an crew (single crew).
 */
class Onboard extends Base
{
	// Default values
	protected $_data = array(
		'onboard_id' 		=> 0, 
		'sched_id'			=> 0,
		'crew_id' 			=> 0,
		'history_id' 		=> 0,
		'vessel_id' 		=> 0,
		'vessel_old_id' 	=> '',
		'principal_id'		=> 0,
		'principal_old_id'	=> '',
		'position_id'		=> 0,
		'position'			=> '',
		'salary_id' 		=> 0, 
		'reference'			=> 0,
		'department_id'		=> 0,
		'vessel_old_id' 	=> '',
		'joining_port' 		=> '', 
		'trade'				=> '',
		'original_date' 	=> '0000-00-00', 
		'start_date' 		=> '0000-00-00', 
		'end_date' 			=> '0000-00-00', 
		'extension_date'	=> '0000-00-00',
		'month_duration'	=> 0,
		'duration' 			=> '', 
		'remarks' 			=> '', 
		'onboard_status'	=> '',
		'class_id'			=> '',
		'oec_nos' 			=> 0, 
		'pdos_nos' 			=> 0, 
		'pdos_date' 		=> '0000-00-00', 
		'point_of_hire' 	=> '', 
		'disembarked' 		=> '0000-00-00', 
		'reason' 			=> '', 
		'port' 				=> '', 
		'arrival_date' 		=> '0000-00-00', 
		'next_joining' 			=> '0000-00-00', 
		'performance_grade' 	=> '0', 
		'isdone' 				=> 0, 
		'finished_remarks' 		=> '',
		'finished_others' 		=> '',
		'unfinished_accounts1' 	=> '',
		'unfinished_accounts2' 	=> '',
		'unfinished_accounts3' 	=> '',
		'unfinished_hearing1' 	=> '',
		'unfinished_hearing2'	=> '',
		'unfinished_hearing3' 	=> '',
		'unfinished_hearing4' 	=> '',
		'unfinished_remarks' 	=> '',
		'unfinished_case' 		=> '',
		'unfinished_legal' 		=> '0',
		'unfinished_surety' 	=> '0',
		'unfinished_insurance' 	=> '0',
		'unfinished_settlement' => '',
		'pi_club' 		=> '',
		'pi_hospital1' 	=> '',
		'pi_hospital2' 	=> '',
		'pi_hospital3' 	=> '',
		'pi_progress1' 	=> '',
		'pi_progress2' 	=> '',
		'pi_progress3' 	=> '',
		'pi_sick1' 		=> '',
		'pi_sick2' 		=> '',
		'pi_fit' 		=> '',
		'pi_submission' => '',
		'pi_approval'	=> '',
		'pi_settlement'	=> '',
		'date_created' 	=> '0000-00-00', 
		'createdbypk' 	=> 0, 
		'date_modified' => '0000-00-00', 
		'modifiedbypk'	=> 0
		);


	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('onboard_model', '' ,true);

        return $CI->onboard_model;
	}

	// --------------------------------------------------------------------

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();
		return parent::delete();
	}

	// --------------------------------------------------------------------

	public function getChild()
	{
		$ci =& get_instance();

		$ci->load->library('crew/children');

        return $ci->children->getModel()->get_by_crew($this->crew_id);
	}
	
	public function getData()
	{		
		$data 					= parent::getData(); 
		$data['beneficiaries']  = $this->getChild();

		return $data;		
	}
}