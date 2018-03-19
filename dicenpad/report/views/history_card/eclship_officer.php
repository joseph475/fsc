<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - ECL Officer History Card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body {
			font: normal 12px arial,sans-serif;
		}

		@page { margin: 0.5in 0.5in 0.5in 0.5in;}

		p { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.header h4 { font: bold 24px "Times New Roman",Georgia,Serif;text-align: center; }
		.header h3 { font: bold 16px "Times New Roman",Georgia,Serif;}

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
		<h4>ECL Shipmanagement Co., Ltd.</h4>
		<table>
			<tr>
				<td style="width: 30%; vertical-align: top;">
					<table class="table1" cellpadding="0" cellspacing="0">
						<tr>
							<th style="text-align: center; border-bottom: none;">Manning Company</th>
						</tr>
						<tr>
							<td style="text-align: center;">CORDIAL SHIPPING INC.</td>
						</tr>
					</table>

					<table class="table1" cellpadding="0" cellspacing="0">
						<tr>
							<th style="text-align: center; border-bottom: none;">Data verified</th>
						</tr>
						<tr>
							<td style="text-align: center;">&nbsp;</td>
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
				<td style="border: none;" colspan="7">Endorsed to:  <b>EASTERN CAR LINER CO.,  LTD.</b></td>
				<th style="text-align: center; border: none;">Date</th>
				<td style="text-align: center; border: none;"><?php echo date('d-F-y'); ?></td>
			</tr>
			<tr>
				<td colspan="2">Vessel Name</td>
				<th colspan="3"><?php echo strtoupper($vessel_name) ?></th>
				<td>Vessel Flag</td>
				<th><?php echo strtoupper($flag) ?></th>
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
				<td style="width: 17%;" colspan="2">Date of birth</td>
				<td style="width: 18%;" colspan="2"><?php echo date('d-M-Y', strtotime($birthdate)); ?></td>
				<td style="width: 9%;">Age</td>
				<td style="width: 27%;" colspan="2"><?php echo get_age($birthdate); ?></td>
				<td style="width: 12%;">Blood Type</td>
				<td style="width: 17%;"><?php echo $blood_type ?></td>
			</tr>
			<tr>
				<td style="width: 9%;">Weight</td>
				<td style="width: 8%;"><?php echo $weight ?></td>
				<td style="width: 9%;">Height</td>
				<td style="width: 9%;"><?php echo $height ?></td>
				<td style="width: 14%;" colspan="2">Clothe Size</td>
				<td style="width: 22%;"><?php echo $clothe_size ?></td>
				<td style="width: 12%;">Shoe Size</td>
				<td style="width: 17%;"><?php echo $shoe_size ?></td>
			</tr>
			<tr>
				<td colspan="7">Manning Company Registered address</td>
				<td>Tel. No.</td>
				<th><?php echo strtoupper($pres_tel) ?></th>
			</tr>
			<tr>
				<th colspan="7"><?php echo strtoupper($pres_address) ?></th>
				<td>Fax. No.</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="9">Family record (address)</td>
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
				<td style="border: none;" colspan="3">1. EDUCATIONAL ATTAINMENT</td>
			</tr>
			<tr>
				<td style="text-align: center; width: 16%;">Course Commenced</td>
				<td style="text-align: center; width: 44%;">School</td>
				<td style="text-align: center; width: 40%;">Course Finished</td>
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
				<td style="border: none;" colspan="6">2. LICENSE</td>
			</tr>
			<tr>
				<td style="text-align: center; width: 16%;">Country</td>
				<td style="text-align: center; width: 13%;">Rank</td>
				<td style="text-align: center; width: 18%;">Number</td>
				<td style="text-align: center; width: 13%;">Date Issued</td>
				<td style="text-align: center; width: 13%;">Expiry Date</td>
				<td style="text-align: center; width: 27%;">Issued by</td>
			</tr>
			<?php 
			if($docs):
				$docs_id = array(4 => 'PHILIPPINES', 14 => 'PANAMA', 15 => 'PANAMA GMDSS', 16 => 'PANAMA SSO', 
								30 => 'LIBERIA', 31 => 'LIBERIA GMDSS', 32 => 'LIBERIA SSO');
				foreach ($docs as $value): 

					$date_iss = (!in_array($value->date_issued, $date))? date('d-M-Y', strtotime($value->date_issued)) : '';
					$date_end = (!in_array($value->date_expired, $date))? date('d-M-Y', strtotime($value->date_expired)) : '';

					if (array_key_exists($value->docs_id, $docs_id)):	

						if($value->docs_nos == '0') continue;					  
			?>			
				<tr>
					<td><?php echo $docs_id[$value->docs_id]; ?></td>
					<td style="text-align: center;"><?php echo $value->capacity; ?> </td>
					<td style="text-align: center;"><?php echo $value->docs_nos; ?></td>						
					<td style="text-align: center;"><?php echo $date_iss; ?></td>
					<td style="text-align: center;"><?php echo $date_end; ?></td>
					<td style="text-align: center;">PHILIPPINES</td>
				</tr>
				
			<?php 
					endif; 
				endforeach;
			endif; 
			?>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="border: none;" colspan="5">3. CERTIFICATE</td>
			</tr>
			<tr>
				<td style="text-align: center; width: 29%;">Type</td>
				<td style="text-align: center; width: 18%;">Number</td>
				<td style="text-align: center; width: 13%;">Date Issued</td>
				<td style="text-align: center; width: 13%;">Expiry Date</td>
				<td style="text-align: center; width: 27%;">Issued by</td>
			</tr>
			<?php 
			if($docs):
				$docs_id = array(3 => 'PASSPORT', 1 => 'SEAMAN\'S BOOK', 10 => 'U.S. VISA');

				foreach ($docs as $value): 

					$date_iss = (!in_array($value->date_issued, $date))? date('d-M-Y', strtotime($value->date_issued)) : '';
					$date_end = (!in_array($value->date_expired, $date))? date('d-M-Y', strtotime($value->date_expired)) : '';

					if (array_key_exists($value->docs_id, $docs_id)):					  
			?>			
				<tr>
					<td><?php echo $docs_id[$value->docs_id]; ?></td>
					<td style="text-align: center;"><?php echo $value->docs_nos; ?></td>										
					<td style="text-align: center;"><?php echo $date_iss; ?></td>
					<td style="text-align: center;"><?php echo $date_end; ?></td>
					<td style="text-align: center;">PHILIPPINES</td>
				</tr>
				
			<?php 
					endif; 
				endforeach;
			endif; 
			?>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="border: none;" colspan="5">4. PHYSICAL EXAMANITATION</td>
			</tr>
			<tr>
				<td style="text-align: center; width: 29%;">Type</td>
				<td style="text-align: center; width: 18%;">Number</td>
				<td style="text-align: center; width: 13%;">Date Issued</td>
				<td style="text-align: center; width: 13%;">Expiry Date</td>
				<td style="text-align: center; width: 27%;">Issued by</td>
			</tr>
			<?php 
			if($docs):
				$docs_id = array(140);
				foreach ($docs as $value): 

					$date_iss = (!in_array($value->date_issued, $date))? date('d-M-Y', strtotime($value->date_issued)) : '';
					$date_end = (!in_array($value->date_expired, $date))? date('d-M-Y', strtotime($value->date_expired)) : '';

					if (in_array($value->docs_id, $docs_id)):					  
			?>			
				<tr>
					<td><?php echo $value->document; ?></td>
					<td style="text-align: center;"><?php echo $value->docs_nos; ?></td>														
					<td style="text-align: center;"><?php echo $date_iss; ?></td>
					<td style="text-align: center;"><?php echo $date_end; ?></td>
					<td style="text-align: center;"><?php echo $value->remarks; ?></td>
				</tr>
				
			<?php 
					endif; 
				endforeach;
			endif; 
			?>
		</table>


			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<td style="border: none;" colspan="5">5. TRAINING for ISM SYSTEM</td>
				</tr>
				<tr>
					<td style="text-align: center; width: 47%;" colspan="3">Training</td>
					<td style="text-align: center; width: 13%;">Date</td>
					<td style="text-align: center; width: 40%;">Place</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>

			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<td style="border: none;" colspan="6">6. SEAMAN'S HISTORY - previous to latest</td>
				</tr>
				<tr>
					<td style="text-align: center; width: 20%;">Vessel's Name</td>
					<td style="text-align: center; width: 8%;">Type</td>
					<td style="text-align: center; width: 17%;">Gross Tonnage</td>
					<td style="text-align: center; width: 20%;" rowspan="2">Manning Company</td>
					<td style="text-align: center; width: 13%;">Sign On</td>
					<td style="text-align: center; width: 22%;" rowspan="2">Reason of Sign-Off</td>
				</tr>
				<tr>
					<td style="text-align: center;">Flag</td>
					<td style="text-align: center;">Rank</td>
					<td style="text-align: center;">Engine Type / HP</td>
					<td style="text-align: center;">Sign Off</td>
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
					<td style="text-align: center;"><?php echo $value->vessel; ?></td>
					<td style="text-align: center;"><?php echo $value->type; ?></td>
					<td style="text-align: center;"><?php echo $value->grt; ?></td>
					<td style="text-align: center;" rowspan="2"><?php echo $value->company; ?></td>
					<td style="text-align: center;"><?php echo ($value->embarked == '0000-00-00')? '&nbsp;' : date('d-M-Y', strtotime($value->embarked)); ?></td>
					<td style="text-align: center;" rowspan="2"><?php echo $remarks; ?></td>
				</tr>
				<tr>
					<td style="text-align: center;"><?php echo $value->flag; ?></td>
					<td style="text-align: center;"><?php echo $value->rank; ?></td>
					<td style="text-align: center;"><?php echo $value->engine; ?></td>
					<td style="text-align: center;"><?php echo ($value->disembarked == '0000-00-00')? '&nbsp;' : date('d-M-Y', strtotime($value->disembarked)); ?></td>
				</tr>
				<?php endforeach; 
				endif;
				?>
			</table>	

			<table class="table2" cellpadding="0" cellspacing="0">
				<tr>
					<td style="border: none;" colspan="4">7. OTHER CERTIFICATES (Solas / Marpol / Others.)</td>
				</tr>
				<tr>
					<td style="text-align: center; width: 40%;">Type</td>
					<td style="text-align: center; width: 24%;">Number</td>
					<td style="text-align: center; width: 18%;">Date Issued</td>
					<td style="text-align: center; width: 18%;">Expiry Date</td>
				</tr>
				<?php 
				if($docs):
					$docs_id = array(79 => 'STCW', 65 => 'BASIC SAFETY COURSE', 74 => 'PROFICIENCY IN SURVIVAL CRAFT / RESCUE BOATS', 
									70 => 'PREVENTION OF ALCOHOL AND DRUG ABUSE IN MAR. SECTOR', 71 => 'MEDICAL EMERGENCY / FIRST AID',
									72 => 'MEDICAL CARE', 73 => 'ADVANCE FIRE FIGHTING', 76 => 'MARITIME ENGLISH', 82 => 'SHIP SECURITY OFFICER', 98 => 'AUTOMATIC IDENTIFICATION SYSTEM',
									99 => 'RADAR OBSERVATION AND PLOTTING', 101 => 'RADAR SIMULATOR COURSE', 100 => 'AUTOMATIC RADAR AND PLOTTING AIDS', 
									102 => 'SHIP RESTRICTED RADIO TELEPHONE OPERATORS COURSE', 103 => 'GLOBAL MARITIME DISTRESS AND SAFETY SYSTEM', 
									104 => 'INTERNATIONAL MARITIME SATELLITE COM. ', 105 => 'SHIP SIMULATOR AND BRIDGE TEAMWORK', 106 => 'BRIDGE RESOURCE MANAGEMENT', 
									107 => 'SHIP HANDLING MANUEVERING', 134 => 'MARPOL73/78, ANNEX II', 133 => 'MARPOL73/78, ANNEX I', 7 => 'CERTIFICATE OF COMPETENCY FOR SEAFARERS');
					foreach ($docs as $value): 

						$date_iss = (!in_array($value->date_issued, $date))? date('d-M-Y', strtotime($value->date_issued)) : '';
						$date_end = (!in_array($value->date_expired, $date))? date('d-M-Y', strtotime($value->date_expired)) : '';

						if (array_key_exists($value->docs_id, $docs_id)):				  
				?>			
					<tr>
						<td><?php echo $docs_id[$value->docs_id]; ?></td>
						<td style="text-align: center;"><?php echo $value->docs_nos; ?></td>												
						<td style="text-align: center;"><?php echo $date_iss; ?></td>
						<td style="text-align: center;"><?php echo $date_end; ?></td>
					</tr>
					
				<?php 
						endif; 
					endforeach;
				endif; 
				?>
			</table>
		</div>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="border: none;" colspan="6">8. ENGLISH LINGUISTICS</td>
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