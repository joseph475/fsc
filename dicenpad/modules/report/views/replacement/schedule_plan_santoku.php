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
			font: normal 11px arial, sans-serif; 
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
	
		table td.td_label { font-size: 10px; padding: 0; text-align: center; font-weight: bold; }

		.table1, .table2 { margin-bottom: 8px; }
		.table1 td, .table1 th { border: 1px solid #000;  padding: 2px;  font-size: 12px;}
		.table1 thead td, .table1 thead th, .table2 thead td { text-align: center; }
		
		.table2{width:90%;margin:auto;}
		.table2 td, .table2 th { padding: 2px; font-size: 11px; }
		.table2 thead td { text-decoration: underline; }
		.alert-expire {
		  	color: #ff0500;
		}

		.font {
			font-size: 19px;
			font-family: Arial, Helvetica, sans-serif;
		}
			.header h1 {font-size :25px; margin-top: 110px;}
		
		table.santokutable{
			width:90%;
			margin:auto;
			padding:0px;
		}
		.middletable{
			width:60%;
			margin:auto;
		}	
		
		.middletable td{
			font-size:12px;
		}
		table.santokutable td{
			width: 33%;
			font-size:11px;
		}
		
		table.santokutable1{
			width:90%;
			margin:auto;
			margin-top:10px;
		}
	</style>
</head>
<body>
	<?php if($principal_id == 39): //searchhere?>
			<div class="header">
				<h1>Vessel Name: <?php echo _p($about, 'vessel_name'); ?></h1>
			</div>
			<table class="santokutable" cellpadding = "0" cellspacing = "0">
				<tr>
					<td>Prev. Port: </td>
					<td>Port of: <?php echo _p($about, 'joining_port'); ?></td>
					<td>Next Port:</td>
				<tr>
			</table>
			
			<hr style="width:90%; margin:auto; padding:0px;">
			
			<table class="santokutable" cellpadding = "0" cellspacing = "0" style="margin-bottom:7px;">
				<tr>
					<td>ETD </td>
					<td>ETA/D</td>
					<td>ETA</td>
				<tr>
			</table>
			
			<table class="middletable" style="border-bottom:2px solid black;"cellpadding = "0" cellspacing = "0">
				<tr>
					<td style="width:25%">Charterer's Agent: </td>
					<td style="width:75%"><p style="text-decoration:underline;"><?php echo _p($about, 'charter_agent'); ?></p></td>
				<tr>
			</table>
			
			<table class="santokutable" cellpadding = "0" cellspacing = "0">
				<tr>
					<td>TEL: <?php echo _p($about, 'charter_agent_conctact'); ?></td>
					<td>FAX: <?php echo _p($about, 'charter_agent_fax'); ?></td>
					<td>EMAIL: <?php echo _p($about, 'charter_agent_email'); ?></td>
				<tr>
			</table>
			
			<hr style="width:90%; margin:auto; padding:0px; margin-bottom:7px;">
			
			
			<table class="middletable" style="border-bottom:2px solid black;"cellpadding = "0" cellspacing = "0">
				<tr>
					<td style="width:25%">Handilng Agent: </td>
					<td style="width:75%"><p style="text-decoration:underline;"><?php echo _p($about, 'handling_agent'); ?></p></td>
				<tr>
			</table>
			
			
			<table class="santokutable" cellpadding = "0" cellspacing = "0">
				<tr>
					<td>TEL: <?php echo _p($about, 'handling_agent_email'); ?></td>
					<td>FAX: <?php echo _p($about, 'handling_agent_conctact'); ?></td>
					<td>EMAIL: <?php echo _p($about, 'handling_agent_fax'); ?></td>
				<tr>
			</table>
			
			<hr style="width:90%; margin:auto; padding:0px;">
			
			<table class="santokutable" cellpadding = "0" cellspacing = "0" style="margin-bottom:5px;">
				<tr>
					<td></td>
					<td></td>
					<td>PIC:</td>
				<tr>
			</table>
			
			<table class="table2" style="margin-bottom: 5px; font-size:12px;">
            <tr>    
                <td style="width: 20%; text-align: right; text-decoration: underline;">On-Signers: </td>
                <td style="width: 10%;"><?php echo _p($about, 'on_signers'); ?></td>
                <td style="width: 10%; text-align: right; text-decoration: underline;">Onboard: </td>
                <td style="width: 10%;  background-color:#FFFF99; border:2px solid black;"><?php echo isset($j_date)? date('m/d/Y', strtotime($j_date))  : ''; ?></td>
                <td style="width: 15%; text-align: right; text-decoration: underline;">Leave Manila: </td>
                <td style="width: 10%;  background-color:#FFFF99; border:2px solid black;"><?php echo isset($j_date)? date('m/d/Y', strtotime('-1 day', strtotime($j_date)))  : ''; ?></td>
            </tr>                          
			</table>
		
			<table class="santokutable1" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th style="text-align: center; width: 5%;">Nbs</th>
					<th style="text-align: center; width: 8%;">RANK</th>
					<th style="text-align: center; width: 25%;">NAME</th>
					<th style="text-align: center; width: 10%;">S/BOOK</th>
					<th style="text-align: center; width: 13%;">B/DATE</th>
					<th style="text-align: center; width: 13%;">PASS PORT</th>
					<th style="text-align: center; width: 15%;">Prev. Vsl</th>
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
					<td style="text-align: center;"> <?php echo $value->sirbno ?></td>
					<td style="text-align: center;"><?php echo $value->birthdate; ?></td>
					<td style="text-align: center;"> <?php echo $value->passport ?></td>
					<td style="text-align: center;"><?php echo $value->remarks; ?></td>
				</tr>
			<?php 
				endforeach; 
			else:
				echo "<tr><td colspan='9'>&nbsp;</td></tr>";
			endif;
			?>
			</tbody>
		</table>
		<br>
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
					<td style="text-align: center;  background-color:#FFFF99;"><?php echo ($value->fd != '')? $value->fd : '&nbsp;'; ?></td>
					<td style="text-align: center;  background-color:#FFFF99;"><?php echo ($value->flight_no != '')? $value->flight_no : '&nbsp;'; ?></td>
					<td style="text-align: center;  background-color:#FFFF99;"><?php echo ($value->orides != '')? $value->orides : '&nbsp;'; ?></td>
					<td style="text-align: center;  background-color:#FFFF99;"><?php echo ($value->flight_time != '')? $value->flight_time : '&nbsp;'; ?></td>
					<td style="text-align: center;  background-color:#FFFF99;"><?php echo ($value->remarks != '')? $value->remarks : '&nbsp;'; ?></td>
				</tr>
			<?php 
				endforeach; 
			endif;
			?>
			<tr>
				<td colspan="5" style="text-align: right; padding-top: 10px;">Airfare</td>
				<td style="padding-top: 10px; color:blue;"><?php echo _p($about, 'afre1'); ?></td>
			</tr>

			</tbody>
		</table>
		
		<table class="table2" style="margin-bottom: 5px;">
            <tr>    
                <td style="width: 20%; text-align: right; text-decoration: underline;">Off-Signers: </td>
                <td style="width: 10%;"><?php echo _p($about, 'off_signers'); ?></td>
                <td style="width: 10%; text-align: right; text-decoration: underline;">Disembarkation: </td>
                <td style="width: 10%;  background-color:#FFFF99; border:2px solid black;"><?php echo isset($r_date)? date('m/d/Y', strtotime($r_date))  : ''; ?></td>
                <td style="width: 15%; text-align: right; text-decoration: underline;">Arrive Manila: </td>
                <td style="width: 10%;  background-color:#FFFF99; border:2px solid black;"><?php echo isset($r_date)? date('m/d/Y', strtotime('+1 day', strtotime($r_date)))  : ''; ?></td>
            </tr>                          
        </table>
		
		<table class="santokutable1" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th style="text-align: center; width: 5%;">Nbs</th>
					<th style="text-align: center; width: 8%;">RANK</th>
					<th style="text-align: center; width: 25%;">NAME</th>
					<th style="text-align: center; width: 10%;">S/BOOK</th>
					<th style="text-align: center; width: 13%;">B/DATE</th>
					<th style="text-align: center; width: 13%;">PASS PORT</th>
					<th style="text-align: center; width: 15%;">Prev. Vsl</th>
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
					<td style="text-align: center;"><?php echo $value->sirbno; ?></td>
					<td style="text-align: center;"><?php echo $value->birthdate; ?></td>
					<td style="text-align: center;"><?php echo $value->passport; ?></td>
					<td style="text-align: center;"><?php echo $value->remarks; ?></td>
				</tr>
				<?php 
					endforeach; 
				else:
					echo "<tr><td colspan='6'>&nbsp;</td></tr>";
				endif;
				?>
			</tbody>
		</table>		


        <div style="page-break-inside: avoid">
			<table class="table2" cellpadding="0" cellspacing="0" style="margin-top:10px;">
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
						<td style="text-align: center;  background-color:#FFFF99;"><?php echo ($value->fd != '')? $value->fd : '&nbsp;'; ?></td>
						<td style="text-align: center;  background-color:#FFFF99;"><?php echo ($value->flight_no != '')? $value->flight_no : '&nbsp;'; ?></td>
						<td style="text-align: center;  background-color:#FFFF99;"><?php echo ($value->orides != '')? $value->orides : '&nbsp;'; ?></td>
						<td style="text-align: center;  background-color:#FFFF99;"><?php echo ($value->flight_time != '')? $value->flight_time : '&nbsp;'; ?></td>
						<td style="text-align: center;  background-color:#FFFF99;"><?php echo ($value->remarks != '')? $value->remarks : '&nbsp;'; ?></td>
					</tr>
				<?php 
					endforeach; 
				endif;
				?>
				<tr>
					<td colspan="5" style="text-align: right; padding-top: 10px;">Airfare</td>
					<td style="padding-top: 10px;  color:blue;"><?php echo _p($about, 'afre2'); ?></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div style="page-break-inside: avoid">
			<table class="santokutable1" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						
						<th style="width: 38%; font-size:11px;">FOR PROMOTION</th>
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
						<td><?php echo $value->fullname. " " . $value->remarks;; ?></td>
					</tr>
					<?php 
						endforeach; 
					else:
						echo "<tr><td colspan='9'>&nbsp;</td></tr>";
					endif;
					?>
				</tbody>
			</table>

		</div>
		
		<div style="page-break-inside: avoid">
			<table class="santokutable1" cellpadding="0" cellspacing="0">
				
					<tr>
						<th style="width: 38%; font-size:12px;">Confirmation</th>
					</tr>
			</table>
			
			<table style="width:90%; margin:auto;" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="border:2px solid black; text-align:center; font-size:11px;">Processed</td>
						<td style="border:2px solid black; text-align:center; font-size:11px;">Log entered</td>
						<td style="border:2px solid black; text-align:center; font-size:11px;">Japanese</td>
						<td style="border:2px solid black; text-align:center; font-size:11px;">Seaman's card</td>
						<td style="border:2px solid black; text-align:center; font-size:11px;">Crew list</td>
						<td style="border:2px solid black; text-align:center; font-size:11px;">Report to owner</td>
					</tr>
					<tr>
						<td style="border:2px solid black; text-align:center; font-size:11px;">Signature</td>
						<td style="border:2px solid black; text-align:center; font-size:11px;"></td>
						<td style="border:2px solid black; text-align:center; font-size:11px;"></td>
						<td style="border:2px solid black; text-align:center; font-size:11px;"></td>
						<td style="border:2px solid black; text-align:center; font-size:11px;"></td>
						<td style="border:2px solid black; text-align:center; font-size:11px;"></td>
					</tr>
				</tbody>
			</table>

		</div>
		<div style="page-break-inside: avoid; margin-top:15px;">
			
			<table style="width:90%; margin:auto;" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="width:17%"></td>
						<td style="border:2px solid black; text-align:center; font-size:11px; width:20%">Confidential Report</td>
						<td style="border:2px solid black; text-align:center; font-size:9px; width:20%">Evaluation of Capt. & C/E</td>
						<td style="width:20%"></td>
						<td style="width:25%"></td>
					</tr>
					<tr>
						<td style=""></td>
						<td style="border:2px solid black; text-align:center; font-size:11px; height:12px;"></td>
						<td style="border:2px solid black; text-align:center; font-size:11px;"></td>
						<td style=""></td>
						<td style=""></td>
					</tr>
				</tbody>
			</table>

		</div>
	<?php endif;?>
</body>
</html>
