<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_generator_controller extends Front_Controller
{

	protected $report_deploy = true;
	protected $profile;

	public function __construct()
	{
		parent::__construct();

		ini_set('memory_limit', '-1');

		$this->config->set_item('compress_output', FALSE);
		$this->profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') {
			redirect ('admin');
		}
	}

	public function generate_report()
	{
		if(count($_POST) == 0) redirect('admin');
		$setting = array('inPDF' => $this->report_deploy, 'paper_size' => 0, 'orientation' => 'portrait' );
		$crew = new stdClass();
		$checklist = new stdClass();
		$vessel = new stdClass();

		$crew_id 		= $this->input->post('crew_id');
		$pos2 			= $this->input->post('position_id1');
    	$vessel_id 		= $this->input->post('vessel_id');
    	$salary_id 		= $this->input->post('position_id');
    	$company_id 	= $this->input->post('company_id');
    	$poh 			= $this->input->post('point_of_hire');
    	$duration 		= $this->input->post('duration');
    	$signatory1 	= $this->input->post('signatory1');
    	$signatory2 	= $this->input->post('signatory2');
    	$remarks1 		= $this->input->post('remarks1');
    	$remarks2 		= $this->input->post('remarks2');
    	$status 		= $this->input->post('status');

    	$chk_202		= $this->input->post('chk_202');
    	$chk_203		= $this->input->post('chk_203');
    	$chk_204		= $this->input->post('chk_204');
    	$chk_205		= $this->input->post('chk_205');
    	$chk_207		= $this->input->post('chk_207');
    	$chk_208		= $this->input->post('chk_208');
    	$chk_212		= $this->input->post('chk_212');
    	$chk_209		= $this->input->post('chk_209');
    	$chk_235		= $this->input->post('chk_235');

    	$type1			= $this->input->post('type1');
    	$type2			= $this->input->post('type2');
    	$type3			= $this->input->post('type3');
    	$type4			= $this->input->post('type4');


    //	$pstatus 		= $this->input->post('status');
    	
    	//$date		    = date('F d, Y', strtotime($this->input->post('date')));

		$date		    = date('F d, Y', strtotime($this->input->post('date')));

    	$vessel = $this->rest->get('vessel', array('id' => $vessel_id), 'json');
    	$type_id = ($vessel)? $vessel->vtype_id : 0;

    	$crew = $this->rest->get('crew', array('id' => $crew_id), 'json');
    	$salary = $this->rest->get('salary', array('id' => $salary_id), 'json');
    	if(!$salary->id) {
    		$salary->validity_from = '';
    		$salary->validity_to = '';
    		$salary->bargain = '';
    		$salary->overtime = '';
    		$salary->ot_fixed = '';
    		$salary->s_allowance = '';
    		$salary->cba = '';
    	}
    	$position_id = ($salary->id != 0)? $salary->position_id : 0;
  
    	$position = $this->rest->get('position', array('id' => $position_id), 'json');

    	if(!$crew->crew_id) redirect('admin');

    	$checklist = $this->rest->get('checklist_endorse_crews', 
			array(
				'crew_id'	   	=> $crew_id,
				'vessel_id'	   	=> $vessel_id,
				'position_id'	=> $position_id,			
				'type_id'		=> $type_id,	
				'sort'		   	=> 'jd_document.sort_order',
				'order'		   	=> 'asc',
				'limit'		   	=> '250'
				), 'json');
    	//$crew = (object) array_merge((array) $salary, (array) $position, (array) $vessel->about,(array) $crew);
    	$crew = (object) array_merge((array) $salary, (array) $crew);


    	//$crew->docs 			= isset($checklist->data)? $checklist->data : '';
    	$crew->docs 			= $checklist->data;

    	$crew->remarks1 		= $remarks1;
    	$crew->pos2 			= $pos2;
    	$crew->remarks2			= $remarks2;

    	$crew->chk_202			= $chk_202;
    	$crew->chk_203			= $chk_203;
    	$crew->chk_204			= $chk_204;
    	$crew->chk_205			= $chk_205;
    	$crew->chk_207			= $chk_207;
    	$crew->chk_208			= $chk_208;
    	$crew->chk_209			= $chk_209;
    	$crew->chk_212			= $chk_212;
    	$crew->chk_235			= $chk_235;

    	$crew->type1			= $type1;
    	$crew->type2			= $type2;
    	$crew->type3			= $type3;
    	$crew->type4			= $type4;

    	//$crew->vessel_id1 		= $vessel_id;

    	$crew->docs 			= $checklist->data;

		$crew->vessel_name 		= $vessel->prefix . ' ' . $vessel->vessel_name;
		$crew->date 			= $date;
		$crew->company_id 		= $company_id;
		$crew->point_of_hire 	= $poh;
		$crew->duration 		= $duration;
		$crew->type 			= $vessel->vessel_type;
		$crew->department_id	= $position->department_id;
		$crew->division_id 		= $position->division_id;
		$crew->department 		= isset($position->department)? $position->department : '';
		$crew->division 		= isset($position->division)? $position->division : '';
		$crew->position 		= isset($position->alternate)? $position->alternate : '';
		$crew->flag 			= $vessel->flag;
		$crew->flag_id 			= $vessel->flag_id;
		$crew->vessel_id 		= $vessel->id;
		$crew->validity 		= isset($crew->validity_from)? $crew->validity_from : '';
		$crew->validity_to 		= isset($crew->validity_to)? $crew->validity_to : '';
		$crew->cba  			= isset($crew->cba)? $crew->cba : '';
		$crew->vessel_sub_type  = $vessel->vessel_sub_type;
		$crew->classification  	= $vessel->classification;
		$crew->registered  		= $vessel->registered;
		$crew->imo_nos  		= $vessel->imo_nos;
		$crew->gross  			= $vessel->gross;
		$crew->e_year  			= $vessel->e_year;
		$crew->control_nos  	= $vessel->control_nos;
		//$crew->bargain  		= ($crew->cba == "IBF-JSU/AMOSUP IMMAJ")? "IBF-JSU/AMOSUP IMMAJ / (Validity: " . (($crew->validity_from)? date('F d, Y', strtotime($crew->validity_from)) : '') . " - " . (($crew->validity_to)? date('F d, Y', strtotime($crew->validity_to)) : '') . ")" : "NON-CBA";
		$crew->principal  		= $vessel->principal;
		$crew->prin_address  	= $vessel->prin_address;
		$crew->principal_tel  	= $vessel->telno1;
		$crew->prin_email  		= $vessel->prin_email;
		$crew->basic_salary 	= $salary->basic_salary;
		$crew->contractstatus 	= $status;
		//$crew->pstatus 	= $status;
		$crew->edu				= is_array($crew->education)? $crew->education[0]->school : '';

		// $rema = new stdClass(); 
		// $rema->remarks1 		= $remarks1;
		// $rema->remarks2 		= $remarks2;

		$signa = new stdClass(); 
		$signa->poea1 		= strtoupper(trim(substr($signatory1, 0 , strpos($signatory1, "-"))));
		$signa->poea1pos 	= strtoupper(trim(substr($signatory1, strpos($signatory1, "-") + 1)));
		$signa->poea2 		= strtoupper(trim(substr($signatory2, 0 , strpos($signatory2, "-"))));
		$signa->poea2pos 	= strtoupper(trim(substr($signatory2, strpos($signatory2, "-") + 1)));
		$signa->check1 		= strtoupper(trim(substr($signatory1, 0 , strpos($signatory1, "-"))));
		$signa->check1pos 	= strtoupper(trim(substr($signatory1, strpos($signatory1, "-") + 1)));
		$signa->check2 		= strtoupper(trim(substr($signatory2, 0 , strpos($signatory2, "-"))));
		$signa->check2pos 	= strtoupper(trim(substr($signatory2, strpos($signatory2, "-") + 1)));
		$crew->signatory 	= $signa;

		$crew->birthdate = ($crew->birthdate != '')?  date('m/d/Y', strtotime($crew->birthdate)) : '';

		if($crew->civil_status == 'Single') {
			$benef = array();

			$all = new stdClass();
			$all->id = 0;
			$all->crew_id = $crew->crew_id;
			$all->child_name = $crew->father;
			$all->child_birthdate = ($crew->father_bdate != '')? date('m/d/Y', strtotime($crew->father_bdate)) : '';
			$all->child_address = $crew->father_add;
			$all->relationship  = 'Father';
			$all->child_gender  = 'Male';
			$all->child_telephone  =  $crew->father_telephone;
			$benef[0] = $all;

			$all = new stdClass();
			$all->id = 1;
			$all->crew_id = $crew->crew_id;
			$all->child_name = $crew->mother;
			$all->child_birthdate = ($crew->mother_bdate != '')? date('m/d/Y', strtotime($crew->mother_bdate)) : '';
			$all->child_address = $crew->mother_add;
			$all->relationship  = 'Mother';
			$all->child_gender  = 'Female';
			$all->child_telephone  =  $crew->mother_telephone;

			$benef[1] = $all;

			for($x=2; $x <= 3; $x++){
				$all = new stdClass();
				$all->id = $x;
				$all->crew_id = '';
				$all->child_name =  '&nbsp;';
				$all->child_birthdate =  '';
				$all->child_address =  '';
				$all->relationship  =  '';
				$all->child_gender  =  '';
				$all->child_telephone  =   '';
				$benef[$x] = $all;
			}
			$crew->beneficiaries = $benef;
		} else {
			//if($crew->spouse != "") {
				$all = new stdClass();
				$all->id = 0;
				$all->crew_id = $crew->crew_id;
				//if($crew->spouse != "") {
					$all->child_name = $crew->spouse;
					$all->child_birthdate = ($crew->spouse_bdate != '')? date('m/d/Y', strtotime($crew->spouse_bdate)) : '';
					$all->child_address = $crew->spouse_add;
					$all->relationship  = 'Wife';
					$all->child_gender  = 'Female';
					$all->child_telephone  =  $crew->spouse_telephone;
				//}

				if($crew->children) {
					array_unshift($crew->children, $all);
					$crew->beneficiaries = $crew->children;
				} else {
					$benef = array();
					$benef[0] = $all;

					for($x=1; $x <= 2; $x++){
				$all = new stdClass();
					$all->id = $x;
					$all->crew_id = '';
					$all->child_name =  '&nbsp;';
					$all->child_birthdate =  '';
					$all->child_address =  '';
					$all->relationship  =  '';
					$all->child_gender  =  '';
					$all->child_telephone  =   '';
					$benef[$x] = $all;
				}

					$crew->beneficiaries = $benef;
				}
			//} 
		}


		//dbug($crew->beneficiaries);
		switch ($this->input->post('report_type')) {
			case 0:
				unset($checklist);
				
		    	$checklist = $this->rest->get('checklist_endorse_crews', 
					array(
						'crew_id'	   	=> $crew_id,
						'vessel_id'	   	=> $vessel_id,
						'position_id'	=> $position_id,			
						'type_id'		=> $type_id,
						'published'	   	=> 1,
						'sort'		   	=> 'sort_order, sub_order, checklist.sub_order',
						'order'		   	=> 'asc',
						'limit'		   	=> '250'
						), 'json');

		    	if(!isset($checklist->data)) redirect('admin');

		    	$checklist->signatory 		= $signa;
		    	$checklist->fullname 		= $crew->fullname;
				$checklist->rank 			= $position->position;
				$checklist->vessel_name 	= $vessel->prefix . ' ' . $vessel->vessel_name;
				$checklist->type 			= $vessel->vessel_type;
				$checklist->date 			= $date;

				$checklist->company_id 		= $company_id;
				$checklist->flag 			= $vessel->flag;
		//		$checklist->flag_id 		= $crew->flag_id;

				$setting = array_merge((array) $setting, array('data' => $checklist, 'file_loc' => 'checklist/crew_endorse_checklist', 'name' => 'crew-checklist' ));
				break;

			case 1:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/standard', 'name' => 'standard-history-card' ));		    	
				break;

			case 2:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/fukunaga', 'name' => 'fukunaga-history-card' ));		    	
				break;

			case 3:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/ecl_officer', 'name' => 'ecl-history-card-officer' ));		    	
				break;

			case 4:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/ecl_ratings', 'name' => 'ecl-history-card-ratings' ));		    	
				break;
			
			case 5:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/excel_officer', 'name' => 'excel-history-card-officer' ));		    	
				break;

			case 6:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/excel_ratings', 'name' => 'excel-history-card-ratings' ));		    	
				break;

			case 7:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/janfield_officer', 'name' => 'janfield-history-card-officer' ));		    	
				break;

			case 8:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/janfield_ratings', 'name' => 'janfield-history-card-ratings' ));		    	
				break;

			case 9:
				$setting = array_merge((array) $setting, array('data' => $crew, 'paper_size' => 1,  'file_loc' => 'poea/contract', 'name' => 'poea-contract' ));		    	
				break;

			case 10:

				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'poea/information', 'name' => 'poea-information-sheet' ));		    	
				break;

			case 11:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'poea/seafarer', 'name' => 'seafarer-employment-contract' ));		    	
				break;

			case 12:
				$setting = array_merge((array) $setting, array('data' => $crew, 'orientation' => 'landscape', 'file_loc' => 'rps/regular', 'name' => 'rps-regular' ));		    	
				break;

			case 13:
				$setting = array_merge((array) $setting, array('data' => $crew, 'orientation' => 'landscape', 'file_loc' => 'rps/verification', 'name' => 'rps-verification' ));		    	
				break;

			case 14:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/wave_officer', 'name' => 'wave-history-card-officer' ));		    	
				break;

			case 15:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/wave_ratings', 'name' => 'wave-history-card-ratings' ));		    	
				break;

			case 16:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/fuyoh_officer', 'name' => 'fuyoh-history-card-officer' ));		    	
				break;

			case 17:
				$setting = array_merge((array) $setting, array('data' => $crew, 'file_loc' => 'history_card/fuyoh_ratings', 'name' => 'fuyoh-history-card-ratings' ));		    	
				break;

			case 18:
				$setting = array_merge((array) $setting, array('data' => $crew, 'paper_size' => 1,  'file_loc' => 'poea/contract_cadet', 'name' => 'poea-contract-cadet' ));		    	
				break;

			case 19:

				$setting = array_merge((array) $setting, array('data' => $crew, 'paper_size' => 1,  'file_loc' => 'poea/ofw_infosheet', 'name' => 'ofw-information-sheet' ));
				break;

			case 20:

				$setting = array_merge((array) $setting, array('data' => $crew, 'paper_size' => 2,  'file_loc' => 'panama/application_for_certificate', 'name' => 'Application_for_Certificate' ));

				break;

			case 21:

				$setting = array_merge((array) $setting, array('data' => $crew, 'paper_size' => 2,  'file_loc' => 'panama/panama_checklist', 'name' => 'panama_checklist' ));		    	
				break;
			
			default:
				# code...
				break;
		}

		$this->pdf_footer($setting);
	}

	public function generate_report2()
	{
		if(count($_POST) == 0) redirect('admin');
		$setting = array('inPDF' => $this->report_deploy, 'paper_size' => 0, 'orientation' => 'portrait' );
		$poea = new stdClass();

		$poea->signatory = select_signatory($this->profile->user_id);

    	$onboard_id 	= $this->input->post('onboard_id');
    	$crew_id 		= $this->input->post('crew_id');
    	$purpose 		= $this->input->post('purpose');
    	$date 			= date('F d, Y', strtotime($this->input->post('date')));

		$poea = $this->rest->get('onboard', array('id'	=> $onboard_id), 'json');	

		$personal = $this->rest->get('crew', array('id'	=> $crew_id), 'json');

		if(!isset($poea)) redirect('poea-rps-list');
		$poea->date = $date;

		$personal->birthdate = ($personal->birthdate != '')?  date('m/d/Y', strtotime($personal->birthdate)) : '';
		$obj_merged = (object) array_merge((array) $personal, (array) $poea);
		if($personal->civil_status == 'Single') {
			$benef = array();

			$all = new stdClass();
			$all->id = 0;
			$all->crew_id = $personal->crew_id;
			$all->child_name = $personal->father;
			$all->child_birthdate = ($personal->father_bdate != '')? date('m/d/Y', strtotime($personal->father_bdate)) : '';
			$all->child_address = $personal->father_add;
			$all->relationship  = 'Father';
			$all->child_gender  = 'Male';
			$all->child_telephone  =  $personal->father_telephone;
			$benef[0] = $all;

			$all = new stdClass();
			$all->id = 1;
			$all->crew_id = $personal->crew_id;
			$all->child_name = $personal->mother;
			$all->child_birthdate = ($personal->mother_bdate != '')? date('m/d/Y', strtotime($personal->mother_bdate)) : '';
			$all->child_address = $personal->mother_add;
			$all->relationship  = 'Mother';
			$all->child_gender  = 'Female';
			$all->child_telephone  =  $personal->mother_telephone;

			$benef[1] = $all;

			for($x=2; $x <= 3; $x++){
				$all = new stdClass();
				$all->id = $x;
				$all->crew_id = '';
				$all->child_name =  '&nbsp;';
				$all->child_birthdate =  '';
				$all->child_address =  '';
				$all->relationship  =  '';
				$all->child_gender  =  '';
				$all->child_telephone  =   '';
				$benef[$x] = $all;
			}
			$obj_merged->beneficiaries = $benef;
		} else {
			if($personal->spouse != "") {
				$all = new stdClass();
				$all->id = 0;
				$all->crew_id = $personal->crew_id;
				$all->child_name = $personal->spouse;
				$all->child_birthdate = ($personal->spouse_bdate != '')? date('m/d/Y', strtotime($personal->spouse_bdate)) : '';
				$all->child_address = $personal->spouse_add;
				$all->relationship  = 'Wife';
				$all->child_gender  = 'Female';
				$all->child_telephone  =  $personal->spouse_telephone;
				if($personal->children) {
					array_unshift($personal->children, $all);
					$obj_merged->beneficiaries = $personal->children;
				} else {
					$benef = array();
					$benef[0] = $all;

					for($x=1; $x <= 2; $x++){
				$all = new stdClass();
					$all->id = $x;
					$all->crew_id = '';
					$all->child_name =  '&nbsp;';
					$all->child_birthdate =  '';
					$all->child_address =  '';
					$all->relationship  =  '';
					$all->child_gender  =  '';
					$all->child_telephone  =   '';
					$benef[$x] = $all;
				}

					$obj_merged->beneficiaries = $benef;
				}
			} 
		}

    	switch ($this->input->post('report_type')) {
			case 0:
				$setting = array_merge((array) $setting, array('data' => $poea, 'file_loc' => 'poea/seafarer', 'name' => 'seafarer-employment-contract' ));		    	
				break;

			case 1:	
				$setting = array_merge((array) $setting, array('data' => $poea, 'paper_size' => 1,  'file_loc' => 'poea/contract', 'name' => 'poea-contract' ));		    	
				break;

			case 2:

				$setting = array_merge((array) $setting, array('data' => $obj_merged, 'file_loc' => 'poea/information', 'name' => 'poea-information-sheet' ));		    	
				break;

			case 3:
				$setting = array_merge((array) $setting, array('data' => $poea, 'orientation' => 'landscape', 'file_loc' => 'rps/regular', 'name' => 'rps-regular' ));		    	
				break;

			case 4:
				$setting = array_merge((array) $setting, array('data' => $poea, 'orientation' => 'landscape', 'file_loc' => 'rps/verification', 'name' => 'rps-verification' ));		    	
				break;

			case 5:
				$poea->purpose = $purpose;
				$poea->issued = $date;
				$setting = array_merge((array) $setting, array('data' => $poea, 'file_loc' => 'crew/certification', 'name' => 'crew-certification' ));		    	
				break;
			default:
				# code...
				break;
		}
				

		$this->pdf_footer($setting);
	}

	// --------------------------------------------------------------------

	private function pdf_footer($setting = array())
	{	
		$data = ($setting['data'])? $setting['data'] : '';
		if ($setting['inPDF']) {
			//$setting['paper_size'] = 0;\
			//$size = ($setting['paper_size'] == 0)? 'A4' : array(0,0,612.00,1008.0); //array(0,0,612.00,792.00)


			switch ($setting['paper_size']) {

			case 0:
				$size = 'A4';
			break;

			case 1:
				$size = array(0,0,612.00,1008.0);
			break;

			case 2:
				$size = 'letter';
			break;

			default:

			break;
		}

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

		$setting['PAPER_SIZE'] = 'A4';

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