<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Crew Certification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body {
			font: normal 13px "Times New Roman",Georgia,Serif; 
		}
		p { margin: 0;  }

		@page { margin: 0.2in 0.5in 0.2in 0.5in;}

		.clearfix { clear: both; }

		.header { text-align: center; }
		.header p { font-size: 7px; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		h4 { text-decoration: underline; margin: 15px 0; }

		table { margin: 0; padding: 0; width: 100%; font-size: 9px; }
		table p { font-size: 11px; }	
		table th { font-weight: bold; text-align: center; text-decoration: underline; }
		table td { padding: 2px 0; vertical-align: middle;  }	
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 6px; padding: 0; text-align: center; }
		.pic { border: 1px solid #000; width: 1in; height: 1in; }
	</style>
	<?php 
		$date = array("0000-00-00", "1970-01-01", "1969-12-31"); 
		$start_date = (!in_array($start_date, $date))? date('m/d/Y', strtotime($start_date)) : '';
		$end_date = (!in_array($end_date, $date))? date('m/d/Y', strtotime($end_date)) : '';
	?>
</head>
<body>
	<table style="font-size: 10px; margin: 10px 0;">
		<tr>
			<td style="width: 90%">&nbsp;</td>
			<td>
				<p style=" margin-bottom: 0; ">FSC-OP-031</p> 
				<p>No. 12-0307</p>
			</td>
		</tr>
	</table>

	<div class="clear"></div>

	<div class="gen_info">
		<h1 style="text-align: center; margin-bottom: 40px;">CERTIFICATION</h1>
		<p style="text-indent:50px; margin: 0 40px; line-height: 20px;">This is to certify that as per our record on file, Mr. <span style="padding: 0 5px; text-decoration: underline"><?php echo isset($fullname)? $fullname : ''; ?></span> has been employed by this company onboard:</p>
		
		<table style="margin: 25px;">
			<thead>
				<tr>
					<th style="width: 27%; vertical-align: middle; height: 40px">VESSEL</th>
					<th style="width: 9%; vertical-align: middle;">RANK</th>
					<th style="width: 8%; vertical-align: middle;">GRT</th>
					<th style="width: 15%; vertical-align: middle;">VESSEL TYPE</th>
					<th style="width: 15%; vertical-align: middle;">TRADER ROUTE</th>
					<th style="width: 13%; vertical-align: middle;">FROM</th>
					<th style="width: 13%; vertical-align: middle;">TO</th>
				</tr>
			</thead>
			<tbody style="border-top: 3px double #000; border-bottom: 3px double #000;">
				<tr>
					<td style="text-align: center; vertical-align: middle;"><?php echo isset($vessel_name)? $vessel_name : ''; ?></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo isset($code)? $code : ''; ?></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo isset($gross)? $gross : ''; ?></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo isset($vessel_type)? $vessel_type : ''; ?></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo isset($trade)? $trade : ''; ?></td>
					<td style="text-align: center; vertical-align: middle;"><?php echo isset($start_date)? $start_date : ''; ?></td>
					<td style="text-align: center; vertical-align: middle; height: 50px"><?php echo isset($end_date)? $end_date : ''; ?></td>
				</tr>
			</tbody>	
			
		</table>

		<p style="text-indent:50px; margin: 0 40px; line-height: 20px;">This certification is being issued upon the request of above - mentioned seaferar for <?php echo isset($purpose)? $purpose : '________________________'; ?>.</p>

		<table style="margin: 20px auto; width: 80%; ">
			<tr>
				<td style="width: 20%; vertical-align: top; "><p>Issued on this</p></td>
				<td style="width: 30%; vertical-align: top;"><p><?php echo isset($issued)? $issued : ''; ?></p></td>
				<td style="width: 40%;">
					<p style="margin-bottom: 10px;">Manila, Philippines</p>
					<p>CERTIFIED CORRECT:</p>
					<p style="margin-bottom: 40px;">FAIR SHIPPING CORPORATION</p>

					<p style="border-top: 1px solid #000; padding-top: 3px;">Ms/Mr.</p>
					<p style="margin-bottom: 15px;">President</p>

					<p style="font-size: 9px;">Note: Not valid without Company seal</p>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>