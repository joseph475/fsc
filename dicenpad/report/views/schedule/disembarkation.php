<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Disembarkation List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body, * {
			font-size: 12px; 
		}
		p { margin: 0; }

		.header { text-align: center; }
		.header h4, .header h5 { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }

		table { margin: 0; padding: 0 }	
		table td { padding: 2px 0; vertical-align: middle; border: 1px solid #000; }	/*  border: 1px solid #cecece */
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 6px; padding: 0; text-align: center; }
		.alert-expire {
		  	color: #ff0500;
		}
	</style>
</head>
<body>
	<div class="header">
		<h4>FAIR SHIPPING CORPORATION</h4>
		<h5>Manila, Philippines</h5>

		<h5 style="margin: 15px 0; text-align: right; ">As of <?php echo date('M d, Y') ; ?></h5>
		<h4 style="margin-bottom: 15px; text-decoration: underline;">DISEMBARKATION LIST</h4>
	</div>
	<div class="body">
		<p>NAME OF VESSEL: <b><?php echo isset($vessel_name)? $vessel_name : ''; ?></b></p>
		<p style="margin-bottom: 10px;"><b><?php echo isset($filter)? $filter : ''; ?></b></p>

		<table style="width: 100%;" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 3%; text-align: center">&nbsp;</td>
				<td style="width: 27%; text-align: center"><b>Crew Name</b></td>
				<td style="width: 8%; text-align: center"><b>Rank</b></td>
				<td style="width: 10%; text-align: center"><b>Department</b></td>
				<td style="width: 10%; text-align: center"><b>Seaman\'s No</b></td>
				<td style="width: 8%; text-align: center"><b>Onboard Date</b></td>
				<td style="width: 8%; text-align: center"><b>Disembark Date</b></td>
				<td style="width: 8%; text-align: center"><b>Duration</b></td>
				<td style="width: 18%; text-align: center"><b>Remarks</b></td>
			</tr>
			<?php 
			if($data): 
				$counter = 0;
				foreach ($data as $value):
					$counter++;
			?>
				<tr>
					<td style="text-align: center"><p><?php echo $counter; ?></p></td>
					<td style="padding: 0 3px;"><p><?php echo $value->fullname; ?></p></td>
					<td style="text-align: center"><p><?php echo $value->code; ?></p></td>
					<td style="text-align: center"><p><?php echo $value->department; ?></p></td>
					<td style="text-align: center"><p <?php echo (getRemainingDays($value->seaman_expiry) <= 90)? 'class="alert-expire"' : ''?>><?php echo $value->seaman_nos; ?></p></td>
					<td style="text-align: center"><p><?php echo date('m/d/Y', strtotime($value->embarked)); ?></p></td>
					<td style="text-align: center"><p><?php echo date('m/d/Y', strtotime($value->disembarked)); ?></p></td>
					<td style="text-align: center"><p><?php echo $value->duration; ?></p></td>
					<td style="padding: 0 3px;"><p><?php echo $value->manager_comment; ?></p></td>
				</tr>
			<?php
				endforeach;
			endif;
			?>
		</table>
	</div>
</body>
</html>