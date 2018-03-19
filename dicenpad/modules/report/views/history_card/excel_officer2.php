<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Excel Officer Card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body {
			font: normal 12px arial,sans-serif;
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
		table td.td_label { font-size: 7px; padding: 0; text-align: center; }
		.pic { border: 1px solid #000; width: 1.30in; height: 1.22in; }

		.table1 { margin: 5px 0; width: 90%; }
		.table1 td, .table1 th, .table1 { border: 1px solid #000; }

		.table2 { margin-top: 10px; }
		.table2 td, .table2 th{ border: 1px solid #000; text-align: left; padding: 0 3px; }

		.table2 .tbrd { border-bottom-style: dashed; border-top-style: dashed;}
		.table2 .tbrdb { border-bottom-style: solid; border-top-style: dashed;} 

		.table1a td {
			padding: 0;
		}
      	/*.footer { position: fixed; bottom: 8px; text-align: center; font-weight: bold; }*/
      	.flyleaf {
		    page-break-after: always;
	  	}

		.head, .foot {
			position: fixed;
		}

		.head {
			top: 0;
		}

		.foot {
			bottom: 0;
		}

		.revision { position: fixed; text-align: right; bottom: 60px; }
		.revision p { font-size: 9px; }
		.footer { position: fixed; text-align: center; bottom: 20px; font-size: 10px; }
      	.pagenum:before { content: counter(page); }
	</style>

	<?php $date = array("0000-00-00", "1970-01-01", "1969-12-31"); ?>
</head>
<body>
	<div class="revision"><p>Date: Sep., 2013 </p><p> Rev. 1.0</p> </div>
	<div class="footer"><span class="pagenum"></span></div>
	<div class="flyleaf">
		<div class="header">
			<p style="font-size: 10px;"><?php echo select_iso(19); ?></p>
			<table>
				<tr>
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

					<td style="width: 55%; text-align: center;"> <h1 style="font-size: 32px">BIO - DATA</h1></td>

					<td style="width: 25%; vertical-align: top; ">
						<h3 style="margin: 0; text-align: left;">EXCEL MARINE CO., LTD</h3>
						<table class="table1" cellpadding="0" cellspacing="0" style="width: 100%; margin-left: 10px; ">
							<tr>
								<td colspan="2" style="padding: 0 5px">CHECKED BY</td>
							</tr>
							<tr>
								<td style="text-align: center; width: 50%;">G.M</td>
								<td style="text-align: center; width: 50%;">MANAGER</td>
							</tr>
							<tr>
								<td style="height: 80px;">&nbsp;</td>
								<td style="height: 80px;">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

			<table style="width: 100%;" class="table1a">
				<tr>
					<td style="width: 21%;">&nbsp;</td>
					<td style="width: 12%;"><p>Manning Agent :</p></td>
					<td style="width: 27%;" class="uline"><p><?= ($company_id == 1)? 'FAIR SHIPPING CORPORATION' : 'CORDIAL SHIPPING INC.' ?></p></td>
					<td style="width: 3%;">&nbsp;</td>
					<td style="width: 10%; "><p>Presenter :</p></td>
					<td style="width: 27%;" class="uline"><p>&nbsp;</p></td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
					<td>Date: </td>
					<td class="uline"><p><?php echo date('m/d/y') ?></p></td>
				</tr>
			</table>

			<table style="width: 100%;" class="table1a">
				<tr>
					<td style="width: 7%;"><p>Rank : </p></td>
					<td style="width: 14%;" class="uline"><p><?php echo strtoupper($position) ?></p></td>
					<td style="width: 12%;"><p>Vessel Name :</p></td>
					<td style="width: 27%;" class="uline"><p><?php echo strtoupper($vessel_name) ?></p></td>
					<td style="width: 3%;">&nbsp;</td>
					<td style="width: 10%;"><p>Flag :</p></td>
					<td style="width: 27%;" class="uline"><p><?php echo strtoupper($flag) ?></p></td>
				</tr>
			</table>

			<table style="width: 100%;"  class="table1a">
				<tr>
					<td style="width: 8%;"><p>Name: </p></td>
					<td style="width: 20%;" class="uline"><p><?php echo $lastname ?></p></td>
					<td style="width: 6%;">&nbsp;</td>
					<td style="width: 20%;" class="uline"><p><?php echo $firstname ?></p></td>
					<td style="width: 6%;">&nbsp;</td>
					<td style="width: 20%;" class="uline"><p><?php echo $middlename ?></p></td>
					<td style="width: 18%;">&nbsp;</td>
				</tr>
				<tr>
					<td class="td_label"></td>
					<td class="td_label" style="font-size: 11px; text-align: left;">(Surname)</td>
					<td>&nbsp;</td>
					<td class="td_label" style="font-size: 11px; text-align: left;">(Given Name)</td>
					<td>&nbsp;</td>
					<td class="td_label" style="font-size: 11px; text-align: left;">(Middle Name)</td>
					<td>&nbsp;</td>
				</tr>
			</table>

			<table style="width: 100%;" class="table1a">
				<tr>
					<td style="width: 8%;"><p>Address: </p></td>
					<td style="width: 55%;" class="uline"><p style="font-size: 9px;"><?php echo $pres_address ?></p></td>
					<td style="width: 10%; text-align: center;"><p>Tel No.:</p></td>
					<td style="width: 27%;" class="uline"><p><?php echo $pres_tel ?></p></td>
				</tr>
			</table>

			<table style="width: 100%;" class="table1a">
				<tr>
					<td style="width: 11%;"><p>Date of Birth :</p></td>
					<td style="width: 12%;" class="uline"><p><?php echo date('m/d/Y', strtotime($birthdate)); ?></p></td>
					<td style="width: 5%; "><p>Age :</p></td>
					<td style="width: 5%;" class="uline"><p><?php echo get_age(date('Y-m-d', strtotime($birthdate))); ?></p></td>
					<td style="width: 10%;"><p>Birth Place :</p></td>
					<td style="width: 20%;" class="uline"><p style="font-size: 9px;"><?php echo $birthplace ?></p></td>
					<td style="width: 11%; "><p>Nationality :</p></td>
					<td style="width: 26%;" class="uline"><p>FILIPINO</p></td>
				</tr>
			</table>

			<table style="width: 100%;" class="table1a">
				<tr>
					<td style="width: 11%;"><p>Weight (kg) : </p></td>
					<td style="width: 12%;" class="uline"><p><?php echo $weight ?></p></td>
					<td style="width: 6%; "><p>Height :</p></td>
					<td style="width: 7%;" class="uline"><p><?php echo $height ?></p></td>
					<td style="width: 9%; "><p>Eye Color :</p></td>
					<td style="width: 18%;" class="uline"><p>&nbsp;</p></td>
					<td style="width: 9%; "><p>Tint :</p></td>
					<td style="width: 28%;" class="uline"><p>&nbsp;</p></td>
				</tr>
			</table>

			<table style="width: 100%;" class="table1a">
				<tr>
					<td style="width: 13%;"><p>Shoe Size(mm) :</p></td>
					<td style="width: 10%;" class="uline"><p><?php echo $shoe_size ?></p></td>
					<td style="width: 10%;"><p>Clothe Size :</p></td>
					<td style="width: 16%;" class="uline"><p><?php echo $clothe_size ?></p></td>
					<td style="width: 51%;" colspan="4">&nbsp;</td>
				</tr>
			</table>

			<table style="width: 100%;" class="table1a">
				<tr>
					<td style="width: 63%;">Name of Wife(or Nearest Relative) and Address :</td>
					<td style="width: 13%;"><p>What Relation : </p></td>
					<td style="width: 24%;" class="uline"><p><?php echo $benef_relation ?></p></td>
				</tr>
			</table>

			<table style="width: 100%;" class="table1a">
				<tr>
					<td style="width: 8%;"><p>Name : </p></td>
					<td style="width: 23%;" class="uline"><p><?php echo $benef_lname ?></p></td>
					<td style="width: 3%;">&nbsp;</td>
					<td style="width: 23%;" class="uline"><p><?php echo $benef_fname ?></p></td>
					<td style="width: 3%;">&nbsp;</td>
					<td style="width: 23%;" class="uline"><p><?php echo $benef_mname ?></p></td>
					<td style="width: 17%;">&nbsp;</td>
				</tr>
				<tr>
					<td class="td_label"></td>
					<td class="td_label" style="font-size: 11px; text-align: left;">(Surname)</td>
					<td>&nbsp;</td>
					<td class="td_label" style="font-size: 11px; text-align: left;">(Given Name)</td>
					<td>&nbsp;</td>
					<td class="td_label" style="font-size: 11px; text-align: left;">(Middle Name)</td>
					<td>&nbsp;</td>
				</tr>
			</table>

			<table style="width: 100%;" class="table1a">
				<tr>
					<td style="width: 8%;"><p>Address: </p></td>
					<td style="width: 49%;" class="uline"><p style="font-size: 9px;"><?php echo $benef_add ?></p></td>
					<td style="width: 3%;">&nbsp;</td>
					<td style="width: 8%; "><p>Tel No.:</p></td>
					<td style="width: 24%;" class="uline"><p>&nbsp;</p></td>
					<td style="width: 8%;">&nbsp;</td>
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
						<th style="text-align: center; width: 26%;">Year</th>
						<th style="text-align: center; width: 42%;">School</th>
						<th style="text-align: center; width: 32%;">Course Finished</th>
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
						<th style="border: none;" colspan="6">2. LICENSE (Officers)</th>
					</tr>
					<tr>
						<th style="text-align: center; width: 26%;">&nbsp;</th>
						<th style="text-align: center; width: 10%;">Rank</th>
						<th style="text-align: center; width: 20%;">Number</th>
						<th style="text-align: center; width: 12%;">Date Issued</th>
						<th style="text-align: center; width: 12%;">Date of Expiry</th>
						<th style="text-align: center; width: 20%;">Remarks</th>
					</tr>
					<?php 
					$docs_license = objectToArray($docs);
					if($docs_license):
						$docsLicense = array_filter($docs, function($i) {
							return in_array ($i->docs_id , array(7, 14, 9, 15, 97, 16, 10));
						});

						$order = array(7, 14, 9, 15, 97, 16, 10);
						usort($docsLicense, function ($a, $b) use ($order) {
						    $pos_a = array_search($a->docs_id, $order);
						    $pos_b = array_search($b->docs_id, $order);
						    return $pos_a - $pos_b;
						});

						$docs_id = array(7 => 'National COC', 14 => 'Flag Endorse' , 9 => 'National GMDSS', 15 => 'Flag Endorse', 
								97 => 'National SSO', 16 => 'Flag Endorse', 10 => 'US Visa');
							
						foreach ($docsLicense as $value): 	

							$date_iss  	= ($value->date_iss)? $value->date_iss : '';
							$date_end  	= ($value->date_expr)? $value->date_expr : '';
							
							if (array_key_exists($value->docs_id, $docs_id) || $value->hasflag == 1):	
							if($value->docs_id == 152) continue;  
					?>			
						<tr>
							<td><?php echo isset($docs_id[$value->docs_id])? $docs_id[$value->docs_id] : ''; ?></td>
							<td style="padding-left: 5px;"><?= _p($value, 'capacity'); ?></td>
							<td style="padding-left: 5px; <?= (strlen(_p($value, 'docs_nos')) > 15)? 'font-size: 8px;' : '' ?>"><?= (_p($value, 'docs_nos'))? _p($value, 'docs_nos') : ''; ?></td>
							<td style="text-align: center;"><?= _p($value, 'date_issued'); ?></td>
							<td style="text-align: center;"><?= _p($value, 'date_expired'); ?></td>
							<td style="padding-left: 5px; <?= (strlen(_p($value, 'remarks')) > 15)? 'font-size: 8px;' : '' ?>"><?= _p($value, 'remarks'); ?></td>
						</tr>
					
					<?php 
							elseif ($value->classify_id == 106):
							if($value->docs_nos == '' || $value->docs_nos == 0 || $value->docs_nos == false) continue;  
					?>			
						<tr>
							<td class="uline"><?= _p($value, 'document'); ?></td>
							<td style="padding-left: 5px;"><?= _p($value, 'capacity'); ?></td>
							<td style="padding-left: 5px; <?= (strlen(_p($value, 'docs_nos')) > 15)? 'font-size: 8px;' : '' ?>"><?= (_p($value, 'docs_nos'))? _p($value, 'docs_nos') : ''; ?></td>
							<td style="text-align: center;"><?= _p($value, 'date_issued'); ?></td>
							<td style="text-align: center;"><?= _p($value, 'date_expired'); ?></td>
							<td style="padding-left: 5px; <?= (strlen(_p($value, 'remarks')) > 15)? 'font-size: 8px;' : '' ?>"><?= _p($value, 'remarks'); ?></td>
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
						<th style="border: none;" colspan="5">3. Passport and Seaman's Book(S/B)</th>
					</tr>
					<tr>
						<th style="text-align: center; width: 26%;">&nbsp;</th>
						<th style="text-align: center; width: 30%;">Number</th>
						<th style="text-align: center; width: 12%;">Date Issued</th>
						<th style="text-align: center; width: 12%;">Date of Expiry</th>
						<th style="text-align: center; width: 20%;">Remarks</th>
					</tr>
					<?php 
					if($docs_license):
						// $docsPass = array_filter($docs, function($i) {
						// 	return in_array ($i->docs_id , array(3, 1, 14));
						// });

						// $order = array(3, 1, 14);
						// usort($docsPass, function ($a, $b) use ($order) {
						//     $pos_a = array_search($a->docs_id, $order);
						//     $pos_b = array_search($b->docs_id, $order);
						//     return $pos_a - $pos_b;
						// });

						$docs_id = array(3 => "Passport", 1 => "Seamen's Book (National)", 14 => "Seamen's Book ({$flag})");

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
							<td style="text-align: center;"><?php if(is_null($date_iss)){ echo "";}else{if($date_iss == "0000-00-00"){echo "";}else{ echo $date_iss;}} ?>
							<td style="text-align: center;"><?php if(is_null($date_expr)){ echo "";}else{if($date_expr == "0000-00-00"){echo "";}else{ echo $date_expr;}} ?>
							<td style="padding-left: 5px;"><?php echo isset($arr->remarks)? $arr->remarks : ''; ?></td>
						</tr>
						
					<?php 
						unset($arr);
						endforeach;
					endif; 
					?>				
				</table>
			</div>

			<div>
				<table class="table2" cellpadding="0" cellspacing="0">
					<tr>
						<th style="border: none;" colspan="5">4. Certificate (SOLAS/MARPOL/TANKER/Others)</th>
					</tr>
					<tr>
						<th style="text-align: center; width: 36%;">Certificate Name</th>
						<th style="text-align: center; width: 20%;">Number</th>
						<th style="text-align: center; width: 12%;">Date Issued</th>
						<th style="text-align: center; width: 12%;">Date of Expiry</th>
						<th style="text-align: center; width: 20%;">Remarks</th>
					</tr>
					<?php 
					if($docs_license):
						

						$docs_id = array(67 => 'STCW Watch-Keeping', 88 => 'Basic Training (STCW 4 Items)', 89 => 'Medical First Aid',
										90 => 'Medical Care',  92 => 'Proficiency in Survival Craft', 91 => 'Advance Fire Fighting', 
										146 => 'SDSDSAT Awareness', 99 => 'Radar Observer', 100 => 'A.R.P.A.', 105 => 'Bridge Team Management',
										106 => 'Bridge Resource Management', 107 => 'Ship Handling Course', 108 => 'ECDIS Training',  
										86 => "Oil Tanker Course ({$flag})", 87 => "Chemical Tanker Course ({$flag})", 83 => 'Safety Officer',
										159 => 'Chief Cook Certificate (ILO-069)');

						// $docs_id = array(8 => 'TESDA COC / MARINA COP', 252 => 'Japan COP (Ships Health Supervisor)',256 => 'Marina COP ABLE Seafarer for Deck',257 => 'Marina COP ABLE Seafarer for Engine');
						
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
							$arr->document 	= $docs_id[$arr->docs_id];
					?>			
						<tr>
							<td><?php echo isset($arr->document)? $arr->document : ''; ?></td>
							<td style="padding-left: 5px; <?= (strlen(_p($arr, 'docs_nos')) > 15)? 'font-size: 8px;' : '' ?>">
								<?= (_p($arr, 'docs_nos'))? _p($arr, 'docs_nos') : ''; ?>
							</td>
							<td style="text-align: center;"><?php if(is_null($date_iss)){ echo "";}else{if($date_iss == "0000-00-00"){echo "";}else{ echo $date_iss;}} ?>
							<td style="text-align: center;"><?php if(is_null($date_expr)){ echo "";}else{if($date_expr == "0000-00-00"){echo "";}else{ echo $date_expr;}} ?>
							<td style="padding-left: 5px; <?= (strlen(_p($arr, 'remarks')) > 15)? 'font-size: 8px;' : '' ?>"><?php echo isset($arr->remarks)? $arr->remarks : ''; ?></td>
						</tr>
						
					<?php 
						unset($arr);
						endforeach;
					endif; 
					unset($docs_license);
					?>

				</table>
			</div>
		</div>
	</div>
	<div class="head" style="page-break-inside: avoid" >
	  	<table width="100%;">
	  		<tr>
	  			<td style="text-align: right;"><h3 style="margin: 0; text-align: right;">EXCEL MARINE CO., LTD</h3></td>
	  		</tr>
	  	</table>
	</div>

	<div style="page-break-inside: avoidl height: 20px;" >
		<table cellpadding="0" cellspacing="5">
			<tr><td>&nbsp;</td></tr>
		</table>
	</div>


	<div style="page-break-inside: avoid" >
		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<th style="border: none;" colspan="4">5. Physical Inspection</th>
			</tr>
			<tr>
				<th style="text-align: center; width: 56%;">&nbsp;</th>
				<th style="text-align: center; width: 12%;">Date Issued</th>
				<th style="text-align: center; width: 12%;">Date of Expiry</th>
				<th style="text-align: center; width: 20%;">Remarks</th>
			</tr>
			<?php 

			if($docs):
				$docsPhysical = array_filter($docs, function($i) {
						return in_array ($i->docs_id , array(140, 144, 142, 143));
					});

				$order = array(140, 144, 142, 143);
				usort($docsPhysical, function ($a, $b) use ($order) {
				    $pos_a = array_search($a->docs_id, $order);
				    $pos_b = array_search($b->docs_id, $order);
				    return $pos_a - $pos_b;
				});

				$docs_id = array(140 => 'Medical Examination', 144 => 'Yellow Fever', 142 => 'Drugs and Alcohols', 143 => 'AIDS Test Result');
				foreach ($docsPhysical as $value): 
					
					$date_iss  	= ($value->date_issued)? $value->date_issued : '';
					$date_expr  = ($value->date_expired)? $value->date_expired : '';
					if (array_key_exists($value->docs_id, $docs_id)):		

						//if($value->docs_nos == '0') continue;					  
			?>			
				<tr>
					<td><?php echo isset($docs_id[$value->docs_id])? $docs_id[$value->docs_id] : ''; ?></td>
					<td style="text-align: center;"><?php if(is_null($date_iss)){ echo "";}else{if($date_iss == "0000-00-00"){echo "";}else{ echo $date_iss;}} ?></td>
					<td style="text-align: center;"><?php if(is_null($date_expr)){ echo "";}else{if($date_expr == "0000-00-00"){echo "";}else{ echo $date_expr;}} ?></td>
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
				<th style="border: none;" colspan="7">6. On-board Service History (Last Five(5) Years)</th>
			</tr>
			<tr>
				<th style="text-align: center; width: 20%;">Vessel's Name</th>
				<th style="text-align: center; width: 8%;">Type</th>
				<th style="text-align: center; width: 17%;">Gross Tonnage</th>
				<th style="text-align: center; width: 17%;" rowspan="2">Manning Company</th>
				<th style="text-align: center; width: 12%;">Sign On</th>
				<th style="text-align: center; width: 8%;" rowspan="2">Period</th>
				<th style="text-align: center; width: 18%;" rowspan="2">Sign-Off Reason</th>
			</tr>
			<tr>
				<th style="text-align: center;">Flag</th>
				<th style="text-align: center;">Rank</th>
				<th style="text-align: center;">Engine Type / HP</th>
				<th style="text-align: center;">Sign Off</th>
			</tr>
			<?php 
			function date_compare($a, $b)
			{
			    $t1 = strtotime($a->embarked);
			    $t2 = strtotime($b->embarked);
			    return $t1 - $t2;
			} 
			usort($work_history, 'date_compare');
			if($work_history):
				$counter = 1;
				foreach ($work_history as $value): 
					$counter++;
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
					
					$date_iss = (!in_array($value->embarked, $date))? date('d-M-Y', strtotime($value->embarked)) : '';
					$date_end = (!in_array($value->disembarked, $date))? date('d-M-Y', strtotime($value->disembarked)) : '';
			?>
			<tr>
				<td style="padding-left: 5px;"><?php echo $value->vessel; ?></td>
				<td style="padding-left: 5px;"><?php echo $value->type; ?></td>
				<td style="padding-left: 5px;"><?php echo $value->grt; ?></td>
				<td style="padding-left: 5px;" rowspan="2"><?php echo $value->company; ?></td>
				<td style="text-align: center;"><?php echo $date_iss; ?></td>
				<td style="text-align: center;" rowspan="2"><?php echo $value->duration; ?></td>
				<td style="padding-left: 5px; font-size: 10px;" rowspan="2"><?php echo $remarks; ?></td>
			</tr>
			<tr>
				<td style="padding-left: 5px;"><?php echo $value->flag; ?></td>
				<td style="padding-left: 5px;"><?php echo $value->rank; ?></td>
				<td style="padding-left: 5px; "><?php echo limit_string($value->engine, 13); ?></td>
				<td style="text-align: center;"><?php echo $date_end; ?></td>
			</tr>
			<?php 
				if($counter > 10) break;
				endforeach; 
			endif;
			?>
		</table>
	</div>

	<div style="page-break-inside: avoid">
		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<th style="border-top: none; border-left: none; border-right: none;" >7. Special Comments</th>
			</tr>
			<tr><td class="tbrd">Health: Experiences: Character: Trading Area: etc.</td></tr>
			<tr><td class="tbrd">&nbsp; </td></tr>
			<?php 
			if($comments):
				foreach ($comments as $value): 
			?>
			<tr><td class="tbrd"><?php echo $value->title; ?> : <?php echo $value->description; ?></td></tr>
			<tr><td class="tbrd">&nbsp; </td></tr>
			<?php endforeach; 
			endif;
			?>
			<tr><td class="tbrd" style="border-bottom-style: solid;">&nbsp; </td></tr>
		</table>
	</div>

	<div style="page-break-inside: avoid">
		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<th style="border-top: none; border-left: none; border-right: none;" colspan="6">8. Personnel Assessment: Interview of Local Representative</th>
			</tr>
			<tr>
				<td class="tbrd" style="width: 30%">Family</td>
				<td style="width: 3%"><?php echo $pa_family ?></td>
				<td class="tbrd" style="width: 30%">Smoking</td>
				<td style="width: 3%"><?php echo $pa_smoking ?></td>
				<td class="tbrd" style="width: 30%">Drinking</td>
				<td style="width: 3%"><?php echo $pa_drinking ?></td>
			</tr>				
			<tr>
				<td class="tbrd" colspan="2">A: Married / B: With Parents / C: Alone</td>
				<td class="tbrd" colspan="2">A: None / B: 1/2 package/day / C: 1 package/day</td>
				<td class="tbrd" colspan="2">A: None / B. 1 can beer/day / C. Heavy</td>
			</tr>
			<tr>
				<td class="tbrd">Any Previous Illness</td>
				<td><?php echo $pa_prev_ill ?></td>
				<td class="tbrd">Job Ability</td>
				<td><?php echo $pa_job_ability ?></td>
				<td class="tbrd">Motivation to be Seaman</td>
				<td><?php echo $pa_motivation ?></td>
			</tr>
			<tr>
				<td class="tbrd" colspan="2">A: None / B: / C: With some remarks</td>
				<td class="tbrd" colspan="2">A: Good / B: Normal / C: Poor</td>
				<td class="tbrd" colspan="2">A: Positive answer / B: Intermediate / C: Money Purpose</td>
			</tr>
			<tr>
				<td class="tbrd" colspan="6">Why he wants to change Company: <?php echo $pa_change ?></td>
			</tr>
			<tr>
				<td class="tbrdb" colspan="6">&nbsp;</td>
			</tr>
		</table>
	</div>
	<?php 
		$image = base_url() . BASE_IMG . 'check_box.jpeg';
		$image = "<img src='{$image}' width='8' style='margin-top: 2px;' />";
	?>
	<div style="page-break-inside: avoid">
		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<th style="border: none;" colspan="6">9. ENGLISH LEVEL</th>
			</tr>
			<tr>
				<td>Read and Write</th>
				<td style="text-align: center; width: 13%; border-right: none; "><?= ($read_write == 1)? $image : ''?> Excellent</td>
				<td style="text-align: center; width: 13%; border-right: none; border-left: none; "><?= ($read_write == 2)? $image : ''?> Good</td>
				<td style="text-align: center; width: 13%; border-right: none; border-left: none; "><?= ($read_write == 3)? $image : ''?> Acceptable</td>
				<td style="text-align: center; width: 13%; border-right: none; border-left: none;  "><?= ($read_write == 4)? $image : ''?> Poor</td>
				<td style="text-align: center; width: 13%; border-left: none;  "><?= ($read_write == 5)? $image : ''?> Unsuitable</td>
			</tr>
			<tr>
				<td>Speak and Listen</th>
				<td style="text-align: center; border-right: none; "><?= ($speak_listen == 1)? $image : ''?> Excellent</td>
				<td style="text-align: center; border-right: none; border-left: none; "><?= ($speak_listen == 2)? $image : ''?> Good</td>
				<td style="text-align: center; border-right: none; border-left: none; "><?= ($speak_listen == 3)? $image : ''?> Acceptable</td>
				<td style="text-align: center; border-right: none; border-left: none; "><?= ($speak_listen == 4)? $image : ''?> Poor</td>
				<td style="text-align: center; border-left: none; "><?= ($speak_listen == 5)? $image : ''?> Unsuitable</td>
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
				<th style="border: none;" colspan="6">10. Evaluation Average Point for last vessel</th>
			</tr>
			<tr>
				<td>Vessel Name</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Average Point</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>
	<br/>
	<p>11.1 Filled out and checked by  ____________________</p>
	<p>11.2 Double Checked by  ____________________</p>
</body>
</html>