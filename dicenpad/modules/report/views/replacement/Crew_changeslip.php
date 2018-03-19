<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Schedule Plan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body, * {
			font: normal 10px arial, sans-serif; 
		}
		p { margin: 0; }

		@page { margin: 0.1in 0.6in 0.2in 0.6in;} 

		.header { text-align: center; margin-bottom: 15px; }
		.header h4, .header h2 { margin: 0; }
		.header h2 { text-decoration: underline; font-weight: bold; font-size: 11pt;}

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.gen_info h4 { text-decoration: underline; }
		.square { border: 1px solid #000; width: 12px; height: 12px; }

		table { margin: 0 0 15px 0; padding: 0; width: 100%; }	
		table td, table th { padding: 2px 0; vertical-align: middle; font-size: 9px;} /*  border: 1px solid #cecece }*/
		table th { font-weight: bold; text-align: left; }
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 10px; padding: 0; text-align: center; font-weight: bold; }

		.table1, .table2 { margin-bottom: 8px; }
		.table1 td, .table1 th { border: 1px solid #000;  padding: 2px;  font-size: 9px;}
		.table1 thead td, .table1 thead th, .table2 thead td { text-align: center; }

		.table2 td, .table2 th { padding: 2px; font-size: 9px; }
		.table2 thead td { text-decoration: underline; }
		.alert-expire {
		  	color: #ff0500;
		}

		.font {
			font-size: 19px;
			font-family: Arial, Helvetica, sans-serif;
		}
	</style>
</head>
<body>
	<?php if($company_id == 1): ?>
	<p style="text-align: right; margin: 10px 0;"><?= select_iso(2); ?></p>
	<?php else: ?>
	<p style="text-align: left; margin: 10px 0;"><?= select_iso2(2); ?></p>
	<?php endif;?>
	<div class="header">
		<h2 >SCHEDULE FOR CREW REPLACEMENT</h3>
	</div>
	<div class="body">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 19%;">VESSEL'S NAME:</td>
				<th style="width: 40%;"><?php echo _p($about, 'vessel_name'); ?></th>
				<td style="width: 14%;">REVISED:</td>
				<td style="width: 27%;"><?php echo _p($about, 'revision'); ?></td>
			</tr>
			<tr>
				<td>DATE:</td>
				<td><?php echo ($s_date)? date('F d, Y', strtotime($s_date)) : ''; ?></td>
				<td>REFERENCE #:</td>
				<th><?php echo _p($about, 'control_nos'); ?></th>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>VISA REQ:</td>
				<th><?php echo _p($about, 'visa'); ?></th>
			</tr>
			<tr>
				<td>JOINING DATE:</td>
				<td><?php echo ($j_date)? date('F d, Y', strtotime($j_date)) : ''; ?></td>
				<td>REPAT DATE:</td>
				<td><?php echo ($r_date)? date('F d, Y', strtotime($r_date)) : ''; ?></td>
			</tr>
			<tr>
				<td>AIRPORT:</td>
				<td><?php echo _p($about, 'airport'); ?></td>
				<td>PORT:</td>
				<td><?php echo _p($about, 'joining_port'); ?></td>
			</tr>
			<tr>
				<td>CHARTERE'S AGENT:</td>
				<th><?php echo _p($about, 'charter_agent'); ?></th>
				<td>EMAIL:</td>
				<td><?php echo _p($about, 'charter_agent_email'); ?></td>
			</tr>	
			<tr>
				<td>TEL:</td>
				<td><?php echo _p($about, 'charter_agent_conctact'); ?></td>
				<td>FAX:</td>
				<td><?php echo _p($about, 'charter_agent_fax'); ?></td>
			</tr>	
			<tr>
				<td>HANDLING AGENT:</td>
				<th><?php echo _p($about, 'handling_agent'); ?></th>
				<td>EMAIL:</td>
				<td><?php echo _p($about, 'handling_agent_email'); ?></td>
			</tr>
			<tr>
				<td>TEL:</td>
				<td><?php echo _p($about, 'handling_agent_conctact'); ?></td>
				<td>FAX:</td>
				<td><?php echo _p($about, 'handling_agent_fax'); ?></td>
			</tr>		
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td style="font-size: 9px;" colspan="2">PRINCIPAL'S APPROVAL DATE: <?php echo ($a_date)? date('F d, Y', strtotime($a_date)) : ''; ?></td>
				<td style="font-size: 9px;" colspan="2">PRINCIPAL: <?php echo _p($about, 'principal'); ?></td>
			</tr>	
		</table>

		<table class="table1" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th style="width: 2%;">NBR</th>
					<th style="width: 6%;">RANK</th>
					<th style="width: 28%;">JOINING CREW</th>
					<td style="width: 9%;">MEDICAL Issued</td>
					<td style="width: 9%;">SIRB Expiry</td>
					<td style="width: 9%;">PASSPORT Expiry</td>
					<td style="width: 9%;">COC Expiry</td>
					<td style="width: 9%;">Contract Duration</td>
					<td style="width: 19%;">Remarks</td>
				</tr>
			</thead>
			<tbody>
			<?php 
			if($joining):
				$counter = 0;
				foreach ($joining as $value):
					$counter++;

					$med = ($value->medical_issued != '')? $value->medical_issued : '';
					$pas = ($value->passport_expired != '')? $value->passport_expired : '';
					$sirb = ($value->sirb != '')? $value->sirb : '';
					$coc = ($value->coc_expired != '')? $value->coc_expired : '';
			?>
				<tr>
					<td style="text-align: center; "><?php echo $counter; ?></td>
					<td style="text-align: center;"><?php echo $value->code; ?></td>
					<td><?php echo $value->fullname; ?></td>
					<td style="text-align: center;"><?php echo $med; ?></td>
					<td style="text-align: center;" <?php echo (getRemainingDays($value->sirb) <= 90)? 'class="alert-expire"' : ''?>><?php echo $sirb; ?></td>
					<td style="text-align: center;" <?php echo (getRemainingDays($value->passport_expired) <= 90)? 'class="alert-expire"' : ''?>><?php echo $pas; ?></td>
					<td style="text-align: center;" <?php echo (getRemainingDays($value->coc_expired) <= 90)? 'class="alert-expire"' : ''?>><?php echo $coc; ?></td>
					<td style="text-align: center; "><?php echo $value->duration; ?></td>
					<td><?php echo $value->remarks; ?></td>
				</tr>
			<?php 
				endforeach; 
			else:
				echo "<tr><td colspan='9'>&nbsp;</td></tr>";
			endif;
			?>
			</tbody>
		</table>

		<table class="table2" style="margin-bottom: 5px;">
            <tr>    
                <td style="width: 20%; text-align: right; text-decoration: underline;">On-Signers: </td>
                <td style="width: 10%;"><?php echo _p($about, 'on_signers'); ?></td>
                <td style="width: 10%; text-align: right; text-decoration: underline;">Onboard: </td>
                <td style="width: 10%;"><?php echo isset($j_date)? date('m/d/Y', strtotime($j_date))  : ''; ?></td>
                <td style="width: 15%; text-align: right; text-decoration: underline;">Leave Manila: </td>
                <td style="width: 10%;"><?php echo isset($j_date)? date('m/d/Y', strtotime('-1 day', strtotime($j_date)))  : ''; ?></td>
                <td style="width: 15%; text-align: right; text-decoration: underline;">Airfare (Per Crew): </td>
                <td style="width: 10%;"><?php echo _p($about, 'airfare1'); ?></td>
            </tr>                          
        </table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th style="width: 15%;text-align: center;">Flight Schedule</th>
                    <th style="width: 10%;text-align: center;">Date</th>    
                    <th style="width: 19%;text-align: center;">Flight No.</th>
                    <th style="width: 19%;text-align: center;">Origin/Destination</th>
                    <th style="width: 10%;text-align: center;">Time</th>
                    <th style="width: 27%;text-align: center;">Status</th>
                </tr>
			</thead>
			<tbody>
			<?php 
			if($join_flight):
				$counter = 0;
				foreach ($join_flight as $value):
					$counter++;
			?>
				<tr>
					<td></td>
					<td style="text-align: center;"><?php echo ($value->fd != '')? $value->fd : '&nbsp;'; ?></td>
					<td style="text-align: center;"><?php echo ($value->flight_no != '')? $value->flight_no : '&nbsp;'; ?></td>
					<td style="text-align: center;"><?php echo ($value->orides != '')? $value->orides : '&nbsp;'; ?></td>
					<td style="text-align: center;"><?php echo ($value->flight_time != '')? $value->flight_time : '&nbsp;'; ?></td>
					<td style="text-align: center;"><?php echo ($value->remarks != '')? $value->remarks : '&nbsp;'; ?></td>
				</tr>
			<?php 
				endforeach; 
			endif;
			?>
			<tr>
				<td colspan="5" style="text-align: right; padding-top: 10px;">Airfare</td>
				<td style="padding-top: 10px;"><?php echo _p($about, 'afre1'); ?></td>
			</tr>

			</tbody>
		</table>

		<table class="table1" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th style="width: 2%;">NBR</th>
					<th style="width: 6%;">RANK</th>
					<th style="width: 55%;">REPAT CREW</th>
					<th style="width: 9%;">JOINING DATE</th>
					<th style="width: 9%;">REPAT DATE</th>
					<th style="width: 9%;">Contract Duration</th>
					<th style="width: 19%;">Remarks</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if($repat):
					$counter = 0;
					foreach ($repat as $key => $value):
						$counter++;
				?>
				<tr>
					<td style="text-align: center;"><?php echo $counter; ?></td>
					<td style="text-align: center;"><?php echo $value->code; ?></td>
					<td><?php echo $value->fullname; ?></td>
					<td><?php echo $value->joining_date; ?></td>
					<td><?php echo ($value->disembarked == "00/00/0000")? '' : $value->disembarked; ?></td>
					<td style="text-align: center;"><?php echo $value->duration; ?></td>
					<td><?php echo $value->remarks; ?></td>
				</tr>
				<?php 
					endforeach; 
				else:
					echo "<tr><td colspan='6'>&nbsp;</td></tr>";
				endif;
				?>
			</tbody>
		</table>		

		<table class="table2" style="margin-bottom: 5px;">
            <tr>    
                <td style="width: 20%; text-align: right; text-decoration: underline;">Off-Signers: </td>
                <td style="width: 10%;"><?php echo _p($about, 'off_signers'); ?></td>
                <td style="width: 10%; text-align: right; text-decoration: underline;">Disembarkation: </td>
                <td style="width: 10%;"><?php echo isset($r_date)? date('m/d/Y', strtotime($r_date))  : ''; ?></td>
                <td style="width: 15%; text-align: right; text-decoration: underline;">Arrive Manila: </td>
                <td style="width: 10%;"><?php echo isset($r_date)? date('m/d/Y', strtotime('+1 day', strtotime($r_date)))  : ''; ?></td>
                <td style="width: 15%; text-align: right; text-decoration: underline;">Airfare (Per Crew): </td>
                <td style="width: 10%;"><?php echo _p($about, 'airfare2'); ?></td>
            </tr>                          
        </table>

        <div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th style="width: 15%; text-align: center;">Flight Schedule</th>
	                    <th style="width: 10%; text-align: center;">Date</th>    
	                    <th style="width: 19%; text-align: center;">Flight No.</th>
	                    <th style="width: 19%; text-align: center;">Origin/Destination</th>
	                    <th style="width: 10%; text-align: center;">Time</th>
	                    <th style="width: 27%; text-align: center;">Status</th>
	                </tr>
				</thead>
				<tbody>
				<?php 
				if($repat_flight):
					$counter = 0;
					foreach ($repat_flight as $value):
						$counter++;
				?>
					<tr>
						<td>&nbsp;</td>
						<td style="text-align: center;"><?php echo ($value->fd != '')? $value->fd : '&nbsp;'; ?></td>
						<td style="text-align: center;"><?php echo ($value->flight_no != '')? $value->flight_no : '&nbsp;'; ?></td>
						<td style="text-align: center;"><?php echo ($value->orides != '')? $value->orides : '&nbsp;'; ?></td>
						<td style="text-align: center;"><?php echo ($value->flight_time != '')? $value->flight_time : '&nbsp;'; ?></td>
						<td style="text-align: center;"><?php echo ($value->remarks != '')? $value->remarks : '&nbsp;'; ?></td>
					</tr>
				<?php 
					endforeach; 
				endif;
				?>
				<tr>
					<td colspan="5" style="text-align: right; padding-top: 10px;">Airfare</td>
					<td style="padding-top: 10px;"><?php echo _p($about, 'afre2'); ?></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="table1" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th style="width: 2%;">NBR</th>
						<th style="width: 4%;">PREV RANK</th>
						<th style="width: 4%;">NEW RANK</th>
						<th style="width: 38%;">FOR PROMOTION</th>
						<td style="width: 9%;">SIRB Expiry</td>
						<td style="width: 9%;">PASSPORT Expiry</td>
						<td style="width: 9%;">COC Expiry</td>
						<td style="width: 9%;">Contract Duration</td>
						<td style="width: 16%;">Remarks</td>
					</tr>
				</thead>
				<tbody>
					<?php 
					if($promotion):
						$counter = 0;
						foreach ($promotion as $key => $value):
							$counter++;
							$pas = ($value->passport_expired != '')? date('m/d/Y', strtotime($value->passport_expired)) : '';
							$sirb = ($value->sirb != '')? date('m/d/Y', strtotime($value->sirb)) : '';
							$coc = ($value->coc_expired != '' || $value->coc_expired != '')? date('m/d/Y', strtotime($value->coc_expired)) : '';
					?>
					<tr>
						<td style="text-align: center;"><?php echo $counter; ?></td>
						<td style="text-align: center;"><?php echo $value->old_pos; ?></td>
						<td style="text-align: center;"><?php echo $value->new_pos; ?></td>
						<td><?php echo $value->fullname; ?></td>
						<td style="text-align: center;" <?php echo (getRemainingDays($value->sirb) <= 90)? 'class="alert-expire"' : ''?>><?php echo $sirb; ?></td>
						<td style="text-align: center;" <?php echo (getRemainingDays($value->passport_expired) <= 90)? 'class="alert-expire"' : ''?>><?php echo $pas; ?></td>
						<td style="text-align: center;" <?php echo (getRemainingDays($value->coc_expired) <= 90)? 'class="alert-expire"' : ''?>><?php echo $coc; ?></td>
						<td style="text-align: center;"><?php echo $value->duration; ?></td>
						<td><?php echo $value->remarks; ?></td>
					</tr>
					<?php 
						endforeach; 
					else:
						echo "<tr><td colspan='9'>&nbsp;</td></tr>";
					endif;
					?>
				</tbody>
			</table>

			<p><span style="font-weight: bold;">Remarks: </span> <?php echo _p($about, 'remarks'); ?></p>
		</div>
		
		<div style="page-break-inside: avoid">
			<table cellpadding="0" cellspacing="0" style="margin-top: 10px;">
				<tr>
					<td style="width: 20%;">By: Operation:</td>
					<td style="width: 30%;">&nbsp;</td>
					<td style="width: 20%;">Crewing:</td>
					<td style="width: 30%;">&nbsp;</td>
				</tr>
				<tr>
					<td>Received Date:</td>
					<td colspan="3">&nbsp;</td>
				</tr>
			</table>

			<?php 
				$image = base_url() . BASE_IMG . 'check_box.jpeg';
				$image = "<img src='{$image}' width='8' />";
			?>

			<table cellpadding="0" cellspacing="0" style="margin-top: 10px;">
				<tr>
					<td style="width: 23%;">Approve Crew Replacement: </td>
					<td style="width: 27%;"><?php echo ($is_approve)? $image : '-'; ?></td>
					<td style="width: 20%;">Dept. Head:</td>
					<td style="width: 30%;">&nbsp;</td>
				</tr>
				<tr>
					<td>Advised Agent: </td>
					<td colspan="3"><?php echo ($advised_agent)? $image : '-'; ?></td>
				</tr>
				<tr>
					<td>Final Flight: </td>
					<td colspan="3"><?php echo ($final_flight)? $image : '-'; ?></td>
				</tr>
				<tr>
					<td>Final Dispatch: </td>
					<td colspan="3"><?php echo ($final_dispatch)? $image : '-'; ?> </td>
				</tr>
			</table>


			<table cellpadding="0" cellspacing="0">
				<tr>
					<td style="width: 25%;"><span style="font-size:14px">AIRPORT TERMINAL: </span></td>
					<td><span style="font-size:14px"> <?php echo ($terminal)? $terminal : '-'; ?></span></td>
				</tr>
				<tr>
					<td style="width: 25%;" ><span style="font-size:14px">MEETING TIME: </span></td>
					<td><span style="font-size:14px"> <?php echo ($arrival_time)? $arrival_time : '-'; ?></span></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>
