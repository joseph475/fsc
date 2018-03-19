<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History_card_controller extends Front_Controller
{

	protected $report_deploy = true;

	public function __construct()
	{
		parent::__construct();

		ini_set('memory_limit', '-1');

		$this->config->set_item('compress_output', FALSE);
	}

	// --------------------------------------------------------------------

	/**
	* Show a history card
	* 
	* @param int $user crew_id
	*/

	public function standard_hc($crew = null)
	{
		$personal = $this->rest->get('crew', array('hash' => $crew), 'json');
		if(!$personal->crew_id) redirect("resume/{$crew}");

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $personal, 'file_loc' => 'history_card/standard',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'standard-history-card');

		$this->pdf_footer($setting);
	}

	public function fukunaga_hc($crew = null)
	{
		$personal = $this->rest->get('crew', array('hash' => $crew), 'json');
		
		if(!$personal->crew_id) redirect("resume/{$crew}");

		$setting = array('inPDF' => $this->report_deploy, 'data' => $personal, 'file_loc' => 'history_card/fukunaga',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'fukunaga-history-card');

		$this->pdf_footer($setting);
	}

	public function ecl_hc($crew = null, $key2 = 'officer')
	{	
		$personal = $this->rest->get('crew', array('hash' => $crew), 'json');
		if(!$personal->crew_id) redirect("resume/{$crew}");

		$file_loc = 'history_card/ecl_officer';

		if($key2 == 'officer'){
			$file_loc = 'history_card/ecl_officer';
		} elseif($key2 == 'ratings'){
			$file_loc = 'history_card/ecl_ratings';
		}else {
			redirect("resume/{$crew}");
		}

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $personal, 'file_loc' => $file_loc,
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'ecl-history-card-' . $key2 );

		$this->pdf_footer($setting);
		
	}

	public function janfield_hc($crew = null, $key2 = 'officer')
	{	
		$personal = $this->rest->get('crew', array('hash' => $crew), 'json');
		
		if(!$personal->crew_id) redirect("resume/{$crew}");

		$file_loc = 'history_card/janfield_officer';

		if($key2 == 'officer'){
			$file_loc = 'history_card/janfield_officer';
		} elseif($key2 == 'ratings'){
			$file_loc = 'history_card/janfield_ratings';
		}else {
			redirect("resume/{$crew}");
		}

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $personal, 'file_loc' => $file_loc,
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'janfield-history-card-' . $key2 );

		$this->pdf_footer($setting);
		
	}

	public function excel_hc($crew = null, $key2 = 'officer')
	{
		$personal = $this->rest->get('crew', array('hash' => $crew), 'json');
		
		if(!$personal->crew_id) redirect("resume/{$crew}");

		$file_loc = 'history_card/excel_officer';

		if($key2 == 'officer'){
			$file_loc = 'history_card/excel_officer';
		} elseif($key2 == 'ratings'){
			$file_loc = 'history_card/excel_ratings';
		}else {
			redirect("resume/{$crew}");
		}

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $personal, 'file_loc' => $file_loc,
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'excel-history-card-' . $key2 );

		$this->pdf_footer($setting);
	}

    // --------------------------------------------------------------------

	/**
	* Show a user's crew.
	* 
	* @param int $user user_id
	*/
	public function crew_resume($crew = null)
	{			
		$personal = $this->rest->get('crew', array('hash' => $crew), 'json');

		if(!$personal->crew_id) redirect("resume/{$crew}");

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $personal, 'file_loc' => 'crew/resume',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'crew-resume' );

		$this->pdf_footer($setting);
		
	}

	/**
	* Show a user's crew.
	* 
	* @param int $user user_id
	*/
	public function crew_certification($key1 = null)
	{			
		$poea = $this->rest->get('onboard', array('id'	=> $key1), 'json');	

		if(!isset($poea)) redirect('poea-rps-list');

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $poea, 'file_loc' => 'crew/certification',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'crew-certification' );

		$this->pdf_footer($setting);		
	}	

	// --------------------------------------------------------------------

	/**
	* Show a user's crew.
	* 
	* @param int $user crew_id from crew table
	*/
	public function various_list($vessel_id = null, $company_id=1)
	{	
		$date = date('Y-m-d');

		$crews = new stdClass();
		$vessels = new stdClass();
		$vessels = $this->rest->get('vessel', 
			array(
				'id'			=> $vessel_id,
				'sort'		   	=> 'id',
				'order'		   	=> 'asc'
				), 'json');
				
		$crews = $this->rest->get('variouss', 
			array(
				'vessel_id'	   	=> $vessel_id,
				//'isdone'		=> 0,
				'end_date'		=> "'" . $date . "'",
				'sort'		   	=> 'position.sort_order',
				'order'		   	=> 'asc',
				'limit'			=> 30
				), 'json');		
	
		if($crews->_count == 0) redirect('various-list');

		$crews->vessel		= ($vessels)? $vessels : redirect('various-list');	

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $crews, 'file_loc' => 'crew/various_list',
						 'paper_size' => 1, 'orientation' => 'landscape', 'name' => 'various-list' );

		$this->pdf_footer($setting);
		
	}

	// --------------------------------------------------------------------
    public function crew_list()
    {
    	if(count($_POST) == 0) redirect('search-by-vessel');

		$date = date('Y-m-d', strtotime($this->input->post('date')));

		$vessel = $this->rest->get('vessel', array('id' => $this->input->post('vessel_id')), 'json');


		$crews = new stdClass();
		$crews = $this->rest->get('search_vessel', 
			array(
				'vessel_id'	   	=> $this->input->post('vessel_id'),
				'end_date'		=> "'" . $date . "'",
				//'isdone'		=> 0,
				'sort'		   	=> 'jd_position.sort_order, jd_onboard.start_date',
				'order'		   	=> 'asc',
				'limit'			=> 150
				), 'json');

		if($crews->_count == 0) redirect('search-by-vessel');

		$crews->vessel = $vessel->about;
		$crews->dateto = $date;	


		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $crews, 'file_loc' => 'crew/crew_list',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'crew-list' );


		$this->pdf_footer($setting);
    }

    // --------------------------------------------------------------------
    public function memo_list()
    {	
    	if(count($_POST) == 0) redirect('search-by-vessel');

		$date = date('Y-m-d', strtotime($this->input->post('date')));

		$vessel = $this->rest->get('vessel', array('id' => $this->input->post('vessel_id')), 'json');

		$crews = $this->rest->get('search_vessel', 
			array(
				'vessel_id'	   	=> $this->input->post('vessel_id'),
				'end_date'		=> "'" . $date . "'",
				//'isdone'		=> 0,
				'sort'		   	=> 'jd_position.sort_order, jd_onboard.start_date',
				'order'		   	=> 'asc',
				'limit'			=> 150
				), 'json');

		$data = $crews->data;

		// $data = array_filter($crews->data, function($i) {
		// 		global $date;
		// 		return trim($i->start_date) == $date;
		// 	});

		//dbug($data);

		if($crews->_count == 0) redirect('search-by-vessel');
	
		$setting = array('TITLE' => 'Ship and Crew Documents', 'ORIENTATION' => 'P', 'PAPER_SIZE' => 'A4');
    	$pdf = new stdClass();
    	$pdf = $this->tcdpf_setup($setting);

    	$pdf->setPrintHeader(false);

    	$tcpdf = new stdClass();
    	$tcpdf->pdf = $pdf;
    	$tcpdf->vessel_name = $vessel->prefix . ' ' . $vessel->vessel_name;
    	$tcpdf->results = $data;

    	$this->load->view('crew/memo_list', $tcpdf);
		
    }

    // --------------------------------------------------------------------
    public function drop_crew_list()
    {
    	if(count($_POST) == 0) redirect('search-by-vessel');

		$date = date('Y-m-d', strtotime($this->input->post('date')));

		$vessel = $this->rest->get('vessel', array('id' => $this->input->post('vessel_id')), 'json');

		$crews = $this->rest->get('drop_crewlists', 
			array(
				'vessel_id'	   	=> $this->input->post('vessel_id'),
				'end_date'		=> $date,
				//'isdone'		=> 0,
				'sort'		   	=> 't.sort_order, t.embarked',
				'order'		   	=> 'asc',
				'limit'			=> 150
				), 'json');

		if($crews->_count == 0) redirect('search-by-vessel');

		$crews->vessel_name = $vessel->prefix . ' ' . $vessel->vessel_name;
		$crews->control_nos = $vessel->control_nos;
		$crews->dateto = $date;	

		$setting = array('inPDF' => $this->report_deploy, 'data' =>  $crews, 'file_loc' => 'crew/drop_crewlist',
						 'paper_size' => 0, 'orientation' => 'portrait', 'name' => 'crew-list' );

		$this->pdf_footer($setting);
    }

    // --------------------------------------------------------------------
    public function drop_memo_list()
    {
    	if(count($_POST) == 0) redirect('search-by-vessel');

		$date = date('Y-m-d', strtotime($this->input->post('date')));

		$vessel = $this->rest->get('vessel', array('id' => $this->input->post('vessel_id')), 'json');

		$crews = $this->rest->get('drop_crewlists', 
			array(
				'vessel_id'	   	=> $this->input->post('vessel_id'),
				'end_date'		=> $date,
				//'isdone'		=> 0,
				'sort'		   	=> 't.sort_order, t.embarked',
				'order'		   	=> 'asc',
				'limit'			=> 150
				), 'json');

		if($crews->_count == 0) redirect('search-by-vessel');
	
		$setting = array('TITLE' => 'Ship and Crew Documents', 'ORIENTATION' => 'P', 'PAPER_SIZE' => 'A4');
    	$pdf = new stdClass();
    	$pdf = $this->tcdpf_setup($setting);

    	$pdf->setPrintHeader(false);

    	$tcpdf = new stdClass();
    	$tcpdf->pdf = $pdf;
    	$tcpdf->vessel_name = $vessel->prefix . ' ' . $vessel->vessel_name;
    	$tcpdf->results = $crews->data;

    	$this->load->view('crew/memo_list', $tcpdf);
    }

	// --------------------------------------------------------------------

	private function pdf_footer($setting = array())
	{	
		$data = ($setting['data'])? $setting['data'] : '';

		if ($setting['inPDF']) {
			$size = ($setting['paper_size'] == 0)? array(0,0,612.00,792.00) : array(0,0,612.00,1008.0);
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