<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_report_controller extends Front_Controller
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
	* Show a user's crew.
	* 
	* @param int $user crew_id
	*/
	public function poea_contract($key1=null)
	{		
		$poea = $this->rest->get('onboard', array('id'	=> $key1), 'json');	

		$poea->signatory = select_signatory($this->profile->user_id);

		if(!isset($poea)) redirect('poea-rps-list');

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $poea, 'file_loc' => 'poea/contract',
						 'paper_size' => 1, 'orientation' => 'portrait', 'name' => 'poea-contract' );

		$this->pdf_footer($setting);		
	}

	/**
	* Show a user's crew.
	* 
	* @param int $user crew_id
	*/
	public function seafarer_document($key1=null)
	{		
		$poea = $this->rest->get('onboard', array('id'	=> $key1), 'json');	

		$poea->signatory = select_signatory($this->profile->user_id);

		if(!isset($poea)) redirect('poea-rps-list');

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $poea, 'file_loc' => 'poea/seafarer',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'seafarer-employment-contract' );

		$this->pdf_footer($setting);		
	}

	/**
	* Show a user's crew.
	* 
	* @param int $user crew_id
	*/
	public function poea_information_sheet($key1=null)
	{		
		$poea = $this->rest->get('onboard', array('id'	=> $key1), 'json');	

		$personal = $this->rest->get('crew', array('id'	=> $poea->crew_id), 'json');

		$obj_merged = (object) array_merge((array) $personal, (array) $poea);

		if(!isset($poea)) redirect('poea-rps-list');

		$all = new stdClass();
		$all->id = 0;
		$all->crew_id = $personal->crew_id;
		$all->child_name = $personal->beneficiary;
		$all->child_birthdate = '';
		$all->child_address = $personal->benef_add;
		$all->relationship  = $personal->benef_relation;
		
		if($obj_merged->beneficiaries) array_unshift($obj_merged->beneficiaries, $all);
		$obj_merged->birthdate = date('m/d/Y', strtotime($obj_merged->birthdate));

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $obj_merged, 'file_loc' => 'poea/information',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'poea-information-sheet' );

		$this->pdf_footer($setting);
		
	}

	// --------------------------------------------------------------------

	/**
	* Show a user's crew.
	* 
	* @param int $user crew_id
	*/
	public function rps_regular($key1=null)
	{				
		$rps = $this->rest->get('onboard', array('id'	=> $key1), 'json');	

		$rps->signatory = select_signatory($this->profile->user_id);

		if(!isset($rps)) redirect('poea-rps-list');

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $rps, 'file_loc' => 'rps/regular',
						 'paper_size' => 0, 'orientation' => 'landscape', 'name' => 'rps-regular' );

		$this->pdf_footer($setting);
	}

	/**
	* Show a user's crew.
	* 
	* @param int $user crew_id
	*/
	public function rps_verification($key1=null)
	{		
		$rps = $this->rest->get('onboard', array('id'	=> $key1), 'json');	

		$rps->signatory = select_signatory($this->profile->user_id);

		if(!isset($rps)) redirect('poea-rps-list');

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $rps, 'file_loc' => 'rps/verification',
						 'paper_size' => 0, 'orientation' => 'landscape', 'name' => 'rps-verification' );

		$this->pdf_footer($setting);
		
	}

	// --------------------------------------------------------------------


	/**
	* Show a user's crew.
	* 
	* @param int $user crew_id from onboard table
	*/
	public function table_content($crew_id = null, $page = 1)
	{		
		$crew = $this->rest->get('crew', 
			array(
				'id'	   	=> $crew_id,
				'sort'		=> 'crew_id',
				'order'		=> 'asc'
				), 'json');	

		$hash = ($crew->hash)? $crew->hash : 'nodatafound';

		if(!$crew) redirect('resume/' . $hash);

		$name = 'deck';
		if($page == 2){
			$name = 'deck';
		} elseif($page == 1){
			$name = 'engine';
		} else {
			redirect('resume/' . $hash);
		}

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $crew, 'file_loc' => "table_content/{$name}",
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => "table_content-{$name}" );

		$this->pdf_footer($setting);
		
	}

	// --------------------------------------------------------------------

	/**
	* Show a user's crew.
	* 
	* @param int $user crew_id from crew table
	*/

	public function expired_document($key1=null, $key2=null, $key3=null )
	{	
		$key2 = date('Y-m-d' , strtotime($key2));

		$param = array(
				'isdone'		=> 0,
				'date_expired'	=> $key2,
				'sort'			=> 'jd_crew.lastname',
				'order'			=> 'asc',
				'limit'			=> '200'
				);

		if($key1) $param['docs_id'] 	= $key1;
		if($key3) $param['vessel_id'] 	= $key3;

		$expired = $this->rest->get('expired_docs', $param, 'json');
		
		$expired->signatory = select_signatory($this->profile->user_id);

		$document = $this->rest->get('document', array('id' => (int) $key1), 'json');

		$expired->from 	= date('d-M-Y', strtotime($key2));
		$expired->docs 	= $document->document;

		if(!isset($expired->data)) redirect('expired-documents');

		$setting = array('inPDF' => $this->report_deploy, 'data' => $expired, 'file_loc' => 'document/expire',
						 'paper_size' => 0, 'orientation' => 'landscape', 'name' => 'expired-document' );

		$this->pdf_footer($setting);
	}

	
    // -------------------------------[ CHECKLIST ]-------------------------------------

    public function checklist_list($crew = null)
    {
    	$documents = new stdClass();

    	$array = array(102,122,121,103);

    	$hasdocs = FALSE;

    	foreach ($array as $key) {
    		$docs = $this->rest->get('checklist_crews', 
				array(
					'crew_id' 		=> $crew, 
					'classify_id'	=> $key,
					'published' 	=> '1',
					'sort'		   	=> 'sort_order',
					'order'		   	=> 'asc',
					'limit'			=> 150
				), 'json');

    		if(!isset($docs->data)){
    			continue;
    		} else {
    			$documents->{'d' . $key} = $docs->data;
    			$hasdocs = TRUE;
    		}    		
    	}

    	if($hasdocs);

		$setting = array('inPDF' => false, 'data' =>  $documents, 'file_loc' => 'checklist/list_type',
						 'paper_size' => 1, 'orientation' => 'portrait', 'name' => 'checklist-list-type' );

		$this->pdf_footer($setting);
    }

    public function crew_checklist_endorse()
    {
    	$data = $this->session->flashdata('lolwut');
    	if(!$data) redirect('admin');

    	$crew_id 		= $data['crew_id'];
    	$vessel_id 		= $data['vessel_id'];
    	$position_id 	= $data['position_id'];
    	$date 			= date('F d, Y', $data['date']);

    	$vessel = $this->rest->get('vessel', array('id' => $vessel_id), 'json');
    	$type_id = ($vessel)? $vessel->type_id : 0;

    	$crew = $this->rest->get('crew', array('id' => $crew_id), 'json');
    	$position = $this->rest->get('position', array('id' => $position_id), 'json');

    	$checklist = $this->rest->get('checklist_endorse_crews', 
			array(
				'crew_id'	   	=> $crew_id,
				'vessel_id'	   	=> $vessel_id,
				'position_id'	=> $position_id,			
				'type_id'		=> $type_id,	
				'published'	   	=> 1,
				'sort'		   	=> 'sort_order, sub_order',
				'order'		   	=> 'asc',
				'limit'		   	=> '250'
				), 'json');

    	if(!isset($checklist->data)) redirect('crew-check-list');

    	$checklist->signatory 		= select_signatory($this->profile->user_id);
    	$checklist->fullname 		= $crew->fullname;
		$checklist->rank 			= $position->position;
		$checklist->vessel_name 	= $vessel->prefix . ' ' . $vessel->vessel_name;
		$checklist->type 			= $vessel->vessel_type;
		$checklist->date 			= $date;

    	$setting = array('inPDF' => $this->report_deploy, 'data' => $checklist, 'file_loc' => 'checklist/crew_endorse_checklist',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'crew-checklist' );

		$this->pdf_footer($setting);
    
    }

    public function crew_checklist()
    {
    	if(count($_POST) == 0) redirect('search-by-vessel');

    	$date = date('Y-m-d', strtotime($this->input->post('date')));
    	$crew_id = $this->input->post('crew_id');

    	$checklist = $this->rest->get('checklist_crews', 
			array(
				'crew_id'	   	=> $crew_id,
				'vessel_id'	   	=> $this->input->post('vessel_id'),				
				'end_date'		=> "'" . $date . "'",
				'type_id'		=> $this->input->post('type_id'),	
				'published'	   	=> 1,
				'sort'		   	=> 'sort_order, sub_order',
				'order'		   	=> 'asc',
				'limit'		   	=> '250'
				), 'json');

    	$checklist->signatory = select_signatory($this->profile->user_id);

		if(!isset($checklist->data)) redirect('crew-check-list');

		$crew = $this->rest->get('checklist_crew', array('id' => $crew_id), 'json');

		$checklist->fullname 		= $crew->fullname;
		$checklist->rank 			= $crew->position;
		$checklist->vessel_name 	= $crew->prefix . ' ' . $crew->vessel_name;
		$checklist->type 			= $crew->vessel_type;
		$checklist->company_id 		= $crew->company_id;

		$setting = array('inPDF' => $this->report_deploy, 'data' => $checklist, 'file_loc' => 'checklist/crew_checklist',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'crew-checklist' );

		$this->pdf_footer($setting);
    }

    public function crew_checklist_list()
    {
    	if(count($_POST) == 0) redirect('search-by-vessel');
    	$date = date('Y-m-d', strtotime($this->input->post('date')));
    	$crew_id = $this->input->post('crew_id');

    	$checklist = $this->rest->get('checklist_crews', 
			array(
				'crew_id'	   => $crew_id,
				'vessel_id'	   => $this->input->post('vessel_id'),				
				'end_date'		=> "'" . $date . "'",
				'type_id'		=> $this->input->post('type_id'),	
				'published'	   => 1,
				'sort'		   => 'sort_order, sub_order',
				'order'		   => 'asc',
				'limit'		   => '250'
				), 'json');

		if(!isset($checklist->data)) redirect('crew-check-list');

		$crew = $this->rest->get('checklist_crew', array('id' =>  $crew_id), 'json');

		$checklist->fullname 		= $crew->fullname;
		$checklist->rank 			= $crew->position;
		$checklist->code 			= $crew->code;
		$checklist->vessel_name 	= $crew->prefix . ' ' . $crew->vessel_name;
		$checklist->company_id 		= $crew->company_id;

		$setting = array('inPDF' => $this->report_deploy, 'data' => $checklist, 'file_loc' => 'checklist/crew_checklist_list',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'crew-checklist-list-type' );

		$this->pdf_footer($setting);
    }

    public function crew_checklist_memo($key = null)
    {
    	$setting = array('TITLE' => 'Ship and Crew Documents', 'ORIENTATION' => 'P',
						 'PAPER_SIZE' => 'A4');

    	$sc_docs = $this->rest->get('sc_docs', 
			array(
			'control_nos'	=> $key,
			'sort'		   	=> 'jd_position.sort_order',
			'order'		   	=> 'asc',
			'limit'		   	=> '1000'
			), 'json');

    	$pdf = $this->tcdpf_setup($setting);

    	$pdf->setPrintHeader(false);

    	$tcpdf->pdf = $pdf;
    	$tcpdf->results = $sc_docs->data;

    	if(!isset($sc_docs->data)) redirect('schedule-list');

    	$this->load->view('checklist/crew_checklist_memo', $tcpdf);
    }

	// --------------------------------------------------------------------

	private function pdf_footer($setting = array())
	{	
		$data = ($setting['data'])? $setting['data'] : '';

		if ($setting['inPDF']) {
			//$setting['paper_size'] = 0;

			$size = ($setting['paper_size'] == 0)? 'A4' : array(0,0,612.00,1008.0); //array(0,0,612.00,792.00)
			$this->load->library('pdf_dom');
			$this->pdf_dom->set_paper($size, $setting['orientation']);
			$this->pdf_dom->load_view($setting['file_loc'], $data) ;
			$this->pdf_dom->render();
			$this->pdf_dom->stream(strtoupper($setting['name']) . ".pdf", array("Attachment" => 0));
		} else {
			$this->load->view($setting['file_loc'], $data);
		}		
	}

	private function tcdpf_setup($setting = array())
	{
		$this->load->library('pdf_tc');

		$pdf_tc = new pdf_tc($setting['ORIENTATION'], 'mm', $setting['PAPER_SIZE'], true, 'UTF-8', false);
		$pdf_tc->SetTitle($setting['TITLE']);
		$pdf_tc->SetHeaderMargin(30);
		$pdf_tc->SetTopMargin(20);
		$pdf_tc->setFooterMargin(20);
		$pdf_tc->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf_tc->SetAuthor('Jomel P. Dicen');
		$pdf_tc->SetDisplayMode('real', 'default');

		return $pdf_tc;
	}

}