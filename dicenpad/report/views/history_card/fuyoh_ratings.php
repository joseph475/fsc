<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Janfiel Ratings History Card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body {
			font-size: 12px; 
		}

		@page { margin: 0.2in 0.5in 0.2in 0.5in;}

		p { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.gen_info h4 { text-decoration: underline; }

		table { margin: 0; padding: 0; width: 100%; font-size: 11px; }	
		table td { padding: 2px 0; vertical-align: middle; }	/*  border: 1px solid #cecece */
		table th { font-weight: bold; }
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 6px; padding: 0; text-align: center; }
		.pic { border: 1px solid #000; width: 1.30in; height: 1.22in; }

		.table1 { margin: 5px 0; width: 90%; }
		.table1 td, .table1 th, .table1 { border: 1px solid #000; }

		.table2 { margin-top: 10px; }
		.table2 td, .table2 th{ border: 1px solid #000; text-align: left; padding: 0 3px; }
	</style>

	<?php $date = array("0000-00-00", "1970-01-01", "1969-12-31"); ?>
</head>
<body>
	<div class="header">
		<table>
			<tr>
				<td style="width: 30%; vertical-align: top;">
					<table class="table1" cellpadding="0" cellspacing="0">
						<tr>
							<td style="text-align: center; border-bottom: none; ">Manning Company</td>
						</tr>
						<tr>
							<td style="text-align: center; font-family: 'Times New Roman'; font-weight: bold;">CORDIAL SHIPPING INC.</td>
						</tr>
					</table>

					<table class="table1" cellpadding="0" cellspacing="0">
						<tr>
							<td style="text-align: center; border-bottom: none;">Data verified</td>
						</tr>
						<tr>
							<td style="text-align: center; height: 40px;">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td style="width: 50%; text-align: center;"> <h3>BIO - DATA</h3></td>
				<td style="width: 20%; text-align: right;">
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
			</tr>
		</table>
	</div>

	<div class="gen_info">
		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="border: none;" colspan="7">Endorsed to:  <b>FUYOH SHIPPING COMPANY</b></td>
				<td style="text-align: center; border: none;">Date</td>
				<td style="text-align: center; border: none;"><?php echo date('d-M-Y'); ?></td>
			</tr>
			<tr>
				<td colspan="2">Vessel Name</td>
				<td colspan="5"><?php echo strtoupper($vessel_name) ?></td>
				<td>Rank</td>
				<td><?php echo strtoupper($position) ?></td>
			</tr>
			<tr>
				<td style="width: 17%;" colspan="2">Seaman Name</td>
				<td style="width: 25%;" colspan="3"><?php echo strtoupper($fullname) ?></td>
				<td style="width: 7%;">Place of Birth</td>
				<td style="width: 22%;"><?php echo strtoupper($birthplace) ?></td>
				<td style="width: 12%;">Nationality</td>
				<td style="width: 17%;">Filipino</td>
			</tr>
			<tr>
				<td style="width: 17%;" colspan="2">Date of Birth</td>
				<td style="width: 18%;" colspan="2"><?php echo date('F d, Y', strtotime($birthdate)) ?></td>
				<td style="width: 9%;">Age</td>
				<td style="width: 27%;" colspan="2"><?php echo get_age($birthdate) ?></td>
				<td style="width: 12%;">Blood Type</td>
				<td style="width: 17%;"><?php echo strtoupper($blood_type) ?></td>
			</tr>
			<tr>
				<td style="width: 9%;">Weight</td>
				<td style="width: 8%;"><?php echo $weight ?></td>
				<td style="width: 9%;">Height</td>
				<td style="width: 9%;"><?php echo $height ?></td>
				<td style="width: 14%;" colspan="2">Clothes Size</td>
				<td style="width: 22%;"><?php echo $clothe_size ?></td>
				<td style="width: 12%;">Safety Shoes</td>
				<td style="width: 17%;"><?php echo $shoe_size ?></td>
			</tr>
			<tr>
				<td colspan="7">Manning Company Registered address</td>
				<td style="border-right: none;" rowspan="2">Tel. No.</td>
				<td style="border-left: none;"rowspan="2"><?php echo strtoupper($pres_tel) ?></td>
			</tr>
			<tr>
				<td colspan="7">CORDIAL SHIPPING INC., 2079 Ignacia Haus., Madre Ignacia St. Malate, Manila</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td colspan="7">&nbsp;</td>
			</tr>
			<tr>
				<td style="text-align: center; width: 18%;" colspan="2">Relation</td>
				<td style="text-align: center; width: 32%;" colspan="4">Name</td>
				<td style="text-align: center; width: 22%;">Age</td>
				<td style="text-align: center; width: 28%;" colspan="2">Tel. No.</td>
			</tr>
			<tr>
				<td style="text-align: center;" colspan="2"><?php echo $benef_relation ?></td>
				<td style="text-align: center;" colspan="4"><?php echo $beneficiary ?></td>
				<td style="text-align: center;">&nbsp;</td>
				<td style="text-align: center;" colspan="2">&nbsp;</td>
			</tr>
			<?php 
			if($children):
				foreach ($children as $value): 
			?>
				<tr>
					<td style="text-align: center;" colspan="2"><?php echo $value->child_name; ?></td>
					<td style="text-align: center;"colspan="4"><?php echo $value->relationship; ?></td>
					<td style="text-align: center;"><?php echo get_age(date('Y-m-d', strtotime($value->child_birthdate))); ?></td>
					<td style="text-align: center;" colspan="2">&nbsp;</td>
				</tr>
			<?php 
				endforeach;
			endif; 
			?>
		</table>

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

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<th style="border: none;" colspan="6">2. LICENSE</th>
			</tr>
			<tr>
				<th style="text-align: center; width: 16%;">Country</th>
				<th style="text-align: center; width: 13%;">Rank</th>
				<th style="text-align: center; width: 18%;">Number</th>
				<th style="text-align: center; width: 13%;">Date Issued</th>
				<th style="text-align: center; width: 13%;">Expiry Date</th>
				<th style="text-align: center; width: 27%;">Issued by</th>
			</tr>
			<?php 
			$docs_license = objectToArray($docs);
			if($docs):
				$docs_id = array(4 => 'PHILIPPINES'); //13 => 'PANAMA', 15 => 'PANAMA GMDSS', 16 => 'PANAMA SSO', 29 => 'LIBERIA', 31 => 'LIBERIA GMDSS', 32 => 'LIBERIA SSO'
				foreach ($docs as $value): 

					$date_iss = ($value->date_issued)? $value->date_issued : '';
					$date_end = ($value->date_expired)? $value->date_expired : '';

					if (array_key_exists($value->docs_id, $docs_id) || $value->hasflag == 1):	
						if($value->docs_id == 152) continue;
						//if($value->docs_nos == '0' || $value->docs_nos == '') continue;					  
			?>			
				<tr>
					<td><?php echo ($value->hasflag)? $value->document : $docs_id[$value->docs_id]; ?></td>
					<td style="padding-left: 5px;"><?php echo $value->capacity; ?> </td>
					<td style="padding-left: 5px;"><?php echo $value->docs_nos; ?></td>						
					<td style="text-align: center;"><?php echo $date_iss; ?></td>
					<td style="text-align: center;"><?php echo $date_end; ?></td>
					<td style="padding-left: 5px;">MANILA, PHILIPPINES</td>
				</tr>				
			<?php 
					endif; 
				endforeach;
			endif; 
			?>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<th style="border: none;" colspan="5">3. CERTIFICATE</th>
			</tr>
			<tr>
				<th style="text-align: center; width: 29%;">Type</th>
				<th style="text-align: center; width: 18%;">Number</th>
				<th style="text-align: center; width: 13%;">Date Issued</th>
				<th style="text-align: center; width: 13%;">Expiry Date</th>
				<th style="text-align: center; width: 27%;">Issued by</th>
			</tr>
			<?php 
			if($docs_license):
				$docs_id = array(3 => 'PASSPORT', 1 => 'SEAMAN\'S BOOK', 10 => 'U.S. VISA');

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
				?>			
					<tr>
						<td><?php echo isset($arr->document)? $arr->document : ''; ?></td>
						<td style="padding-left: 5px;"><?php echo isset($arr->docs_nos)? $arr->docs_nos : ''; ?></td>
						<td style="text-align: center;"><?php echo isset($arr->date_issued)? $arr->date_issued : ''; ?></td>
						<td style="text-align: center;"><?php echo isset($arr->date_expired)? $arr->date_expired : ''; ?></td>
						<td style="padding-left: 5px;">PHILIPPINES</td>
					</tr>
					
				<?php 
					unset($arr);
				endforeach;
			endif; 
			?>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<th style="border: none;" colspan="5">4. PHYSICAL EXAMANITATION</th>
			</tr>
			<tr>
				<th style="text-align: center; width: 29%;">Type</th>
				<th style="text-align: center; width: 18%;">Number</th>
				<th style="text-align: center; width: 13%;">Date Issued</th>
				<th style="text-align: center; width: 13%;">Expiry Date</th>
				<th style="text-align: center; width: 27%;">Issued by</th>
			</tr>
			<?php 
			if($docs):
				$docs_id = array(140);
				foreach ($docs as $value): 

					$date_iss = ($value->date_issued)? $value->date_issued : '';
					$date_end = ($value->date_expired)? $value->date_expired : '';

					if (in_array($value->docs_id, $docs_id)):					  
			?>			
				<tr>
					<td><?php echo $value->document; ?></td>
					<td style="padding-left: 5px;"><?php echo $value->docs_nos; ?></td>														
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

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<th style="border: none;" colspan="5">5. TRAINING for ISM SYSTEM</th>
			</tr>
			<tr>
				<th style="text-align: center; width: 47%;" colspan="3">Training</th>
				<th style="text-align: center; width: 13%;">Date</th>
				<th style="text-align: center; width: 40%;">Place</th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="6">6. SEAMAN'S HISTORY - previous to latest</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 20%;">Vessel's Name</th>
					<th style="text-align: center; width: 8%;">Type</th>
					<th style="text-align: center; width: 17%;">Gross Tonnage</th>
					<th style="text-align: center; width: 20%;" rowspan="2">Manning Company</th>
					<th style="text-align: center; width: 13%;">Sign On</th>
					<th style="text-align: center; width: 22%;" rowspan="2">Reason of Sign-Off</th>
				</tr>
				<tr>
					<th style="text-align: center;">Flag</th>
					<th style="text-align: center;">Rank</th>
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
					<td style="padding-left: 5px;"><?php echo $value->type; ?></td>
					<td style="padding-left: 5px;"><?php echo $value->grt; ?></td>
					<td style="padding-left: 5px;" rowspan="2"><?php echo $value->company; ?></td>
					<td style="text-align: center;"><?php echo ($value->embarked == '0000-00-00')? '&nbsp;' : date('m/d/Y', strtotime($value->embarked)); ?></td>
					<td style="padding-left: 5px;" rowspan="2"><?php echo $remarks; ?></td>
				</tr>
				<tr>
					<td style="padding-left: 5px;"><?php echo $value->flag; ?></td>
					<td style="padding-left: 5px;"><?php echo $value->rank; ?></td>
					<td style="padding-left: 5px;"><?php echo $value->engine; ?></td>
					<td style="text-align: center;"><?php echo ($value->disembarked == '0000-00-00')? '&nbsp;' : date('m/d/Y', strtotime($value->disembarked)); ?></td>
				</tr>
				<?php endforeach; 
				endif;
				?>
			</table>	
		</div>			

		<div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<th style="border: none;" colspan="4">7. OTHER CERTIFICATES (Solas / Marpol / Others.)</th>
				</tr>
				<tr>
					<th style="text-align: center; width: 40%;">Type</th>
					<th style="text-align: center; width: 24%;">Number</th>
					<th style="text-align: center; width: 18%;">Date Issued</th>
					<th style="text-align: center; width: 18%;">Expiry Date</th>
				</tr>
				<?php 
				if($docs_license):
					$docs_id = array(79 => 'STCW', 65 => 'BASIC SAFETY COURSE', 74 => 'PROFICIENCY IN SURVIVAL CRAFT / RESCUE BOATS', 
									71 => 'MEDICAL EMERGENCY / FIRST AID', 76 => 'MARITIME ENGLISH FOR RATINGS', 
									67 => 'NAVIGATIONAL WATCH', 70 => 'PREVENTION OF ALCOHOL AND DRUG ABUSE IN MAR. SECTOR',
									80 => 'SHIP SECURITY AWARENESS', 8 => 'CERTIFICATE OF COMPETENCY FOR SEAFARERS');
					
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
				?>			
					<tr>
						<td><?php echo isset($arr->document)? $arr->document : ''; ?></td>
						<td style="padding-left: 5px;"><?php echo isset($arr->docs_nos)? $arr->docs_nos : ''; ?></td>
						<td style="text-align: center;"><?php echo isset($arr->date_issued)? $arr->date_issued : ''; ?></td>
						<td style="text-align: center;"><?php echo isset($arr->date_expired)? $arr->date_expired : ''; ?></td>
					</tr>
				<?php 
					unset($arr);
					endforeach;
				endif; 
				unset($docs_license);
				?>
			</table>
		</div>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<th style="border: none;" colspan="6">8. ENGLISH LINGUISTICS</th>
			</tr>
			<tr>
				<td style="width: 35%;">Read and Write</th>
				<td style="text-align: center; border-right: none; <?php echo ($read_write == 1)? 'font-weight: bold;' : ''?>">5 Excellent</td>
				<td style="text-align: center; border-right: none; border-left: none; <?php echo ($read_write == 2)? 'font-weight: bold;' : ''?>">4 Good</td>
				<td style="text-align: center; border-right: none; border-left: none; <?php echo ($read_write == 3)? 'font-weight: bold;' : ''?>">3 Acceptable</td>
				<td style="text-align: center; border-right: none; border-left: none; <?php echo ($read_write == 4)? 'font-weight: bold;' : ''?>">2 Poor</td>
				<td style="text-align: center; border-left: none; <?php echo ($read_write == 5)? 'font-weight: bold;' : ''?>">1 Unsuitable</td>
				
			</tr>
			<tr>
				<td>Speak and Listen</th>
				<td style="text-align: center; width: 13%; border-right: none; <?php echo ($speak_listen == 1)? 'font-weight: bold;' : ''?>">5 Excellent</td>
				<td style="text-align: center; width: 13%; border-right: none; border-left: none; <?php echo ($speak_listen == 2)? 'font-weight: bold;' : ''?>">4 Good</td>
				<td style="text-align: center; width: 13%; border-right: none; border-left: none; <?php echo ($speak_listen == 3)? 'font-weight: bold;' : ''?>">3 Acceptable</td>
				<td style="text-align: center; width: 13%; border-right: none; border-left: none; <?php echo ($speak_listen == 4)? 'font-weight: bold;' : ''?>">2 Poor</td>
				<td style="text-align: center; width: 13%; border-left: none; <?php echo ($speak_listen == 5)? 'font-weight: bold;' : ''?>">1 Unsuitable</td>
			</tr>
			<tr>
				<td>Other Languages</th>
				<td style="text-align: center;" colspan="5">Evaluation</td>
			</tr>
		</table>
		<p style="text-align: center; text-decoration: underline; margin: 10px 0;" >RANK / NAME : <?php echo strtoupper($position) . ' / ' . strtoupper($fullname); ?> </p>
		
		<table cellpadding="0" cellspacing="0" style="border: 1px solid #000;">
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<th style="width: 25%; text-align: left;"><p style="padding-left: 10px;">For official use:<p></th>
				<th style="width: 25%;">&nbsp;</th>
				<th style="width: 15%; text-align: center;">Hire</th>
				<th style="width: 35%; text-align: left;">Yes/No</th>
			</tr>
			<tr>
				<td style="height: 80px;" colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td class="uline">&nbsp;</td>
				<th style="text-align: left;">Marine Personal Manager </th>
				<td class="uline">&nbsp;</td>
				<th style="text-align: left;">DP </th>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
		</table>
	</div>
</body>
</html>