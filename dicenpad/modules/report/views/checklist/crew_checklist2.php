<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Checklist List Type</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body{
			font: normal 11px Arial,Georgia,Serif; 
		}

		@page { margin: 0.2in 0.2in 0.2in 0.2in;}

		.header { text-align: center; margin-bottom: 20px; }
		.header h4, .header h5, .header p { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.gen_info h4 { text-decoration: underline; font-size: 18px; }

		table { margin: 0; padding: 0; width: 100%; }	
		table th, table td { border: 1px solid #000; text-align: center;  vertical-align: top; }
		table td p { margin: 0; padding: 0 1px; }
		table td { padding: 1px 0; vertical-align: top;  }	/*  border: 1px solid #cecece */
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 12px; padding: 0; text-align: center; }

		.table2 { margin-bottom: 10px; }
		.table2 td {border: none; text-align: left; }

		.table3 { margin-bottom: 10px; }
		.table3 td {border: none; text-align: left; padding: 0; }

		ol li { padding: 0 0 15px 0; }

		.alert-expire {
		  	color: #ff0500;
		}
      	.footer { position: fixed; bottom: 0px; text-align: center; }
	</style>
</head>
<body>
	<p style="font-size: 10px;"><?php
		if($company_id == 1){
			echo select_iso(17); 
		} ?></p>
	<div class="header">
		<h4>CREW DOCUMENT CHECKLIST</h4>
		<p>(as per STCW 2010)</p>
		<p>Personal joining crew for <?php echo isset($type)? $type : ''; ?> Vessels</p>
	</div>

	<div class="gen_info">

		<table class="table2" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 7%;">Name</td>
				<td style="width: 3%;">:</td>
				<td style="width: 90%;"><?php echo isset($fullname)? $fullname : ''; ?></td>
			</tr>
			<tr>
				<td>Rank</td>
				<td>:</td>
				<td><?php echo isset($rank)? $rank : ''; ?></td>
			</tr>
			<tr>
				<td>Vessel</td>
				<td>:</td>
				<td><?php echo isset($vessel_name)? $vessel_name : ''; ?></td>
			</tr>
			<tr>
				<td>Date</td>
				<td>:</td>
				<td><?php echo date('F d, Y'); ?></td>
			</tr>
		</table>

		<table cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th rowspan="2" colspan="2">Certificate Title</th>
					<td colspan="2">Officers</td>
					<td colspan="3">Ratings</td>
					<td rowspan="2">Issue Date</td>
					<td rowspan="2">Expiry Date</td>
					<td rowspan="2">Certificate No. <br/> Remarks</td>
					<td rowspan="2">Panama <br/> Endo. & others</td>
				</tr>
				<tr>
					<td>Deck</td>
					<td>Eng'r</td>
					<td>Deck</td>
					<td>Eng'r</td>
					<td>Stwd</td>
				</tr>
			</tbody>
			<tbody>
			<?php 
			if($data){
				$counter = 0;
				$sort_order = '';
				foreach ($data as $value){
					$counter++;
					$suborder 	= ($value->sub_order != '')? $value->sub_order . '. ' : '';	
					$date_iss  	= ($value->date_issued)? $value->date_issued : '';
					$date_end  	= ($value->date_expired)? $value->date_expired : '';

					if($sort_order == $value->sort_order){ 
						$sort_order = '';
					} else {
						$sort_order = $value->sort_order . '.';
					}

					echo "<tr>";
					echo "<td style='width: 3%;'>{$sort_order}</td>";
					echo "<td style='width: 36%; text-align: left;'><p>{$suborder}{$value->document}</p></td>";
					echo "<td style='width: 4%;'>{$value->officer_deck}</td>";
					echo "<td style='width: 4%;'>{$value->officer_engr}</td>";
					echo "<td style='width: 4%;'>{$value->rating_deck}</td>";
					echo "<td style='width: 4%;'>{$value->rating_engr}</td>";
					echo "<td style='width: 4%;'>{$value->rating_stwd}</td>";
					echo "<td style='width: 8%;'>{$date_iss}</td>";
					echo "<td style='width: 8%;' " . ((getRemainingDays($value->date_expired) <= 90)? 'class="alert-expire"' : '') . ">{$date_end}</td>";
					echo "<td style='width: 13%; text-align: left; border-right: none;'><p>{$value->docs_nos}</p></td>";
					echo "<td style='width: 12%; text-align: left; border-left: none;'><p>{$value->endorsement}</p></td>";
					echo "</tr>";

					$sort_order = $value->sort_order . '.';
				}
			}
			?>
			</tbody>
		</table>

		<div style="page-break-inside: avoid">
			<table class="table3" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
				<tr>
					<td style="width: 23%;">Prepared By:</td>
					<td style="width: 3%;">&nbsp;</td>
					<td style="width: 23%;">Checked By:</td>
					<td style="width: 3%;">&nbsp;</td>
					<td style="width: 23%;">Received By:</td>
					<td style="width: 25%;" rowspan="4">
						<table cellpadding="0" cellspacing="0" >
							<tr>
								<th rowspan="4" style="vertical-align: middle; border: none;">Legend</th>
								<td style="font-size: 8px;"><?php echo date('m/d/Y h:i:s A'); ?></td>
							</tr>
							<tr>
								<td><b>O</b> - Required</td>
							</tr>
							<tr>
								<td><b>(O)</b> - Optional</td>
							</tr>
							<tr>
								<td><b>Blank</b> - Not Required</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="uline">&nbsp;</td>
					<td>&nbsp;</td>
					<td class="uline">&nbsp;</td>
					<td>&nbsp;</td>
					<td class="uline">&nbsp;</td>
				</tr>
				<tr>
					<td><?php echo isset($signatory->check2)? $signatory->check1 : ''; ?></td>
					<td>&nbsp;</td>
					<td><?php echo isset($signatory->check1)? $signatory->check2 : ''; ?></td>
					<td>&nbsp;</td>
					<td><?php echo isset($fullname)? $fullname : ''; ?></td>
				</tr>
				<tr>
					<td>Documentation Officer</td>
					<td>&nbsp;</td>
					<td>Chief Documentation Officer</td>
					<td>&nbsp;</td>
					<td>Name of Crew</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>