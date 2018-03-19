<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_report_controller extends Front_Controller
{

	protected $report_deploy = true;
	protected $profile;

	public function __construct()
	{
		parent::__construct();

		ini_set('memory_limit', '-1');

		$this->config->set_item('compress_output', FALSE);

		// Check if user has parent access to this controller.
		// if (!is_allowed(getclass($this))) {
		// 	show_404();
		// }

		$this->profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') {
			redirect ('admin');
		}
	}

	// --------------------------------------------------------------------
	/**
	* Show a history card
	* 
	* @param int $user sched_id
	*/
	
	public function schedule_replacement($ref = null)
	{
		$schedule = $this->rest->get('schedule', array('ref' => $ref), 'json');

		if($schedule) {
			$joining = $this->rest->get('joinings', 
						array(
							'sched_id'	   => $schedule->id,
							'sort'		   => 'jd_position.sort_order',
							'order'		   => 'asc'
							), 'json');	

			$repat = $this->rest->get('repats', 
						array(
							'sched_id'	   => $schedule->id,
							'sort'		   => 'jd_position.sort_order',
							'order'		   => 'asc'
							), 'json');	

			$promotion = $this->rest->get('promotions', 
						array(
							'sched_id'	   => $schedule->id,
							'sort'		   => 'jd_schedule_p.id',
							'order'		   => 'asc'
							), 'json');	

			$join_flight = $this->rest->get('flights', 
						array(
							'type'		   => 'join',	
							'sched_id'	   => $schedule->id,
							'sort'		   => 'flight_date',
							'order'		   => 'asc',
							'limit'		   => 25
							), 'json');	

			$repat_flight = $this->rest->get('flights', 
						array(
							'type'		   => 'repat',	
							'sched_id'	   => $schedule->id,
							'sort'		   => 'flight_date',
							'order'		   => 'asc',
							'limit'		   => 25
							), 'json');	

			$schedule->join_flight	= isset($join_flight->data)? $join_flight->data : ''; 
			$schedule->repat_flight = isset($repat_flight->data)? $repat_flight->data : ''; 
			$schedule->joining 		= isset($joining->data)? $joining->data : ''; 
			$schedule->repat 		= isset($repat->data)? $repat->data : '';
			$schedule->promotion 	= isset($promotion->data)? $promotion->data : ''; 
			
			if ($principal_id == 39){
			$setting = array('inPDF' => $this->report_deploy , 'data' =>  $schedule, 'file_loc' => 'replacement/schedule_plan_santoku',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'schedule-plan-santoku' );	
			}
			else{
			$setting = array('inPDF' => $this->report_deploy , 'data' =>  $schedule, 'file_loc' => 'replacement/schedule_plan',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'schedule-plan' );	
			}
				
			$this->pdf_footer($setting);
		} else {
			redirect('schedule-list');
		}
	}

	public function contract_review($date = null)
	{	
		$joining = $this->rest->get('replacement_plans', 
						array(
							'joining_date' => $date,
							'sort'		   => 'joining_date',
							'order'		   => 'desc',
							'limit'		   => 1000
							), 'json');	

		$joining->signatory = select_signatory($this->profile->user_id);

		if(!isset($joining->data)) redirect('crew-replacement-plan');

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $joining, 'file_loc' => 'replacement/contract_review',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'crew-contract-review-and-replacement-plan' );

		$this->pdf_footer($setting);

	}

	public function daily_replacement_plan($ref = null)
	{
		$setting = array('inPDF' => $this->report_deploy, 'data' =>  null, 'file_loc' => 'replacement/daily_replacement_plan',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'daily-crew-replacement-plan' );

		$this->pdf_footer($setting);

	}

	public function ammended_list($ref = null)
	{
		$setting = array('inPDF' => $this->report_deploy, 'data' =>  null, 'file_loc' => 'replacement/ammended_list',
						 'paper_size' => 0, 'orientation' => 'landscape', 'name' => 'ammended-list-of-candidates' );

		$this->pdf_footer($setting);

	}

	public function embarkation_list($key1=null, $key1a=null, $key2=null, $key3=null) 
	{
		$params = array(
					'sort'			=> 'jd_position.sort_order',
					'order'			=> 'asc',
					'limit'			=> '10000'
				);

		if($key1 != 0) $params['vessel_id'] = $key1;

		$vessel = $this->rest->get('vessel', array('id' => (int) $key1), 'json');

		$filter = '';

		switch ($key1a) {
		 	case 0:
		 		# SEARCHING BY DATE
		 		$key2 = date('Y-m-d', strtotime($key2));
				$key3 = date('Y-m-d', strtotime($key3));

		 		$params['start_date'] = "'{$key2}' AND '{$key3}'";

		 		$filter = 'Filter from the date of ' . date('F d, y', strtotime($key2)) . ' to ' . date('F d, y', strtotime($key3));
		 		break;
		 	case 1:
		 		# SEARCHING BY MONTH
		 		$key2 = date('Y-m-01', strtotime($key2));
				$key3 = date('Y-m-t', strtotime($key2));

				$params['start_date'] = "'{$key2}' AND '{$key3}'";

				$filter = 'Filter from Month of ' . date('F Y', strtotime($key2));
		 		break;
		 	default:
		 		# code...
		 		break;
		} 

		$status = $this->rest->get('crew_status', $params, 'json');	
		$status->vessel_name 	= $vessel->vessel_name;
		$status->filter 		= $filter;

		if(!isset($status->data)) redirect('embarkation-list');

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $status, 'file_loc' => 'schedule/embarkation',
						 'paper_size' => 0, 'orientation' => 'landscape', 'name' => 'embarkation-list' );

		$this->pdf_footer($setting);
	}

	public function disembarkation_list($key1=null, $key1a=null, $key2=null, $key3=null) 
	{
		$params = array(
					'vessel_id'		=> $key1,
					'isdone'		=> 0,
					'sort'			=> 'jd_position.sort_order',
					'order'			=> 'asc',
					'limit'			=> '10000'
				);

		$vessel = $this->rest->get('vessel', array('id' => (int) $key1), 'json');

		$filter = '';

		switch ($key1a) {
		 	case 1:
		 		# SEARCHING BY DATE
		 		$key2 = date('Y-m-d', strtotime(urlencode($key2)));
				$key3 = date('Y-m-d', strtotime(urlencode($key3)));

		 		$params['end_date'] = "'{$key2}' AND '{$key3}'";

		 		$filter = 'Filter from the date of ' . date('F d, y', strtotime($key2)) . ' to ' . date('F d, y', strtotime($key3));
		 		break;
		 	case 2:
		 		# SEARCHING BY MONTH
		 		$key2 = date('Y-m-01', strtotime($key2));
				$key3 = date('Y-m-t', strtotime($key2));

				$params['end_date'] = "'{$key2}' AND '{$key3}'";

				$filter = 'Filter from Month of ' . date('F Y', strtotime($key2));
		 		break;
		 	default:
		 		# code...
		 		break;
		} 

		$status = $this->rest->get('crew_status', $params, 'json');	
		$status->vessel_name 	= $vessel->vessel_name;
		$status->filter 		= $filter;
		
		if(!isset($status->data)) redirect('crew-list');

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $status, 'file_loc' => 'schedule/disembarkation',
						 'paper_size' => 0, 'orientation' => 'landscape', 'name' => 'disembarkation-list' );

		$this->pdf_footer($setting);
	}


	// --------------------------------------------------------------------

	private function pdf_footer($setting = array())
	{	
		$data = ($setting['data'])? $setting['data'] : '';

		if ($setting['inPDF']) {
			$size = ($setting['paper_size'] == 0)? array(0,0,612.00,792.00) : array(0,0,612.00,1008.0);
			$this->load->library('pdf_dom');
			$this->pdf_dom->set_paper($size, $setting['orientation']);
			$this->pdf_dom->load_view($setting['file_loc'], $data);
			$this->pdf_dom->render();
			$this->pdf_dom->stream(strtoupper($setting['name']) . ".pdf", array("Attachment" => 0));
		} else {
			$this->load->view($setting['file_loc'], $data);
		}		
	}

}