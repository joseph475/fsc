<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Crew Contract Review and Replacement Plan</title>
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body {
			font: normal 12px arial, sans-serif; 
		}
		p { margin: 0; }

		@page { margin: 0.5in 0.5in;} 

		.header { text-align: center; margin-bottom: 15px; }
		.header h4, .header h3 { margin: 0; }
		.header h3 { padding: 5px 0; }
		.header p { margin: 5px 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.gen_info h4 { text-decoration: underline; }
		.square { border: 1px solid #000; width: 12px; height: 12px; }

		table { margin: 0 0 15px 0; padding: 0; font-size: 11px; width: 100%; }	
		table td, table th { padding: 1px 0; vertical-align: middle; } /*  border: 1px solid #cecece }*/
		table th { font-weight: bold; text-align: left; }
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 11px; padding: 0; text-align: center; font-weight: bold; }

		.table0 { margin: 20px auto 0 auto; width: 45%; font-size: 9px; }

		.table1 { margin-bottom: 25px; font-size: 10px; }
		.table1 thead { border-top: 1px solid #000; border-bottom: 1px solid #000;  }
		.table1 thead td, .table1 thead th { text-align: center; padding: 5px 0; }
		.table1 thead th { font-style: italic; border-top: thin solid #000; }
		.table1 tbody td { text-align: center; font-size: 9px; padding: 2px 0; border-bottom: thin dotted #000;  }
	</style>
</head>
<body>
	<p style="font-size: 9px;"><?php echo select_iso(11); ?></p>
	<div class="header">
		<h4>FAIR SHIPPING CORPORATION</h4>
		<h3>CREW CONTRACT REVIEW AND REPLACEMENT PLAN</h3>
		<table class="table0">
			<tr>
				<td style="width: 55%;">DATE OF REVIEW:</td>
				<td><?php echo date('F d, Y'); ?></td>
			</tr>
			<tr>
				<td>PRESIDED BY ENGR E. C. BARONDA</td>
				<td class="uline">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">CONFIRM TO SELECT/HIRE CREW</td>
			</tr>
		</table>

		<table style="margin: 0 auto 25px auto; width: 75%;">
			<tr>
				<td style="width: 20%">C/E R.G ROBLES</td>
				<td style="width: 25%" class="uline">&nbsp;</td>
				<td style="width: 10%"></td>
				<td style="width: 20%">CHECKED BY</td>
				<td style="width: 25%" class="uline">&nbsp;</td>
			</tr>
			<tr>
				<td>MR. D.V. DINO</td>
				<td class="uline">&nbsp;</td>
				<td></td>
				<td>MR. J.M. BONDOC</td>
				<td class="uline">&nbsp;</td>
			</tr>
		</table>
	</div>
	<div class="body">
		<table class="table1" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<td colspan="6">CREW REPLACEMENT PLAN AS OF NOVEMBER 26, 2012</td>
				</tr>
				<tr>
					<th style="width: 5%;">DATE</th>
					<th style="width: 26%;">VESSEL</th>
					<th style="width: 22%;">DISEMBARK</th>
					<th style="width: 22%;">EMBARK</th>
					<th style="width: 13%;">PORT</th>
					<th style="width: 12%;">VISA</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if($data){
						foreach ($data as $value) {
							echo "<tr>";
							echo "<td>{$value->jdate}</td>";
							echo "<td>{$value->vessel_name}</td>";
							echo "<td>{$value->disembark}</td>";
							echo "<td>{$value->embark}</td>";
							echo "<td>{$value->joining_port}</td>";
							echo "<td>{$value->visa}</td>";
							echo "</tr>";
						}

					} 
				?>
			</tbody>
		</table>
	</div>
</body>
</html>
