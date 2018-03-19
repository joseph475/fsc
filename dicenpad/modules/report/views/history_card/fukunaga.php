<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Fukunuga History Card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body {
			font: normal 12px arial,sans-serif;
		}

		@page { margin: 0.2in 0.5in 0.5in 0.5in; }

		p { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.header h4 { margin: 0; text-align: right; border-bottom: 1px solid #000; font-style: italic; }
		.gen_info h4 { text-decoration: underline; }

		table { margin: 0; padding: 0; width: 100%; font-size: 11px; /* page-break-before: always; page-break-inside: avoid; */ }	
		table td { padding: 2px 0; vertical-align: middle; }	/*  border: 1px solid #cecece */
		table p { padding: 0 2px; }
		table th { font-weight: bold; }
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 7px; padding: 0; text-align: center; }
		.pic { border: 1px solid #000; width: 1.30in; height: 1.22in; }

		.table1 { margin: 5px 0; width: 90%; }
		.table1 td, .table1 th, .table1 { border: 1px solid #000; }

		.table3 { width: 40%; margin: 10px 0; }

		.table3 td, .table2 td, .table2 th{ border: 1px solid #000; text-align: left; padding: 2px 3px; }
	</style>

	<?php $date = array("0000-00-00", "1970-01-01", "1969-12-31"); ?>
</head>
<body>
	<div class="header">

		<h4>FUKUNAGA KAIUN CO., LTD.</h4>
		
		<table>
			<tr>
				<td style="width: 20%;">
					<?php 
						$ci =& get_instance();
				        $ci->load->config('dir');
				        $upload_path = base_url() . $ci->config->item('upload_dir');

						$image = base_url() . BASE_IMG . 'user-photo.jpg';
						if($photo <> ''){
							$image = $upload_path . 'media/' . $photo;
							echo "<img src='{$image}' class='pic' />";
						} else {
							echo "<div class='pic'></div>";
						} 
					?>
				</td>

				<td style="width: 55%; text-align: center;"> <h1>BIO - DATA</h1></td>

				<td style="width: 25%; vertical-align: top; text-align: right">
					<table class="table1" cellpadding="0" cellspacing="0" style="width: 100%;">
						<tr>
							<th colspan="3">CHECKED BY</th>
						</tr>
						<tr>
							<th style="text-align: center; width: 33%;">D.S.M/M.R.</th>
							<th style="text-align: center; width: 33%;">L.S.M.G.</th>
							<th style="text-align: center; width: 33%;">C.P.T.</th>
						</tr>
						<tr>
							<td style="height: 80px;">&nbsp;</td>
							<td style="height: 80px;">&nbsp;</td>
							<td style="height: 80px;">&nbsp;</td>
						</tr>
					</table>
					<table>
						<tr>
							<th style="text-align: right; width: 60%;">DATE:</th>
							<td style="width: 40%; text-align: center;" class="uline">
								<?php echo date('F d, Y'); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 19%; text-align: right;"><p>Rank</p></td>
				<td style="width: 27%; text-align: center;"><p><?php echo strtoupper($position) ?></p></td>
				<td style="width: 15%; text-align: right"><p>Name</p></td>
				<td style="width: 39%; text-align: center;"><p><?php echo strtoupper($fullname) ?></p></td>
			</tr>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 19%; text-align: right;" rowspan="2"><p>Name of Seaman</p></td>
				<td style="width: 27%; text-align: center;"><p>Surname</p></td>
				<td style="width: 27%; text-align: center;"><p>Given Name</p></td>
				<td style="width: 27%; text-align: center;"><p>Middel Name</p></td>
			</tr>
			<tr>
				<td style="text-align: center;"><p><?php echo strtoupper($lastname) ?></p></td>
				<td style="text-align: center;"><p><?php echo strtoupper($firstname) ?></p></td>
				<td style="text-align: center;"><p><?php echo strtoupper($middlename) ?></p></td>
			</tr>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 40%; text-align: center;"><p>Other Name Used (Maiden, Religious, Aliases)</p></td>
				<td style="width: 60%;"><p>&nbsp;</p></td>
			</tr>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 19%; text-align: right;"><p>Name of Vessel</p></td>
				<td style="width: 81%; "><p><?php echo strtoupper($vessel_name) ?></p></td>
			</tr>
			<tr>
				<td style="text-align: right;"><p>Address</p></td>
				<td><p><?php echo strtoupper($pres_address) ?></p></td>
			</tr>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 19%; text-align: right;" rowspan="2"><p>Telephone No.</p></td>
				<td style="width: 15%; text-align: center; border-bottom: none;"><p>Home</p></td>
				<td style="width: 26%; border-bottom: none;"><p><?php echo strtoupper($pres_tel) ?></p></td>
				<td style="width: 15%; text-align: center; border-bottom: none;"><p>Fax</p></td>
				<td style="width: 25%; border-bottom: none;"><p>&nbsp;</p></td>

			</tr>
			<tr>
				<td style="text-align: center; border-top-style: dashed;"><p>Email</p></td>
				<td style="border-top-style: dashed;"><p><?php echo strtoupper($email) ?></p></td>
				<td style="text-align: center; border-top-style: dashed;"><p>Mobile</p></td>
				<td style="border-top-style: dashed;"><p><?php echo strtoupper($cellphone) ?></p></td>
			</tr>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 19%; text-align: right;"><p>Nationality</p></td>
				<td style="width: 29%;"><p>FILIPINO</p></td>
				<td style="width: 25%; text-align: center;">National Identification Number</td>
				<td style="width: 27%;"><p>&nbsp;</p></td>
			</tr>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 19%; text-align: right;"><p>Clan or Tribe Name</p></td>
				<td style="width: 36%;"><p>&nbsp;</p></td>
				<td style="width: 20%; text-align: center;">Religion</td>
				<td style="width: 25%;"><p><?php echo strtoupper($religion) ?></p></td>
			</tr>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 19%; text-align: right;"><p>Date of Birth</p></td>
				<td style="width: 19%; text-align: center;"><p><?php echo date('M d, Y', strtotime($birthdate)); ?></p></td>
				<td style="width: 12%; text-align: center;">Age</td>
				<td style="width: 10%; text-align: center;">
					<p>
						<?php echo isset($birthdate)? get_age(date('Y-m-d', strtotime($birthdate))) . 'y/o' : '' ?>
					</p>
				</td>
				<td style="width: 15%; text-align: center;"><p>Birth Place</p></td>
				<td style="width: 25%;"><p><?php echo strtoupper($birthplace) ?></p></td>
			</tr>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 19%; text-align: right;"><p>Civil Status</p></td>
				<td style="width: 15%; text-align: center;"><p><?php echo strtoupper($civil_status) ?></p></td>
				<td style="width: 12%; text-align: center;">Weight</td>
				<td style="width: 12%; text-align: center;"><p><?php echo strtoupper($weight) ?></p></td>
				<td style="width: 10%; text-align: center;"><p>Height</p></td>
				<td style="width: 12%; text-align: center;"><p><?php echo strtoupper($height) ?></p></td>
				<td style="width: 10%; text-align: center;"><p>Chest Size</p></td>
				<td style="width: 10%;"><p>&nbsp;</p></td>
			</tr>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 27%;"><p>Name of Wife or Nearest Relative </p></td>
				<td style="width: 73%;"><p><?php echo strtoupper($beneficiary) ?></p></td>
			</tr>
			<tr>
				<td style="border-top: none;"><p>and Address</p></td>
				<td style="border-top: none;"><p><?php echo strtoupper($benef_add) ?></p></td>
			</tr>
		</table>
	</div>

	<div class="gen_info">
		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="3">1. EDUCATIONAL ATTAINMENT</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 16%;">Year</th>
					<th style="text-align: center; width: 44%;">School</th>
					<th style="text-align: center; width: 40%;">Course Finished</th>
				</tr>
				<?php 
				if($education):
					foreach ($education as $value): 
				?>
				<tr>
					<td style="text-align: center;"><?php echo $value->year; ?></td>
					<td style="text-align: center;"><?php echo $value->school; ?></td>
					<td style="text-align: center;"><?php echo $value->course; ?></td>
				</tr>
				<?php 
					endforeach;
				endif; 
				?>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="6">2. LICENSE / SPECIAL QUALIFIED CERTIFICATE (Liberia)</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 26%;">&nbsp;</th>
					<th style="text-align: center; width: 10%;">Rank</th>
					<th style="text-align: center; width: 15%;">Number</th>
					<th style="text-align: center; width: 12%;">Date Issued</th>
					<th style="text-align: center; width: 12%;">Expiry Date</th>
					<th style="text-align: center; width: 25%;">Issued By</th>
				</tr>
				<?php 
				$docs_license = objectToArray($docs);
				if($docs_license):
					$docs_id = array(4 => 'National', 9 => 'National (Radio)', 14 => 'Panama', 15 => 'Panama (Radio)');
					
					foreach ($docs_id as $key => $value):
						$arr = search_arr($docs_license, 'docs_id', $key);
					
						if(!isset($arr[0])) {
							$arr = array(0 => array(
											'docs_id' 		=> $key,
											'date_issued' 	=> '',
											'date_expired' 	=> ''
											)
									);
						}
						$arr = arrayToObject($arr[0]);
						$date_iss  	= ($arr->date_issued)? $arr->date_issued : '';
						$date_expr  = ($arr->date_expired)? $arr->date_expired : '';
						$arr->document 	 	= $docs_id[$arr->docs_id];

						$issue = '';

						if ($arr->docs_id == 4) {
							$issue = 'P.R.C. - PHILS.';
						}elseif ($arr->docs_id == 9){
							$issue = 'N.T.C. - PHILS.';
						}
				?>			
					<tr>
						<td><?php echo isset($arr->document)? $arr->document : ''; ?></td>
						<td style="padding-left: 5px;"><?php echo isset($arr->capacity)? $arr->capacity : ''; ?></td>
						<td style="padding-left: 5px;"><?php echo isset($arr->docs_nos)? $arr->docs_nos : ''; ?></td>
						<td style="text-align: center;"><?php echo isset($arr->date_issued)? $arr->date_issued : ''; ?></td>
						<td style="text-align: center;"><?php echo isset($arr->date_expired)? $arr->date_expired : ''; ?></td>
						<td style="padding-left: 5px;"><?php echo isset($issue)? $issue : ''; ?></td>
					</tr>
					
				<?php 
					unset($arr);
					endforeach;
				endif; 
				?>	
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="6">3. CERTIFICATES</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 26%;">&nbsp;</th>
					<th style="text-align: center; width: 10%;">Rank</th>
					<th style="text-align: center; width: 15%;">Number</th>
					<th style="text-align: center; width: 12%;">Date Issued</th>
					<th style="text-align: center; width: 12%;">Expiry Date</th>
					<th style="text-align: center; width: 25%;">Issued By</th>
				</tr>
				<?php 
				if($docs):
					$docs_id = array(3 => 'Passport', 1 => 'Seaman\'s Book (National)', 
									13 => 'Seaman\'s Book/Radio(Panama)', 14 => 'Seaman\'s Book (Panama)',
									30 => 'Seaman\'s Book (Liberia)');
					foreach ($docs as $value): 

						$date_iss = (!in_array($value->date_issued, $date))? date('m/d/Y', strtotime($value->date_issued)) : '';
						$date_end = (!in_array($value->date_expired, $date))? date('m/d/Y', strtotime($value->date_expired)) : '';

						if (array_key_exists($value->docs_id, $docs_id)):	

							if($value->docs_nos == '0') continue;
						  	$issue = '&nbsp;';

							if ($value->docs_id == 3) {
								$issue = 'D.F.A. - PHILS.';
							}elseif ($value->docs_id == 1){
								$issue = 'MARINA - PHILS.';
							}					  
				?>			
					<tr>
						<td><?php echo $docs_id[$value->docs_id]; ?></td>
						<td style="padding-left: 5px;"><?php echo $value->capacity; ?></td>
						<td style="padding-left: 5px;"><?php echo $value->docs_nos; ?></td>
						<td style="text-align: center;"><?php echo $date_iss; ?></td>
						<td style="text-align: center;"><?php echo $date_end; ?></td>
						<td style="padding-left: 5px;"><?php echo $issue; ?></td>
					</tr>
					
				<?php 
						endif; 
					endforeach;
				endif; 
				?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="6">4. VISA</th>
				</tr>
				<tr>
					<th style="text-align: center;" colspan="6">U.S.A</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 26%;">CLASS</th>
					<th style="text-align: center; width: 10%;">Issuing Post Name</th>
					<th style="text-align: center; width: 15%;">Control Number</th>
					<th style="text-align: center; width: 12%;">Date Issued</th>
					<th style="text-align: center; width: 12%;">Expiry Date</th>
					<th style="text-align: center; width: 25%;">Issued By</th>
				</tr>

				<?php 
				if($docs):
					$docs_id = array(10);
					foreach ($docs as $value): 

						$date_iss = (!in_array($value->date_issued, $date))? date('m/d/Y', strtotime($value->date_issued)) : '';
						$date_end = (!in_array($value->date_expired, $date))? date('m/d/Y', strtotime($value->date_expired)) : '';

						if (in_array($value->docs_id, $docs_id)):						  
				?>			
					<tr>
						<td><?php echo $document = $value->document; ?></td>
						<td style="padding-left: 5px;">MANILA</td>
						<td style="padding-left: 5px;"><?php echo $value->docs_nos; ?></td>
						<td style="text-align: center;"><?php echo $date_iss; ?></td>
						<td style="text-align: center;"><?php echo $date_end; ?></td>
						<td style="padding-left: 5px;">&nbsp;</td>
					</tr>
					
				<?php 
						endif; 
					endforeach;
				endif; 
				?>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="text-align: center;" colspan="6">AUSTRALIA</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 26%;">CLASS</th>
					<th style="text-align: center; width: 10%;">Issuing Post Name</th>
					<th style="text-align: center; width: 15%;">Control Number</th>
					<th style="text-align: center; width: 12%;">Date Issued</th>
					<th style="text-align: center; width: 12%;">Expiry Date</th>
					<th style="text-align: center; width: 25%;">Issued By</th>
				</tr>
				<tr>
					<td>MCV</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="5">5. OTHER CERTIFICATE (PRC/TESDA)</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 10%;">&nbsp;</th>
					<th style="text-align: center; width: 15%;">Number</th>
					<th style="text-align: center; width: 26%;">Regulation</th>
					<th style="text-align: center; width: 12%;">Date Issued</th>
					<th style="text-align: center; width: 12%;">Expiry Date</th>
					<th style="text-align: center; width: 25%;">Remarks</th>
				</tr>
				<?php 
				if($docs):
					$docs_id = array();

					if($division_id == 1) {
						$docs_id[] = 7;
					} else {
						$docs_id[] = 8;
					}

					foreach ($docs as $value): 
						$date_iss = (!in_array($value->date_issued, $date))? date('m/d/Y', strtotime($value->date_issued)) : '';
						$date_end = (!in_array($value->date_expired, $date))? date('m/d/Y', strtotime($value->date_expired)) : '';

						if (in_array($value->docs_id, $docs_id)):		
							if($value->docs_nos == '0' || $value->docs_nos == '') continue;			  
				?>			
					<tr>
						<td>STCW</td>
						<td><?php echo $value->docs_nos; ?></td>
						<td style="padding-left: 5px;"><?php echo $value->remarks; ?></td>
						<td style="text-align: center;"><?php echo $date_iss; ?></td>
						<td style="text-align: center;"><?php echo $date_end; ?></td>
						<td style="padding-left: 5px;">&nbsp;</td>
					</tr>
					
				<?php 
						endif; 
					endforeach;
				endif; 
				?>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="4">6. OTHER CERTIFICATE</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 37%;">ITEM</th>
					<th style="text-align: center; width: 19%;">Number</th>
					<th style="text-align: center; width: 20%;">Date Issued</th>
					<th style="text-align: center; width: 25%;">Remarks</th>
				</tr>
				<?php 
				if($docs):
					$docs_id = array(65,71,73,80,82,88,89,90,91,92,97,105,106,108,112,117,118,123);
					
					foreach ($docs_id as $key => $value):
						$arr = search_arr($docs_license, 'docs_id', $key);
					
						if(!isset($arr[0])) continue;
						$arr = arrayToObject($arr[0]);

						$arr->date_issued  	= (!in_array($arr->date_issued, $date))? date('m/d/Y', strtotime($arr->date_issued)) : '';
						$arr->date_expired  = (!in_array($arr->date_expired, $date))? date('m/d/Y', strtotime($arr->date_expired)) : '';
				?>			
					<tr>
						<td><?php echo isset($arr->document)? $arr->document : ''; ?></td>
						<td style="padding-left: 5px;"><?php echo isset($arr->docs_nos)? $arr->docs_nos : ''; ?></td>
						<td style="text-align: center;"><?php echo isset($arr->date_issued)? $arr->date_issued : ''; ?></td>
						<td style="padding-left: 5px;"><?php echo isset($arr->remarks)? $arr->remarks : ''; ?></td>
					</tr>
					
				<?php 
					unset($arr);
					endforeach;
				endif; 
				unset($docs_license);
				?>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="4">7. PHYSICAL INSPECTION AND VACCINATION</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 37%;">ITEM</th>
					<th style="text-align: center; width: 19%;">Date Issued</th>
					<th style="text-align: center; width: 20%;">Expiry Date</th>
					<th style="text-align: center; width: 25%;">Remarks</th>
				</tr>
				<tr>
					<td>Physical Inspection</td>
					<td style="text-align: center;"> - </td>
					<td style="text-align: center;"> - </td>
					<td style="text-align: center;">&nbsp;</td>
				</tr>
				<?php 
				if($docs):
					$docs_id = array(142, 144);
					foreach ($docs as $value): 
						$date_iss = (!in_array($value->date_issued, $date))? date('m/d/Y', strtotime($value->date_issued)) : '';
						$date_end = (!in_array($value->date_expired, $date))? date('m/d/Y', strtotime($value->date_expired)) : '';
						if (in_array($value->docs_id, $docs_id)):					  
				?>			
					<tr>
						<td><?php echo $value->document; ?></td>
						<td style="text-align: center;"><?php echo $date_iss; ?></td>
						<td style="text-align: center;"><?php echo $date_end; ?></td>
						<td style="padding-left: 5px;"><?php echo $value->remarks; ?></td>
					</tr>
					
				<?php 
						endif; 
					endforeach;
				endif; 
				?>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="6">8. ENGLISH LINGUISTICS</th>
				</tr>
				<tr>
					<td style="width: 35%;">&nbsp;</th>
					<td style="text-align: center;" colspan="5">Evaluation</td>
				</tr>
				<tr>
					<td>Read and Write</th>
					<td style="text-align: center; width: 13%; border-right: none; <?php echo ($read_write == 1)? 'font-weight: bold;' : ''?>">5 Excellent</td>
					<td style="text-align: center; width: 13%; border-right: none; border-left: none; <?php echo ($read_write == 2)? 'font-weight: bold;' : ''?>">4 Good</td>
					<td style="text-align: center; width: 13%; border-right: none; border-left: none; <?php echo ($read_write == 3)? 'font-weight: bold;' : ''?>">3 Acceptable</td>
					<td style="text-align: center; width: 13%; border-right: none; border-left: none; <?php echo ($read_write == 4)? 'font-weight: bold;' : ''?>">2 Poor</td>
					<td style="text-align: center; width: 13%; border-left: none; <?php echo ($read_write == 5)? 'font-weight: bold;' : ''?>">1 Unsuitable</td>
				</tr>
				<tr>
					<td>Speak and Listen</th>
					<td style="text-align: center; border-right: none; <?php echo ($speak_listen == 1)? 'font-weight: bold;' : ''?>">5 Excellent</td>
					<td style="text-align: center; border-right: none; border-left: none; <?php echo ($speak_listen == 2)? 'font-weight: bold;' : ''?>">4 Good</td>
					<td style="text-align: center; border-right: none; border-left: none; <?php echo ($speak_listen == 3)? 'font-weight: bold;' : ''?>">3 Acceptable</td>
					<td style="text-align: center; border-right: none; border-left: none; <?php echo ($speak_listen == 4)? 'font-weight: bold;' : ''?>">2 Poor</td>
					<td style="text-align: center; border-left: none; <?php echo ($speak_listen == 5)? 'font-weight: bold;' : ''?>">1 Unsuitable</td>
				</tr>
				<tr>
					<td>Other Languages</th>
					<td style="text-align: center;" colspan="5"><?php echo $other_language ?></td>
				</tr>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="4">9. TRAINING FOR "ISM SYSTEM" *MASTER,CHIEF ENGINEER ONLY</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 40%;" colspan="2">Training for "ISM SYSTEM"</th>
					<th style="text-align: center; width: 20%;">Date</th>
					<th style="text-align: center; width: 40%;">Evaluation</th>
				</tr>
				<tr>
					<td style="text-align: center; width: 20%; border-right: none;">1. Yes</td>
					<td style="text-align: center; width: 20%; border-left: none;">2. No</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="6">10. SEAMAN'S HISTORY</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 20%;">Vessel's Name</th>
					<th style="text-align: center; width: 8%;">Rank</th>
					<th style="text-align: center; width: 17%;">Gross Tonnage</th>
					<th style="text-align: center; width: 25%;" rowspan="2">Manning Company</th>
					<th style="text-align: center; width: 13%;">Sign On</th>
					<th style="text-align: center; width: 17%;" rowspan="2">Reason of Sign-Off</th>
				</tr>
				<tr>
					<th style="text-align: center;">Flag</th>
					<th style="text-align: center;">Type</th>
					<th style="text-align: center;">Engine Type / HP</th>
					<th style="text-align: center;">Sign Off</th>
				</tr>
				<?php 
				if($work_history):
					foreach ($work_history as $value): 
						$remarks = '';
						switch ($value->remarks) {
							case 'FC':
								$remarks = 'FINISHED CONTRACT';
								break;
							case 'PR':
								$remarks = 'PROMOTION';
								break;
							case 'TR':
								$remarks = 'TRANSFER';
								break;
							case 'VT':
								$remarks = 'VESSEL TRANSFER';
								break;
						}
				?>
				<tr>
					<td style="padding-left: 5px;"><?php echo $value->vessel; ?></td>
					<td style="padding-left: 5px;"><?php echo $value->rank; ?></td>
					<td style="padding-left: 5px;"><?php echo $value->grt; ?></td>
					<td style="padding-left: 5px;" rowspan="2"><?php echo $value->company; ?></td>
					<td style="text-align: center;"><?php echo ($value->embarked == '0000-00-00')? '&nbsp;' : date('d-M-Y', strtotime($value->embarked)); ?></td>
					<td style="padding-left: 5px;" rowspan="2"><?php echo $remarks; ?></td>
				</tr>
				<tr>
					<td style="padding-left: 5px;"><?php echo $value->flag; ?></td>
					<td style="padding-left: 5px;"><?php echo $value->type; ?></td>
					<td style="padding-left: 5px;"><?php echo $value->engine; ?></td>
					<td style="text-align: center;"><?php echo ($value->disembarked == '0000-00-00')? '&nbsp;' :  date('d-M-Y', strtotime($value->disembarked)); ?></td>
				</tr>
				<?php endforeach; 
				endif;
				?>
			</table>
		</div>

		<div style="page-break-inside: avoid; ">
			<table class="table3" cellpadding="0" cellspacing="0">
				<tr>
					<td>Crew's Name</td>
					<td><?php echo $fullname ?></td>
				</tr>
			</table>
			<div class="clear"></div>
		</div>
		<hr>

		<p style="font-size: 10px;">BIO DATA (Form No. CPT-003) <br/> 01/Aug/2012 <span style="font-size: 9px;">(Ship Management Group)</span></p>
	
	</div>
</body>
</html>