<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel_report_controller extends Front_Controller
{
	public function __construct()
	{
		parent::__construct();

		ini_set('memory_limit', '-1');

		$this->config->set_item('compress_output', FALSE);
		
		// Check if user has parent access to this controller.
		// if (!is_allowed(getclass($this))) {
		// 	show_404();
		// }

		$this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
	}

	public function vessel_list($key = null, $isprin = false)
	{		
		$setting = array('paper_size' => 1, 'orientation' => 1);

		$objPHPExcel = $this->excel_header($setting);

		$sheet = $objPHPExcel->getActiveSheet();

		if(!$key) redirect('vessels-list');

		$param = array('sort' => 'principal_id', 'order' => 'asc', 'limit' => 15000);

		if($isprin){
			$param['principal_id'] = (int) $key;

			$principal = $this->rest->get('principal', array('id' => (int) $key), 'json');
			$status = 'Principal ' . $principal->fullname;
		}else {
			$param['status'] = ($key != 'all')? $key : '';
			$status = ($key)? 'FILTER BY: ' .  ucwords($key) : '';	
		}

		$vessel = $this->rest->get('vessels', $param, 'json');
		$array = array('A1:R2','A4:R4','A5:R5');
		
		foreach ($array as $field):
		    $sheet->mergeCells($field);
		    $sheet->getStyle($field)->getFont()->setBold(true);
		endforeach;
		
		$styleArray = array(			    
					    'font' => array(
						    'bold' => true,
						    'size' => '12px',
						),
					    'borders' => array(
						    'outline' => array(
							    'style' => PHPExcel_Style_Border::BORDER_THIN,
							    'color' => array('argb' => '00000000'),
							),
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);
		$sheet->getStyle('A1:R2')->applyFromArray($styleArray);
		$sheet->getStyle("A4:R5")->getFont()->setSize("8px");
		$sheet->setCellValueByColumnAndRow(0, 1, 'VESSEL MASTER LIST');	
		$sheet->setCellValueByColumnAndRow(0, 4, $status);
		$sheet->setCellValueByColumnAndRow(0, 5, 'As of ' . date('M d, Y'));

		$array = array(	'A'=>'3', 'B'=>'15', 'C'=>'21', 'D'=>'22', 'E'=>'16', 'F'=>'20', 'G'=>'4' ,'H'=>'4', 'I'=>'4', 
						'J'=>'4', 'K'=>'4', 'L'=>'4', 'M'=>'5', 'N'=>'5', 'O'=>'4', 'P'=>'4', 'Q'=>'11', 'R'=>'9');

		foreach ($array as $field=>$value):	
			$sheet->getStyle("{$field}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getColumnDimension($field)->setWidth($value);
		endforeach;

		$styleArray = array(
						'font' => array(
							'bold' => true,
						    ),
						'borders' => array(
						    'outline' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN, //BORDER_THICK
									'color' => array('argb' => '00000000'),
								    ),
							),
						);
	
		$sheet->getStyle('A7:R7')->applyFromArray($styleArray);

		$array = array(	'No', 'Name', 'Principal' ,'Builder' , 'Built In', 'Engine', 
						'Year' ,'GRT', 'NET', 'DWT', 'Length', 'Depth', 'Breadth',
						'Cylinder', 'HP', 'Speed', 'Type', 'Flag'); 		
        $col = 0;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col, 7, $field);	   
            $col++;
        endforeach;

        $row = 9;

        //dbug($vessel->data);        

        if($vessel->data){
        	$counter = 0;
        	foreach ($vessel->data as $value) {
        		$counter++;        			

        		$sheet->setCellValueByColumnAndRow(0, $row, $counter);
				$sheet->setCellValueByColumnAndRow(1, $row, $value->vessel_name);
				$sheet->setCellValueByColumnAndRow(2, $row, $value->principal);
				$sheet->setCellValueByColumnAndRow(3, $row, $value->builder);
				$sheet->setCellValueByColumnAndRow(4, $row, $value->builtin);
				$sheet->setCellValueByColumnAndRow(5, $row, $value->engine);
				$sheet->setCellValueByColumnAndRow(6, $row, $value->e_year);
				$sheet->setCellValueByColumnAndRow(7, $row, $value->gross);
				$sheet->setCellValueByColumnAndRow(8, $row, $value->net);
				$sheet->setCellValueByColumnAndRow(9, $row, $value->dwt);
				$sheet->setCellValueByColumnAndRow(10, $row, $value->length);
				$sheet->setCellValueByColumnAndRow(11, $row, $value->depth);
				$sheet->setCellValueByColumnAndRow(12, $row, $value->breadth);
				$sheet->setCellValueByColumnAndRow(13, $row, $value->cylinder);
				$sheet->setCellValueByColumnAndRow(14, $row, $value->hp);
				$sheet->setCellValueByColumnAndRow(15, $row, $value->speed);
				$sheet->setCellValueByColumnAndRow(16, $row, $value->type);
				$sheet->setCellValueByColumnAndRow(17, $row, $value->flag);
				$row++;	
        	}
        }

        $sheet->getStyle("A7:R{$row}")->getFont()->setSize('7px');
        $sheet->getStyle("D9:P{$row}")->getFont()->setSize('6px');
        $sheet->getStyle("A9:A{$row}")->getFont()->setSize('6px');
        $sheet->getStyle("B7:R{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("G7:P{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A7:R{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A7:R{$row}")->getAlignment()->setWrapText(true);

		$this->excel_footer($objPHPExcel, 'vessel-master-list');
	}

	public function principal_list($key = null)
	{		
		$setting = array('paper_size' => 1, 'orientation' => 1);

		$objPHPExcel = $this->excel_header($setting);

		$sheet = $objPHPExcel->getActiveSheet();

		$principal = $this->rest->get('principals', 
			array(
				'status'	   	=> ($key != 'all')? $key : '',
				'sort'		   	=> 'id',
				'order'		   	=> 'asc',
				'limit'			=> 10000
				), 'json');

		//dbug($principal);

		if(!$key) redirect('principal-master-list');

		$status = ($key)? ucwords($key) : '';	

		$array = array('A1:L2','A4:L4','A5:L5');
		
		foreach ($array as $field):
		    $sheet->mergeCells($field);
		    $sheet->getStyle($field)->getFont()->setBold(true);
		endforeach;
		
		$styleArray = array(			    
					    'font' => array(
						    'bold' => true,
						    'size' => '12px',
						),
					    'borders' => array(
						    'outline' => array(
							    'style' => PHPExcel_Style_Border::BORDER_THIN,
							    'color' => array('argb' => '00000000'),
							),
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);
		$sheet->getStyle('A1:L2')->applyFromArray($styleArray);
		$sheet->getStyle("A4:L5")->getFont()->setSize("8px");
		$sheet->setCellValueByColumnAndRow(0, 1, 'PRINCIPAL MASTER LIST');	
		$sheet->setCellValueByColumnAndRow(0, 4, 'FILTER BY: ' . $status);
		$sheet->setCellValueByColumnAndRow(0, 5, 'As of ' . date('M d, Y'));

		$array = array(	'A'=>'3', 'B'=>'5', 'C'=>'20', 'D'=>'47', 'E'=>'12', 'F'=>'12', 'G'=>'8' ,'H'=>'14', 'I'=>'12', 
						'J'=>'10', 'K'=>'9', 'L'=>'7'); 

		foreach ($array as $field=>$value):	
			$sheet->getStyle("{$field}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getColumnDimension($field)->setWidth($value);
		endforeach;

		$styleArray = array(
						'font' => array(
							'bold' => true,
						    ),
						'borders' => array(
						    'outline' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN, //BORDER_THICK
									'color' => array('argb' => '00000000'),
								    ),
							),
						);
	
		$sheet->getStyle('A7:L7')->applyFromArray($styleArray);

		$array = array(	'No', 'Code', 'Name' , 'Address', 'In-charge', 
						'Position' ,'SSS', 'Tel No.', 'Fax No.', 'Tel Fax', 'Cable', 'Accredited'); 		
        $col = 0;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col, 7, $field);	   
            $col++;
        endforeach;

        $row = 9;

        //dbug($vessel->data);        

        if($principal->data){
        	$counter = 0;
        	foreach ($principal->data as $value) {
        		$counter++;        			

        		$contact = trim($value->telno1) . ((trim($value->telno2) != '')? '/' . trim($value->telno2) : '') . ((trim($value->telno3) != '')? '/' . trim($value->telno3) : '');
        		$fax = trim($value->fax1) . ((trim($value->fax2) != '')? '/' . trim($value->fax2) : '') . ((trim($value->fax3) != '')? '/' . trim($value->fax3) : '');

        		$sheet->setCellValueByColumnAndRow(0, $row, $counter);
				$sheet->setCellValueByColumnAndRow(1, $row, trim($value->code));
				$sheet->setCellValueByColumnAndRow(2, $row, trim($value->fullname));
				$sheet->setCellValueByColumnAndRow(3, $row, trim($value->address));
				$sheet->setCellValueByColumnAndRow(4, $row, trim($value->person1));
				$sheet->setCellValueByColumnAndRow(5, $row, trim($value->designate1));
				$sheet->setCellValueByColumnAndRow(6, $row, trim($value->sss));
				$sheet->setCellValueByColumnAndRow(7, $row, $contact);
				$sheet->setCellValueByColumnAndRow(8, $row, $fax);
				$sheet->setCellValueByColumnAndRow(9, $row, trim($value->telefax));
				$sheet->setCellValueByColumnAndRow(10, $row, trim($value->telefax));
				$sheet->setCellValueByColumnAndRow(11, $row, date('m/d/Y', strtotime($value->accredited)));
				$row++;	
        	}
        }

        $sheet->getStyle("A7:L{$row}")->getFont()->setSize('7px');
        $sheet->getStyle("D9:L{$row}")->getFont()->setSize('6px');
        $sheet->getStyle("C7:K{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A7:L{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A7:L{$row}")->getAlignment()->setWrapText(true);

		$this->excel_footer($objPHPExcel, 'principal-master-list');
	}

	//------------------------------- VARIOUS LIST -------------------------------
	public function various_list($key = null)
	{		
		$setting = array('paper_size' => 0, 'orientation' => 1);

		$objPHPExcel = $this->excel_header($setting);

		$sheet = $objPHPExcel->getActiveSheet();

		$crews = $this->rest->get('onboards', 
			array(
				'vessel_id'	   => $key,
				'sort'		   => 'crew_id',
				'order'		   => 'asc'
				), 'json');

		$vessel = $this->rest->get('vessel', array('id' => (int) $key), 'json');

		//dbug($vessel);

		if(!$key) redirect('various-list');

		$status = ($key)? ucwords($key) : '';	

		$array = array('A1:P2','A4:B4','A5:B5','A6:B6', 'M4:P4',);
		
		foreach ($array as $field):
		    $sheet->mergeCells($field);
		    $sheet->getStyle($field)->getFont()->setBold(true);
		endforeach;
		
		$styleArray = array(			    
					    'font' => array(
						    'bold' => true,
						    'size' => '12px',
						),
					    'borders' => array(
						    'outline' => array(
							    'style' => PHPExcel_Style_Border::BORDER_THIN,
							    'color' => array('argb' => '00000000'),
							),
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);
		$sheet->getStyle('A1:P2')->applyFromArray($styleArray);
		$sheet->getStyle("A4:P6")->getFont()->setSize("8px");
		$sheet->setCellValueByColumnAndRow(0, 1, 'VARIOUS CERTIFICATE LIST');	
		$sheet->setCellValueByColumnAndRow(0, 4, 'SHIP NAME: ');
		$sheet->setCellValueByColumnAndRow(2, 4, isset($vessel->vessel_name)? $vessel->vessel_name : '');
		$sheet->setCellValueByColumnAndRow(0, 5, 'FLAG: ');
		$sheet->setCellValueByColumnAndRow(2, 5, isset($vessel->flag)? $vessel->flag : '');
		$sheet->setCellValueByColumnAndRow(0, 6, 'TYPE: ');
		$sheet->setCellValueByColumnAndRow(2, 6, isset($vessel->type)? $vessel->type : '');
		$sheet->setCellValueByColumnAndRow(12, 4, 'As of ' . date('M d, Y'));

		$sheet->getStyle("M4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle("M4")->getFont()->setBold(false);
		$sheet->getStyle("M4")->getFont()->setSize('7px');

		$array = array(	'A'=>'3', 'B'=>'7', 'C'=>'24', 'D'=>'9', 'E'=>'8', 'F'=>'9', 'G'=>'8' ,'H'=>'10', 'I'=>'9', 
						'J'=>'9', 'K'=>'8', 'L'=>'9', 'M'=>'8', 'N'=>'8', 'O'=>'8', 'P'=>'8'); 

		foreach ($array as $field=>$value):	
			$sheet->getStyle("{$field}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}9")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}9")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getColumnDimension($field)->setWidth($value);
		endforeach;

		$styleArray = array(
						'font' => array(
							'bold' => true,
						    ),
						'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						    ),
						);
		
		$array = array(	'A8:A9', 'A8:P9', 'C8:C9', 'D8:D9', 'E8:E9', 'F8:F9', 'G8:G9', 'H8:H9',
						'I8:I9', 'I8:I9', 'J8:J9', 'K8:K9', 'L8:L9', 'M8:M9', 'N8:N9', 'O8:O9', 'P8:P9');
		foreach ($array as $field):
		    $sheet->getStyle("{$field}")->applyFromArray($styleArray);
		endforeach;

		$sheet->getRowDimension(8)->setRowHeight(13);
		$sheet->getRowDimension(9)->setRowHeight(13);

		$sheet->mergeCells('A8:A9');
		$sheet->mergeCells('B8:B9');
		$sheet->mergeCells('C8:C9');

		$styleArray = array(
						'borders' => array(
							    'top' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
						        'bottom' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						);

		$sheet->getStyle('A8:P9')->applyFromArray($styleArray);

		$array = array(	'No', 'Rank', 'Name' , "Seaman's", "Seaman's", 'Passport' ,'Passport', 'Philipines', 'Philipines', 
						'GMDSS', 'GMDSS', 'PRC/TESDA', 'PRC/TESDA', 'U.S Visa', 'Yellow Fever', 'Medical'); 		
        $col = 0;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col, 8, $field);	   
            $col++;
        endforeach;

        $array = array(	'Book Number', 'Book Expiry', 'Number' , "Expiry", "License No.", 'License Exp' ,'Number',
						'Expiry', 'C.O.C Number', 'C.O.C Expiry', 'Expiry', 'Expiry', 'Result'); 		
        $col = 3;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col, 9, $field);	   
            $col++;
        endforeach;

        $row = 10;

        //dbug($vessel->data);        

        if($crews->data){
        	$counter = 0;
        	foreach ($crews->data as $value) {
        		$counter++;        		

				$sheet->setCellValueByColumnAndRow(0, $row, $counter);
				$sheet->setCellValueByColumnAndRow(1, $row, $value->code);
				$sheet->setCellValueByColumnAndRow(2, $row, $value->fullname);
				$sheet->setCellValueByColumnAndRow(3, $row, $value->seaman_nos);
				$sheet->setCellValueByColumnAndRow(4, $row, $value->seaman_expiry);
				$sheet->setCellValueByColumnAndRow(5, $row, $value->passport_nos);
				$sheet->setCellValueByColumnAndRow(6, $row, $value->passport_expiry);
				$sheet->setCellValueByColumnAndRow(7, $row, $value->prc_nos);
				$sheet->setCellValueByColumnAndRow(8, $row, $value->prc_expiry);
				$sheet->setCellValueByColumnAndRow(9, $row, $value->gmdss_nos);
				$sheet->setCellValueByColumnAndRow(10, $row, $value->gmdss_expiry);
				$sheet->setCellValueByColumnAndRow(11, $row, $value->tesda_nos);
				$sheet->setCellValueByColumnAndRow(12, $row, $value->tesda_expiry);
				$sheet->setCellValueByColumnAndRow(13, $row, $value->us_expiry);
				$sheet->setCellValueByColumnAndRow(14, $row, $value->yellow_expiry);
				$sheet->setCellValueByColumnAndRow(15, $row, $value->medical_expiry);

				if(check_isexpired($value->seaman_expiry)){
					$sheet->getStyle("D{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$sheet->getStyle("E{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}


				if(check_isexpired($value->passport_expiry)){
					$sheet->getStyle("F{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$sheet->getStyle("G{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}

				if(check_isexpired($value->prc_expiry)){
					$sheet->getStyle("H{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$sheet->getStyle("I{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}

				if(check_isexpired($value->gmdss_expiry)){
					$sheet->getStyle("J{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$sheet->getStyle("K{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}

				if(check_isexpired($value->tesda_expiry)){
					$sheet->getStyle("M{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					$sheet->getStyle("L{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				}

				if(check_isexpired($value->us_expiry)) $sheet->getStyle("N{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);				
				if(check_isexpired($value->yellow_expiry)) $sheet->getStyle("O{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);				
				if(check_isexpired($value->medical_expiry)) $sheet->getStyle("P{$row}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);

				$row++;	
        	}
        }

        $sheet->getStyle("A8:P{$row}")->getFont()->setSize('8px');
        $sheet->getStyle("D10:P{$row}")->getFont()->setSize('7px');
        $sheet->getStyle("C8:C{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A8:P{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A8:P{$row}")->getAlignment()->setWrapText(true);

		$this->excel_footer($objPHPExcel, 'various-certificate-list');
	}

	public function expired_list($key1=null, $key2=null, $key3=null )
	{		
		$setting = array('paper_size' => 0, 'orientation' => 1);

		$objPHPExcel = $this->excel_header($setting);

		$sheet = $objPHPExcel->getActiveSheet();

		$expired = $this->rest->get('expired_docs', 
			array(
				'docs_id'		=> $key1,
				'isdone'		=> 0,
				'date_expired'	=> "'{$key2}' AND '{$key3}'",
				'sort'			=> 'jd_crew.lastname',
				'order'			=> 'asc',
				'limit'			=> '10000'
				), 'json');	

		$from 	= date('d-M-Y', strtotime($key2));
		$to 	= date('d-M-Y', strtotime($key3));

		if(!isset($expired->data)) redirect('expired-documents');

		$array = array('A1:I2','A4:I4');
		
		foreach ($array as $field):
		    $sheet->mergeCells($field);
		    $sheet->getStyle($field)->getFont()->setBold(true);
		endforeach;
		
		$styleArray = array(			    
					    'font' => array(
						    'bold' => true,
						    'size' => '12px',
						),
					    'borders' => array(
						    'outline' => array(
							    'style' => PHPExcel_Style_Border::BORDER_THIN,
							    'color' => array('argb' => '00000000'),
							),
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);
		$sheet->getStyle('A1:I2')->applyFromArray($styleArray);
		$sheet->getStyle("A4:I5")->getFont()->setSize("8px");
		$sheet->setCellValueByColumnAndRow(0, 1, 'DOCUMENT MAINTENANCE REPORT');	
		$sheet->setCellValueByColumnAndRow(0, 4, 'Expiring as of: ' . $from . ' - ' . $to);

		$array = array(	'A'=>'3', 'B'=>'9', 'C'=>'40', 'D'=>'35', 'E'=>'15', 'F'=>'13', 'G'=>'13','H'=>'25', 'I'=>'20'); 

		foreach ($array as $field=>$value):	
			$sheet->getStyle("{$field}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}6")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getColumnDimension($field)->setWidth($value);
		endforeach;
	
		$sheet->getStyle('A6:I6')->applyFromArray($styleArray);

		$array = array('Vessel', 'Certificate' , 'Date on Board', 'Expiry Date', 'Remarks', 'Updates'); 		
        $sheet->setCellValueByColumnAndRow(0, 6, 'Crew Name');
        $col = 3;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col, 6, $field);	   
            $col++;
        endforeach;

        $sheet->mergeCells('A6:C6');

		$styleArray = array(
						'borders' => array(
						        'bottom' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 

        $row = 7;

        if($expired->data){
        	$counter = 0;
        	foreach ($expired->data as $value) {
        		$counter++;        			

        		$sheet->setCellValueByColumnAndRow(0, $row, $counter);
				$sheet->setCellValueByColumnAndRow(1, $row, trim($value->code));
				$sheet->setCellValueByColumnAndRow(2, $row, trim($value->fullname));
				$sheet->setCellValueByColumnAndRow(3, $row, trim($value->vessel_name));
				$sheet->setCellValueByColumnAndRow(4, $row, trim($value->docs_nos));
				$sheet->setCellValueByColumnAndRow(5, $row, trim($value->onboard_date));
				$sheet->setCellValueByColumnAndRow(6, $row, trim($value->expiry_date));
				$sheet->setCellValueByColumnAndRow(7, $row, trim($value->remarks));
				$sheet->setCellValueByColumnAndRow(8, $row, '');

        		$sheet->getStyle("A{$row}:I{$row}")->applyFromArray($styleArray);
				$row++;	
        	}
        }

        $sheet->getStyle("A{$row}:I{$row}")->applyFromArray($styleArray);
        $sheet->getStyle("A6:I{$row}")->getFont()->setSize('8px');
        $sheet->getStyle("C7:D{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A6:I{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A6:I{$row}")->getAlignment()->setWrapText(true);

         $styleArray3 = array(
						'borders' => array(
						        'left' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 

        $array = array("A6:B{$row}", "B6:C{$row}", "C6:D{$row}", "D6:E{$row}", "E6:F{$row}", "F6:G{$row}", 
        				"G6:H{$row}", "H6:I{$row}", "I6:J{$row}", "J6:K{$row}");

		foreach ($array as $field):
		    $sheet->getStyle("{$field}")->applyFromArray($styleArray3);
		endforeach;

		$this->excel_footer($objPHPExcel, 'expired-documents');
	}

	//------------------------------- AMMENDED LIST -------------------------------
	public function ammended_list($key = null)
	{		
		
	}

	//------------------------------- EMBARKATION/DISEMBARKATION LIST -------------------------------
	public function embarkation_list($key1=null, $key1a=null, $key2=null, $key3=null)
	{		
		$setting = array('paper_size' => 0, 'orientation' => 0);

		$objPHPExcel = $this->excel_header($setting);

		$sheet = $objPHPExcel->getActiveSheet();

		$params = array(
					'vessel_id'		=> $key1,
					//'isdone'		=> 0,
					'sort'			=> 'jd_position.sort_order',
					'order'			=> 'asc',
					'limit'			=> '10000'
				);

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

		if(!isset($status->data)) redirect('crew-list');

		$array = array('A1:I2','A4:I4','A5:I5');
		
		foreach ($array as $field):
		    $sheet->mergeCells($field);
		    $sheet->getStyle($field)->getFont()->setBold(true);
		endforeach;
		
		$styleArray = array(			    
					    'font' => array(
						    'bold' => true,
						    'size' => '14px',
						),
					    'borders' => array(
						    'outline' => array(
							    'style' => PHPExcel_Style_Border::BORDER_THIN,
							    'color' => array('argb' => '00000000'),
							),
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);
		$sheet->getStyle('A1:I2')->applyFromArray($styleArray);
		$sheet->getStyle("A4:I5")->getFont()->setSize("12px");
		$sheet->setCellValueByColumnAndRow(0, 1, 'EMBARKATION LIST');	
		$sheet->setCellValueByColumnAndRow(0, 4, $filter);
		$sheet->setCellValueByColumnAndRow(0, 5, 'Vessel: ' . $vessel->vessel_name);

		$array = array(	'A'=>'3', 'B'=>'9', 'C'=>'35', 'D'=>'15', 'E'=>'12', 'F'=>'15', 'G'=>'15','H'=>'25', 'I'=>'14'); 

		foreach ($array as $field=>$value):	
			$sheet->getStyle("{$field}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getColumnDimension($field)->setWidth($value);
		endforeach;
	
		$sheet->getStyle('A7:I7')->applyFromArray($styleArray);
		$sheet->getStyle('A7:I7')->applyFromArray(
		    array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => '000000')
		        ),
		        'font' => array(
			        'name' => 'Arial',
			        'color' => array(
			            'rgb' => 'FFFFFF'
			        )
			    )
		    )
		);

		$array = array('Seaman\'s No ', 'Duration' , 'Onboard Date', 'End Date', 'Remarks', 'Department'); 		
        $sheet->setCellValueByColumnAndRow(0, 7, 'Crew Name');
        $col = 3;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col, 7, $field);	   
            $col++;
        endforeach;

        $sheet->mergeCells('A7:C7');

		$styleArray = array(
						'borders' => array(
						        'bottom' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 

        $row = 8;

        if($status->data){
        	$counter = 0;
        	foreach ($status->data as $value) {
        		$counter++;        			

        		$sheet->setCellValueByColumnAndRow(0, $row, $counter);
				$sheet->setCellValueByColumnAndRow(1, $row, trim($value->code));
				$sheet->setCellValueByColumnAndRow(2, $row, trim($value->fullname));
				$sheet->setCellValueByColumnAndRow(3, $row, trim($value->seaman_nos));
				$sheet->setCellValueByColumnAndRow(4, $row, trim($value->duration));
				$sheet->setCellValueByColumnAndRow(5, $row, trim($value->start_date));
				$sheet->setCellValueByColumnAndRow(6, $row, trim($value->end_date));
				$sheet->setCellValueByColumnAndRow(7, $row, trim($value->remarks));
				$sheet->setCellValueByColumnAndRow(8, $row, trim($value->department));

        		$sheet->getStyle("A{$row}:I{$row}")->applyFromArray($styleArray);
				$row++;	
        	}
        }

        $sheet->getStyle("A{$row}:I{$row}")->applyFromArray($styleArray);
        $sheet->getStyle("A7:I{$row}")->getFont()->setSize('12px');
        $sheet->getStyle("C8:C{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A7:I{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A7:I{$row}")->getAlignment()->setWrapText(true);

         $styleArray3 = array(
						'borders' => array(
						        'left' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 

        $array = array("A7:B{$row}", "B7:C{$row}", "C7:D{$row}", "D7:E{$row}", "E7:F{$row}", "F7:G{$row}", 
        				"G7:H{$row}", "H7:I{$row}", "I7:J{$row}", "J7:K{$row}");

		foreach ($array as $field):
		    $sheet->getStyle("{$field}")->applyFromArray($styleArray3);
		endforeach;

		$this->excel_footer($objPHPExcel, 'embarkation-list');
	}

	public function disembarkation_list($key1=null, $key1a=null, $key2=null, $key3=null)
	{		
		$setting = array('paper_size' => 0, 'orientation' => 0);

		$objPHPExcel = $this->excel_header($setting);

		$sheet = $objPHPExcel->getActiveSheet();

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


		// echo "<pre>";
		// print_r($status);
		// echo "</pre>";

		// exit();

		if(!isset($status->data)) redirect('crew-list');

		$array = array('A1:I2','A4:I4','A5:I5');
		
		foreach ($array as $field):
		    $sheet->mergeCells($field);
		    $sheet->getStyle($field)->getFont()->setBold(true);
		endforeach;
		
		$styleArray = array(			    
					    'font' => array(
						    'bold' => true,
						    'size' => '14px',
						),
					    'borders' => array(
						    'outline' => array(
							    'style' => PHPExcel_Style_Border::BORDER_THIN,
							    'color' => array('argb' => '00000000'),
							),
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);
		$sheet->getStyle('A1:I2')->applyFromArray($styleArray);
		$sheet->getStyle("A4:I5")->getFont()->setSize("12px");
		$sheet->setCellValueByColumnAndRow(0, 1, 'DISEMBARKATION LIST');	
		$sheet->setCellValueByColumnAndRow(0, 4, $filter);
		$sheet->setCellValueByColumnAndRow(0, 5, 'Vessel: ' . $vessel->vessel_name);

		$array = array(	'A'=>'3', 'B'=>'9', 'C'=>'35', 'D'=>'15', 'E'=>'12', 'F'=>'15', 'G'=>'15','H'=>'25', 'I'=>'14'); 

		foreach ($array as $field=>$value):	
			$sheet->getStyle("{$field}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getColumnDimension($field)->setWidth($value);
		endforeach;
	
		$sheet->getStyle('A7:I7')->applyFromArray($styleArray);
		$sheet->getStyle('A7:I7')->applyFromArray(
		    array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => '000000')
		        ),
		        'font' => array(
			        'name' => 'Arial',
			        'color' => array(
			            'rgb' => 'FFFFFF'
			        )
			    )
		    )
		);

		$array = array('Seaman\'s No ', 'Duration' , 'Onboard Date', 'End Date', 'Remarks', 'Department'); 		
        $sheet->setCellValueByColumnAndRow(0, 7, 'Crew Name');
        $col = 3;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col, 7, $field);	   
            $col++;
        endforeach;

        $sheet->mergeCells('A7:C7');

		$styleArray = array(
						'borders' => array(
						        'bottom' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 

        $row = 8;

        if($status->data){
        	$counter = 0;
        	foreach ($status->data as $value) {
        		$counter++;        			

        		$sheet->setCellValueByColumnAndRow(0, $row, $counter);
				$sheet->setCellValueByColumnAndRow(1, $row, trim($value->code));
				$sheet->setCellValueByColumnAndRow(2, $row, trim($value->fullname));
				$sheet->setCellValueByColumnAndRow(3, $row, trim($value->seaman_nos));
				$sheet->setCellValueByColumnAndRow(4, $row, trim($value->duration));
				$sheet->setCellValueByColumnAndRow(5, $row, trim($value->start_date));
				$sheet->setCellValueByColumnAndRow(6, $row, trim($value->end_date));
				$sheet->setCellValueByColumnAndRow(7, $row, trim($value->remarks));
				$sheet->setCellValueByColumnAndRow(8, $row, trim($value->department));

        		$sheet->getStyle("A{$row}:I{$row}")->applyFromArray($styleArray);
				$row++;	
        	}
        }

        $sheet->getStyle("A{$row}:I{$row}")->applyFromArray($styleArray);
        $sheet->getStyle("A7:I{$row}")->getFont()->setSize('12px');
        $sheet->getStyle("C8:C{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A7:I{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A7:I{$row}")->getAlignment()->setWrapText(true);

         $styleArray3 = array(
						'borders' => array(
						        'left' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 

        $array = array("A7:B{$row}", "B7:C{$row}", "C7:D{$row}", "D7:E{$row}", "E7:F{$row}", "F7:G{$row}", 
        				"G7:H{$row}", "H7:I{$row}", "I7:J{$row}", "J7:K{$row}");

		foreach ($array as $field):
		    $sheet->getStyle("{$field}")->applyFromArray($styleArray3);
		endforeach;

		$this->excel_footer($objPHPExcel, 'disembarkation-list');
	}

	//------------------------------- CHECK LIST -------------------------------
	public function check_list($key = null)
	{		
		$setting = array('paper_size' => 0, 'orientation' => 0);

		$objPHPExcel = $this->excel_header($setting);

		$sheet = $objPHPExcel->getActiveSheet();

		$checklist = $this->rest->get('checklist_crews', 
			array(
				'crew_id'	   => $key,
				'sort'		   => 'sort_order, sub_order',
				'order'		   => 'asc',
				'limit'		   => '250'
				), 'json');

		if(!isset($checklist->data)) redirect('various-list');

		$crew = $this->rest->get('crew', array('id' => (int) $key), 'json');

		$status = ($key)? ucwords($key) : '';	

		$array = array('A1:J2','A4:B4','A5:B5','A6:B6', 'A7:B7');
		
		foreach ($array as $field):
		    $sheet->mergeCells($field);
		    $sheet->getStyle($field)->getFont()->setBold(true);
		endforeach;
		
		$styleArray = array(			    
					    'font' => array(
						    'bold' => true,
						    'size' => '12px',
						),
					    'borders' => array(
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);
		$sheet->getStyle('A1:J2')->applyFromArray($styleArray);
		$sheet->getStyle("A4:J7")->getFont()->setSize("9px");
		$sheet->setCellValueByColumnAndRow(0, 1, 'CHECKLIST');	
		$sheet->setCellValueByColumnAndRow(0, 4, 'NAME: ' . (isset($crew->fullname)? $crew->fullname : '') );
		$sheet->setCellValueByColumnAndRow(0, 5, 'RANK: ' . (isset($crew->position)? $crew->position : '') );
		$sheet->setCellValueByColumnAndRow(0, 6, 'VESSEL: ');
		$sheet->setCellValueByColumnAndRow(0, 7, 'DATE: ' . date('M d, Y'));

		$array = array(	'A'=>'3', 'B'=>'41', 'C'=>'6', 'D'=>'6', 'E'=>'6', 'F'=>'6', 'G'=>'6' ,'H'=>'10', 'I'=>'10', 
						'J'=>'13'); 

		foreach ($array as $field=>$value):	
			$sheet->getStyle("{$field}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}8")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}9")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}9")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getColumnDimension($field)->setWidth($value);
		endforeach;

		$styleArray = array(
						'font' => array(
							'bold' => true,
						    ),
						'borders' => array(
						    'outline' => array(
							    'style' => PHPExcel_Style_Border::BORDER_THIN,
							    'color' => array('argb' => '00000000'),
							),
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);
		
		$array = array(	'A9:A10', 'C10:C10', 'D10:D10', 'E10:E10', 'F10:F10', 'G10:G10', 
						'C9:D9', 'E9:G9', 'H9:H10', 'I9:I10', 'J9:J10', 'H9:H10');
		foreach ($array as $field):
		    $sheet->getStyle("{$field}")->applyFromArray($styleArray);
		endforeach;

		$sheet->getRowDimension(9)->setRowHeight(13);
		$sheet->getRowDimension(10)->setRowHeight(13);

		$sheet->mergeCells('A9:B10');
		$sheet->mergeCells('C9:D9');
		$sheet->mergeCells('E9:G9');
		$sheet->mergeCells('H9:H10');
		$sheet->mergeCells('I9:I10');
		$sheet->mergeCells('J9:J10');

		$styleArray = array(
						'borders' => array(
							    'outline' => array(
								    'style' => PHPExcel_Style_Border::BORDER_THIN,
								    'color' => array('argb' => '00000000'),
								),
						    	'alignment' => array(
								    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								),
					   		),
						);

		$sheet->getStyle('A9:J10')->applyFromArray($styleArray);

        $sheet->setCellValueByColumnAndRow(0, 9, 'Certificate Title');
        $sheet->setCellValueByColumnAndRow(2, 9, 'Officers');
        $sheet->setCellValueByColumnAndRow(4, 9, 'Ratings');
        $sheet->setCellValueByColumnAndRow(7, 9, 'Issue Date');
        $sheet->setCellValueByColumnAndRow(8, 9, 'Expiry Date');
        $sheet->setCellValueByColumnAndRow(9, 9, 'Certificate No.');

        $array = array(	'Deck', "Eng'r", 'Deck', "Eng'r", 'Stwd'); 		
        $col = 2;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col, 10, $field);	   
            $col++;
        endforeach;

        $row = 11;

        $styleArray2 = array(
						'borders' => array(
						        'bottom' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						);   

        if($checklist->data){
        	foreach ($checklist->data as $value) {    

        		$suborder = ($value->sub_order != '0')? $value->sub_order . '. ' : '';		

				$sheet->setCellValueByColumnAndRow(0, $row, $value->sort_order);
				$sheet->setCellValueByColumnAndRow(1, $row, $suborder . $value->document);
				$sheet->setCellValueByColumnAndRow(2, $row, $value->officer_deck);
				$sheet->setCellValueByColumnAndRow(3, $row, $value->officer_engr);
				$sheet->setCellValueByColumnAndRow(4, $row, $value->rating_deck);
				$sheet->setCellValueByColumnAndRow(5, $row, $value->rating_engr);
				$sheet->setCellValueByColumnAndRow(6, $row, $value->rating_stwd);
				$sheet->setCellValueByColumnAndRow(7, $row, $value->date_issued);
				$sheet->setCellValueByColumnAndRow(8, $row, $value->date_expired);
				$sheet->setCellValueByColumnAndRow(9, $row, $value->docs_nos);

				$sheet->getStyle("A{$row}:J{$row}")->applyFromArray($styleArray2);

				$row++;
        	}
        }

        $sheet->getStyle("A9:J{$row}")->applyFromArray($styleArray);
        $sheet->getStyle("A9:J{$row}")->getFont()->setSize('9px');
        $sheet->getStyle("B9:B{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A9:J10")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A9:J{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A9:J{$row}")->getAlignment()->setWrapText(true);

        $styleArray3 = array(
						'borders' => array(
						        'left' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 

        $array = array("A9:B{$row}", "B9:C{$row}", "C9:D{$row}", "D9:E{$row}", "E9:F{$row}", "F9:G{$row}", "G9:H{$row}", "H9:I{$row}");

		foreach ($array as $field):
		    $sheet->getStyle("{$field}")->applyFromArray($styleArray3);
		endforeach;

		$this->excel_footer($objPHPExcel, 'checklist');
	}

	//------------------------------- CONDUCT LIST -------------------------------
	public function conduct_report($key1 = null)
	{		
		$setting = array('paper_size' => 0, 'orientation' => 1);

		$objPHPExcel = $this->excel_header($setting);

		$sheet = $objPHPExcel->getActiveSheet();

		$principal = $this->rest->get('conduct_rep1s', 
			array(
				'date_receive_year'		=> $key1,
				'sort'		   			=> 'vessel_id',
				'order'		   			=> 'asc'
				), 'json');

		if(!isset($principal->data)) redirect('conduct-setup');

		$array = array('A1:H2','A4:B4','A5:B5');
		
		foreach ($array as $field):
		    $sheet->mergeCells($field);
		    $sheet->getStyle($field)->getFont()->setBold(true);
		endforeach;
		
		$styleArray = array(			    
					    'font' => array(
						    'bold' => true,
						    'size' => '12px',
						),
					    'borders' => array(
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);
		$sheet->getStyle('A1:H2')->applyFromArray($styleArray);
		$sheet->getStyle("A4:H5")->getFont()->setSize("9px");
		$sheet->setCellValueByColumnAndRow(0, 1, 'CONDUCT REPORT');	
		$sheet->setCellValueByColumnAndRow(0, 4, 'YEAR FILTER: ' . $key1 );
		$sheet->setCellValueByColumnAndRow(0, 5, 'DATE: ' . date('M d, Y') );

		$array = array(	'A'=>'4', 'B'=>'25', 'C'=>'25', 'D'=>'10', 'E'=>'10', 'F'=>'10', 'G'=>'10' ,'H'=>'40'); 

		foreach ($array as $field=>$value):	
			$sheet->getStyle("{$field}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}6")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getColumnDimension($field)->setWidth($value);
		endforeach;

		$styleArray = array(
						'font' => array(
							'bold' => true,
						    ),
						'borders' => array(
						    'outline' => array(
							    'style' => PHPExcel_Style_Border::BORDER_THIN,
							    'color' => array('argb' => '00000000'),
							),
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);
		
		$array = array(	'A7:A8', 'B7:B8', 'C7:C8', 'D8:D8', 'E8:E8', 'F8:F8', 'G8:G8', 'H7:H8');
		foreach ($array as $field):
		    $sheet->getStyle("{$field}")->applyFromArray($styleArray);
		endforeach;

		$sheet->getRowDimension(7)->setRowHeight(13);
		$sheet->getRowDimension(8)->setRowHeight(13);

		$sheet->mergeCells('A7:A8');
		$sheet->mergeCells('B7:B8');
		$sheet->mergeCells('C7:C8');
		$sheet->mergeCells('H7:H8');
		$sheet->mergeCells('D7:G7');

		$styleArray = array(
						'borders' => array(
							    'outline' => array(
								    'style' => PHPExcel_Style_Border::BORDER_THIN,
								    'color' => array('argb' => '00000000'),
								),
						    	'alignment' => array(
								    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								),
					   		),
						);

		$sheet->getStyle('A7:H8')->applyFromArray($styleArray);

        $sheet->setCellValueByColumnAndRow(0, 7, 'No.');
        $sheet->setCellValueByColumnAndRow(1, 7, 'Principal');
        $sheet->setCellValueByColumnAndRow(2, 7, 'Vessel');
        $sheet->setCellValueByColumnAndRow(3, 7, 'Quarterly (RCVD DATE)');
        $sheet->setCellValueByColumnAndRow(7, 7, 'Crew (Remarks)');

        $array = array(	'1st', '2nd', '3rd', '4th'); 		
        $col = 3;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col, 8, $field);	   
            $col++;
        endforeach;

        $row = 9;

        $styleArray2 = array(
						'borders' => array(
						        'bottom' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						);   

        if($principal->data){
        	$counter = 0;
        	foreach ($principal->data as $value) {    
        		$counter++;

				$sheet->setCellValueByColumnAndRow(0, $row, $counter);
				$sheet->setCellValueByColumnAndRow(1, $row, $value->principal);

				//$sheet->getStyle("D{$row}:H{$row}")->applyFromArray($styleArray2);
				//$row++;

				$vessel = $this->rest->get('conduct_rep2s', 
					array(
						'date_receive_year'		=> $key1,
						'principal_id'			=> $value->principal_id,
						'sort'		   			=> 'vessel_id',
						'order'		   			=> 'asc'
						), 'json');

				if($vessel){
					foreach ($vessel->data as $value) {  
						// $sheet->setCellValueByColumnAndRow(0, $row, '');
						// $sheet->setCellValueByColumnAndRow(1, $row, '');
						$sheet->setCellValueByColumnAndRow(2, $row, $value->vessel_name);
						$sheet->setCellValueByColumnAndRow(3, $row, $value->first_qrt);
						$sheet->setCellValueByColumnAndRow(4, $row, $value->second_qrt);
						$sheet->setCellValueByColumnAndRow(5, $row, $value->third_qrt);
						$sheet->setCellValueByColumnAndRow(6, $row, $value->fourth_qrt);
						$sheet->setCellValueByColumnAndRow(7, $row, $value->crew_remarks);

						$sheet->getStyle("D{$row}:H{$row}")->applyFromArray($styleArray2);
						$sheet->getRowDimension(1)->setRowHeight(-1);
						$row++;
					}
				}
				
        	}
        }

        $sheet->getStyle("A7:H{$row}")->applyFromArray($styleArray);
        $sheet->getStyle("A7:H8")->getFont()->setSize('9px');
        $sheet->getStyle("A9:C{$row}")->getFont()->setSize('8px');
        $sheet->getStyle("D9:H{$row}")->getFont()->setSize('7px');
        $sheet->getStyle("B7:C{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A7:H8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A7:H{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle("H9:H{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A7:H{$row}")->getAlignment()->setWrapText(true);

        $styleArray3 = array(
						'borders' => array(
						        'left' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 

        $array = array("A7:B{$row}", "B7:C{$row}", "C7:D{$row}", "D7:E{$row}", "E7:F{$row}", "F7:G{$row}", "G7:H{$row}", "H7:I{$row}");

		foreach ($array as $field):
		    $sheet->getStyle("{$field}")->applyFromArray($styleArray3);
		endforeach;

		$this->excel_footer($objPHPExcel, 'conduct-report');
	}

	// ------------------------------[ SENDING DOCS ]----------------------

	public function sending_docs_report($key1a=null, $key2=null, $key3=null)
	{		
		$setting = array('paper_size' => 0, 'orientation' => 1);

		$objPHPExcel = $this->excel_header($setting);

		$sheet = $objPHPExcel->getActiveSheet();

		$params = array(
					'sort'			=> 'date_sent',
					'order'			=> 'desc',
					'limit'			=> '1000'
				);

		$filter = '';

		switch ($key1a) {
		 	case 1:
		 		# SEARCHING BY DATE
		 		$key2 = date('Y-m-d', strtotime($key2));
				$key3 = date('Y-m-d', strtotime($key3));

		 		$params['date_sent'] = "'{$key2}' AND '{$key3}'";

		 		$filter = 'Filter from the date of ' . date('F d, y', strtotime($key2)) . ' to ' . date('F d, y', strtotime($key3));
		 		break;
		 	case 2:
		 		# SEARCHING BY MONTH
		 		$key2 = date('Y-m-01', strtotime($key2));
				$key3 = date('Y-m-t', strtotime($key2));

				$params['date_sent'] = "'{$key2}' AND '{$key3}'";

				$filter = 'Filter from Month of ' . date('F Y', strtotime($key2));
		 		break;
		 	default:
		 		# code...
		 		break;
		} 

		$status = $this->rest->get('sends', $params, 'json');	

		if(!isset($status->data)) redirect('send-document');
		
		$styleArray = array(			    
					    'font' => array(
						    'bold' => true,
						    'size' => '12px',
						),
					    'borders' => array(
						    'outline' => array(
							    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
							    'color' => array('argb' => '00000000'),
							),
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);

		$array = array(	'A'=>'12', 'B'=>'35', 'C'=>'12', 'D'=>'45', 'E'=>'45', 'F'=>'20', 'G'=>'20'); 

		foreach ($array as $field=>$value):	
			$sheet->getStyle("{$field}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}4")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getColumnDimension($field)->setWidth($value);
		endforeach;
	
		$sheet->getStyle('A2:G2')->applyFromArray($styleArray);
		$sheet->getStyle('A3:G3')->applyFromArray($styleArray);

		$array = array('DATE SENT', 'VESSEL' , 'RANK', 'CREW', 'DOCUMENTS', 'SENT THRU', 'AWB NO.'); 		
        $sheet->setCellValueByColumnAndRow(0, 2, 'SENDING DOCUMENTS MONITORING SHEET');
        $col = 0;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col,3, $field);	   
            $col++;

        endforeach;
        $sheet->mergeCells('A2:G2');

		$styleArray = array(
						'borders' => array(
						        'bottom' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 
        $row = 4;

        if($status->data){
        	foreach ($status->data as $value) {
				$sheet->setCellValueByColumnAndRow(0, $row, trim($value->ds));
				$sheet->setCellValueByColumnAndRow(1, $row, trim($value->vessel_name));
				$sheet->setCellValueByColumnAndRow(2, $row, trim($value->code));
				$sheet->setCellValueByColumnAndRow(3, $row, trim($value->fullname));
				$sheet->setCellValueByColumnAndRow(4, $row, trim($value->document));
				$sheet->setCellValueByColumnAndRow(5, $row, trim($value->sent_thru));
				$sheet->setCellValueByColumnAndRow(6, $row, trim($value->awb_no));

        		$sheet->getStyle("A{$row}:G{$row}")->applyFromArray($styleArray);
				$row++;	
        	}
        }

        $row--;

        $sheet->getStyle("A{$row}:G{$row}")->applyFromArray($styleArray);
        $sheet->getStyle("A2:G{$row}")->getFont()->setSize('11px');
        $sheet->getStyle("D4:E{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A2:G{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A2:G{$row}")->getAlignment()->setWrapText(true);

         $styleArray3 = array(
						'borders' => array(
						        'left' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 

        $array = array("A2:B{$row}", "B2:C{$row}", "C2:D{$row}", "D2:E{$row}", "E2:F{$row}", "F2:G{$row}", "G2:H{$row}", "H2:I{$row}");

		foreach ($array as $field):
		    $sheet->getStyle("{$field}")->applyFromArray($styleArray3);
		endforeach;
		
		$this->excel_footer($objPHPExcel, 'sending-documents');
	}

	public function received_docs_report($key1a=null, $key2=null, $key3=null)
	{		
		$setting = array('paper_size' => 0, 'orientation' => 1);

		$objPHPExcel = $this->excel_header($setting);

		$sheet = $objPHPExcel->getActiveSheet();

		$params = array(
					'sort'			=> 'date_received',
					'order'			=> 'desc',
					'limit'			=> '1000'
				);

		$filter = '';

		switch ($key1a) {
		 	case 1:
		 		# SEARCHING BY DATE
		 		$key2 = date('Y-m-d', strtotime($key2));
				$key3 = date('Y-m-d', strtotime($key3));

		 		$params['date_received'] = "'{$key2}' AND '{$key3}'";

		 		$filter = 'Filter from the date of ' . date('F d, y', strtotime($key2)) . ' to ' . date('F d, y', strtotime($key3));
		 		break;
		 	case 2:
		 		# SEARCHING BY MONTH
		 		$key2 = date('Y-m-01', strtotime($key2));
				$key3 = date('Y-m-t', strtotime($key2));

				$params['date_received'] = "'{$key2}' AND '{$key3}'";

				$filter = 'Filter from Month of ' . date('F Y', strtotime($key2));
		 		break;
		 	default:
		 		# code...
		 		break;
		} 

		$status = $this->rest->get('sends', $params, 'json');	

		if(!isset($status->data)) redirect('received-document');
		
		$styleArray = array(			    
					    'font' => array(
						    'bold' => true,
						    'size' => '12px',
						),
					    'borders' => array(
						    'outline' => array(
							    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
							    'color' => array('argb' => '00000000'),
							),
					    	'alignment' => array(
							    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							),
				   		),
					);

		$array = array(	'A'=>'12', 'B'=>'12', 'C'=>'35', 'D'=>'12', 'E'=>'45', 'F'=>'45', 
						'G'=>'12', 'H'=>'12', 'I'=>'12', 'J'=> 20, 'K'=> 20); 

		foreach ($array as $field=>$value):	
			$sheet->getStyle("{$field}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle("{$field}4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("{$field}4")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getColumnDimension($field)->setWidth($value);
		endforeach;
	
		$sheet->getStyle('A2:K2')->applyFromArray($styleArray);
		$sheet->getStyle('A3:K3')->applyFromArray($styleArray);

		$array = array('DATE RECEIVED', 'DATE CHECKED', 'VESSEL' , 'RANK', 'CREW', 'DOCUMENTS', 'EXPIRATION DATE', 'FROM', 'DATE SENT', 'SENT THRU', 'AWB NO.'); 		
        $sheet->setCellValueByColumnAndRow(0, 2, 'RECEIVED DOCUMENTS MONITORING SHEET');
        $col = 0;
        foreach ($array as $field):	   
            $sheet->setCellValueByColumnAndRow($col,3, $field);	   
            $col++;

        endforeach;
        $sheet->mergeCells('A2:K2');

		$styleArray = array(
						'borders' => array(
						        'bottom' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 
        $row = 4;

        if($status->data){
        	foreach ($status->data as $value) {
				$sheet->setCellValueByColumnAndRow(0, $row, trim($value->dr));
				$sheet->setCellValueByColumnAndRow(1, $row, trim($value->dc));
				$sheet->setCellValueByColumnAndRow(2, $row, trim($value->vessel_name));
				$sheet->setCellValueByColumnAndRow(3, $row, trim($value->code));
				$sheet->setCellValueByColumnAndRow(4, $row, trim($value->fullname));
				$sheet->setCellValueByColumnAndRow(5, $row, trim($value->document));
				$sheet->setCellValueByColumnAndRow(6, $row, trim($value->remarks));
				$sheet->setCellValueByColumnAndRow(7, $row, trim($value->send_by_others));
				$sheet->setCellValueByColumnAndRow(8, $row, trim($value->ds));
				$sheet->setCellValueByColumnAndRow(9, $row, trim($value->sent_thru));
				$sheet->setCellValueByColumnAndRow(10, $row, trim($value->awb_no));

        		$sheet->getStyle("A{$row}:K{$row}")->applyFromArray($styleArray);
				$row++;	
        	}
        }

        $row--;

        $sheet->getStyle("A{$row}:K{$row}")->applyFromArray($styleArray);
        $sheet->getStyle("A2:K{$row}")->getFont()->setSize('11px');
        $sheet->getStyle("E4:F{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A2:K{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A2:K{$row}")->getAlignment()->setWrapText(true);

         $styleArray3 = array(
						'borders' => array(
						        'left' => array(
						          	'style' => PHPExcel_Style_Border::BORDER_THIN,
						          	'color' => array('argb' => '00000000'),
						        ),
							),
						); 

        $array = array(	"A2:B{$row}", "B2:C{$row}", "C2:D{$row}", "D2:E{$row}", "E2:F{$row}", "F2:G{$row}", "G2:H{$row}", 
        				"H2:I{$row}", "I2:J{$row}", "J2:K{$row}", "K2:L{$row}");

		foreach ($array as $field):
		    $sheet->getStyle("{$field}")->applyFromArray($styleArray3);
		endforeach;
		
		$this->excel_footer($objPHPExcel, 'received-documents');
	}

	// --------------------------------------------------------------------

	private function excel_header($setting){
		$objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);

        $pageMargins = $objPHPExcel->getActiveSheet()->getPageMargins();
		$margin = 0.5 / 2.54;
		$pageMargins->setTop($margin);
		$pageMargins->setBottom($margin);
		$pageMargins->setLeft($margin);
		$pageMargins->setRight($margin);

		
		if($setting['paper_size'] == 0){
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		} else {
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		}

		if($setting['orientation'] == 0){
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		} else {
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		}

		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

		return $objPHPExcel;
	}

	private function excel_footer($objPHPExcel, $title)
	{	
		$objPHPExcel->setActiveSheetIndex(0);
		
		$objPHPExcel->getActiveSheet()->getProtection()->setPassword('m@st3rj0m3l');
		$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
		$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
		$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
		$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
	
		$title = strtoupper($title) . ".xls";
        header("Content-Disposition: attachment;filename=$title");
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');	
	}

}