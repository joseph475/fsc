
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Standard History Card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body {
			font: normal 12px "Times New Roman",Georgia,Serif; 
			text-transform: uppercase;
		}
		p { margin: 0;  }

		@page { margin: 0.2in 0.5in 0.2in 0.5in;}

		.clearfix { clear: both; }

		.header { text-align: center; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		h4 { text-decoration: underline; margin: 15px 0; }

		table { margin: 0; padding: 0; width: 100%; font-size: 9px; }
		table p { font-size: 10px; }	
		table th { font-weight: bold; text-align: center; text-decoration: underline; }
		table td { padding: 2px 0; vertical-align: middle;  }	
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 6px; padding: 0; text-align: center; }
		.pic { border: 1px solid #000; width: 1in; height: 1in; }
		.alert-expire {
		  	color: #ff0500;
		}

	</style>
	<?php $date = array("0000-00-00", "1970-01-01", "1969-12-31"); ?>
</head>
<body>

	<?php if($company_id == 1): ?>
	<div style="font-size: 10px; ">
		<span style="border: 1px solid #000; padding: 2px; ">FSC-OP-003</span> REV.03
	</div>
	<div class="header">
		<img src="<?php echo base_url() .  BASE_IMG . 'fsc.jpg'; ?>" width="500" />
	</div>
	<?php else: ?>
	<div class="header"><h1>CORDIAL SHIPPING INC.</h1></div>
	<?php endif;?>

	<div class="gen_info">
		<table>
			<tr>
				<td style="width: 10%">VESSEL:</td>
				<td style="width: 40%; text-align: center;"><p style="border: 1px solid #000; padding: 3px 0; font-weight: bold; "><?php echo $vessel_name ?></p></td>
				<td style="width: 30%">&nbsp;</td>
				<td style="width: 20%; text-align: center;">
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

		<h4>PERSONAL HISTORY CARD</h4>

		<table>
			<tr>
				<td style="width: 10%;"><p>FULLNAME:</p></td>
				<td style="width: 50%;" class="uline"><p><?php echo $fullname ?></p></td>
				<td style="width: 10%; text-align: center"><p>POSITION:</p></td>
				<td style="width: 30%; text-align: center;" class="uline" colspan="3"><p><?php echo $position ?></p></td>
			</tr>
			<tr>
				<td><p>BIRTHPLACE</p></td>
				<td class="uline"><p><?php echo $birthplace ?></p></td>
				<td style="text-align: center"><p>D.O.B:</p></td>
				<td class="uline" style="width: 18%; text-align: center;"><p>
					<?php echo date('F d, Y', strtotime($birthdate)); ?></p>
				</td>
				<td style="text-align: center; width: 3%;"><p>Age:</p></td>
				<td class="uline" style="width: 9%; text-align: center;">
					<p>
						<?php echo isset($birthdate)? get_age(date('Y-m-d', strtotime($birthdate))) . ' y/o' : '' ?>
					</p>
				</td>
			</tr>
		</table>

		<table>
			<tr>
				<td style="width: 17%;"><p>PRESENT ADDRESS:</p></td>
				<td style="width: 55%;" class="uline"><p><?php echo $pres_address ?></p></td>
				<td style="width: 8%; text-align: center"><p>TEL NO:</p></td>
				<td style="width: 20%; text-align: center" class="uline"><p><?php echo $pres_tel ?></p></td>
			</tr>
			<tr>
				<td><p>PROVINCIAL ADDRESS:</p></td>
				<td class="uline"><p><?php echo $prov_address ?></p></td>
				<td style="text-align: center"><p>TEL NO:</p></td>
				<td class="uline" style="text-align: center"><p><?php echo $prov_tel ?></p></td>
			</tr>
		</table>

		<table style="margin-bottom: 15px;">
			<tr>
				<td style="width: 11%;"><p>CIVIL STATUS:</p></td>
				<td style="width: 14%; text-align: center;" class="uline"><p><?php echo $civil_status ?></p></td>
				<td style="width: 8%; text-align: center"><p>HEIGHT:</p></td>
				<td style="width: 13%; text-align: center" class="uline"><p><?php echo $height ?></p></td>
				<td style="width: 8%; text-align: center"><p>WEIGHT:</p></td>
				<td style="width: 13%; text-align: center" class="uline"><p><?php echo $weight ?></p></td>
				<td style="width: 8%; text-align: center"><p>RELIGION:</p></td>
				<td style="width: 25%; text-align: center" class="uline"><p><?php echo $religion ?></p></td>
			</tr>
		</table>

		<h4>EDUCATIONAL ATTAINMENT</h4>

		<table style="margin-bottom: 15px;">
			<tr>
				<th style="width: 45%;"><p>SCHOOL</p></th>
				<th style="width: 30%;"><p>COURSE FINISHED</p></th>
				<th style="width: 25%;"><p>ATTENDED</p></th>
			</tr>
			<?php 
			if($education):
				foreach ($education as $value): 
			?>
			<tr>
				<td class="uline"><p><?php echo $value->school; ?></p></td>
				<td style="text-align: center;" class="uline"><p><?php echo $value->course; ?></p></td>
				<td style="text-align: center;" class="uline"><p><?php echo $value->year; ?></p></td>
			</tr>
			<?php 
				endforeach;
			endif; 
			?>
		</table>

		<h4>LICENSE/CERTIFICATE</h4>

		<table style="margin-bottom: 15px;">
			<tr>
				<th style="width: 31%;"></th>
				<th style="width: 15%;">RANK</th>
				<th style="width: 20%;">DOCUMENT NO.</th>
				<th style="width: 17%;">DATE ISSUED</th>
				<th style="width: 17%;">EXPIRY DATE</th>
			</tr>
			<?php 
			if($docs):

				if($flag == "Japan"){
					if($division =="Officers"){
						$docs_id = array(1, 4, 3, 7,10,250);
					}
					else{
						$docs_id = array(1, 4, 3, 8,10,249);
					}
				}
				else if($flag == "Panama"){
					if($division =="Officers"){
						$docs_id = array(1, 4, 3, 7,10,14);
					}
					else{
						$docs_id = array(1, 4, 3, 8,10,13);			
			  	 	}

				}
				else if($flag == "Singapore"){
					if($division =="Officers"){
						$docs_id = array(1, 4, 3, 7,10,18);
					}
					else{
						$docs_id = array(1, 4, 3, 8,10,17);			
			  	 	}

				}
				else if($flag == "Bahama"){
					if($division =="Officers"){
						$docs_id = array(1, 4, 3, 7,10,22);
					}
					else{
						$docs_id = array(1, 4, 3, 8,10,21);			
			  	 	}

				}
				else if($flag == "Marshall Island"){
					if($division =="Officers"){
						$docs_id = array(1, 4, 3, 7,10,26);
					}
					else{
						$docs_id = array(1, 4, 3, 8,10,25);			
			  	 	}

				}

				else if($flag == "Liberia"){
					if($division =="Officers"){
						$docs_id = array(1, 4, 3, 7,10,30);
					}
					else{
						$docs_id = array(1, 4, 3, 8,10,29);			
			  	 	}

				}
				else if($flag == "Cyprus"){
					if($division =="Officers"){
						$docs_id = array(1, 4, 3, 7,10,34);
					}
					else{
						$docs_id = array(1, 4, 3, 8,10,33);			
			  	 	}

				}
				else if($flag == "Hongkong"){
					if($division =="Officers"){
						$docs_id = array(1, 4, 3, 7,10,62);
					}
					else{
						$docs_id = array(1, 4, 3, 8,10,61);			
			  	 	}

				}


				//else{*/
						if($division_id == 2) { //ratings
							$flags = array(13,17,21,25,29,33,61);
						} else {
							$flags = array(14,15,18,19,22,23,26,27,30,31,34,35,62,63);
						}
				
				//}


			
				
				foreach ($docs as $value): 	

					$date_iss = ($value->date_issued)? $value->date_issued : '';
					$date_end = ($value->date_expired)? $value->date_expired : '';
					if (in_array($value->docs_id, $docs_id)):			  
			?>			
				<tr>
					<td class="uline"><?php echo $value->document; ?></td>

					<td style="text-align: center;" class="uline"><?php echo $value->capacity; ?></td>
					<td style="text-align: center;" class="uline"><?php echo $value->docs_nos; ?></td>
					<td style="text-align: center;" class="uline"><?php echo $date_iss; ?></td>
					<td style="text-align: center;" class="uline <?php echo (getRemainingDays($value->date_expired) <= 90)? 'alert-expire' : ''?>"><?php echo $date_end; ?></td>
				</tr>
				
			<?php 
					endif; 
					if (in_array($value->docs_id, $flags)):	
						if($value->flag_id === $flag_id):
			?>			
				<tr>
					<td class="uline"><?php echo $value->document; ?></td>
					<td style="text-align: center;" class="uline"><?php echo $value->capacity; ?></td>
					<td style="text-align: center;" class="uline"><?php echo $value->docs_nos; ?></td>
					<td style="text-align: center;" class="uline"><?php echo $date_iss; ?></td>
					<td style="text-align: center;" class="uline <?php echo (getRemainingDays($value->date_expired) <= 90)? 'alert-expire' : ''?>"><?php echo $date_end; ?></td>
				</tr>				
			<?php 
						endif;
					endif;
				endforeach;
			endif; 
			?>
			
		</table>

		<h4>EMPLOYMENT RECORD</h4>

		<table style="margin-bottom: 15px;">
			<thead>
				<tr>
					<th style="width: 18%;">COMPANY</th>
					<th style="width: 18%;">VESSEL</th>
					<th style="width: 7%;">RANK</th>
					<th style="width: 6%;">GRT</th>
					<th style="width: 11%;">KIND</th>
					<th style="width: 18%;">ENGINE</th>
					<th style="width: 15%;">PERIOD</th>
					<th style="width: 7%; ">CONTRACT DURATION</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if($work_history):
					foreach ($work_history as $value): 
						$end = (!in_array($value->disembarked, $date))? date('m/d/Y', strtotime($value->disembarked)) : 'Present';
				?>
					<tr>
						<td class="uline"><?php echo $value->company; ?></td>
						<td class="uline"><?php echo $value->vessel; ?></td>
						<td style="text-align: center;" class="uline"><?php echo $value->rank; ?></td>
						<td style="text-align: center;" class="uline"><?php echo $value->grt; ?></td>
						<td style="text-align: center;" class="uline"><?php echo $value->type;?></td>
						<td class="uline"><?php echo $value->engine;?></td>
						<td style="text-align: center;" class="uline">
							<?php 
								echo date('m/d/Y', strtotime($value->embarked)) . ' - ' . $end;
							?>
						</td>

						<!--<td style="text-align: right;" class="uline"><?php echo $value->duration; ?></td>-->

						<td style="text-align: right;" class="uline">

						<?php 
							$tempdate = date('m-d-y');
							if($end == "Present"){
								$datetoday = new datetime();
							}
							else{
								$datetoday = strtotime($end);
								$datetoday = date('m/d/y', $datetoday);	
								$datetoday = new datetime($datetoday);
							}
							 $dStart = new DateTime($value->embarked);

							   $dDiff = $dStart->diff($datetoday);
							echo (($dDiff->format('%y') * 12) + $dDiff->format('%m')) . " mos"

						 ?></td>
					</tr>
				<?php 
					endforeach; 
				endif;
				?>
			</tbody>
		</table>

		<table>
			<tr>
				<th style="width: 20%; text-align: left; text-decoration: underline;">SIZE OF SAFETY GEAR:</th>
				<td style="text-align: center; width: 15%;">WORKING CLOTHES</td>
				<td style="text-align: center; width: 15%;" class="uline"><?php echo $clothe_size ?></td>
				<td style="text-align: center; width: 12%;">SAFETY SHOES</td>
				<td style="text-align: center; width: 15%;" class="uline"><?php echo $shoe_size ?></td>
				<td style="width: 23%;">&nbsp;</td>
			</tr>
		</table>
	</div>
</body>
</html>