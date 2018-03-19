<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Crew List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body, * {
			font-size: 11px; 
		}
		p { margin: 0; }

		.header { text-align: center; }
		.header h4, .header h5 { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }

		table { margin: 0; padding: 0; font-size: 11px; }	
		table td { padding: 2px 0; vertical-align: middle; border: 1px solid #000; }	/*  border: 1px solid #cecece */
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 6px; padding: 0; text-align: center; }
		.alert-expire {color: #ff0500;}
      	.footer { position: fixed; bottom: 0px; text-align: center; font-weight: bold; }

	</style>
</head>
<body>
	<p>
	<?php 
		if (_p($vessel, 'company_id') == 1) {
			echo select_iso(18); 
		}
	?>
	</p>
	<div class="header">
		<h4><?= (_p($vessel, 'company_id') == 1)? 'FAIR SHIPPING CORPORATION' : 'CORDIAL SHIPPING INC.'; ?></h4>
		<h5>Manila, Philippines</h5>

		<h5 style="margin: 15px 0; text-align: right; ">As of <?php echo date('F d, Y', strtotime($dateto)) ; ?></h5>
		<h4 style="margin-bottom: 15px; text-decoration: underline;">CREW LIST</h4>
	</div>
	<div class="body">
		<p style="margin-bottom: 10px;">NAME OF VESSEL: <b><?php echo isset($vessel_name)? $vessel_name : ''; ?></b></p>

		<table style="width: 100%; margin-bottom: 5px;" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 3%; text-align: center"><p>No:</p></td>
				<td style="width: 30%; text-align: center"><p>Name</p></td>
				<td style="width: 6%; text-align: center"><p>Rank</p></td>
				<td style="width: 9%; text-align: center"><p>Date of Birth</p></td>
				<td style="width: 9%; text-align: center"><p>Seaman's Book No.</p></td>
				<td style="width: 9%; text-align: center"><p>ONBOARD Date</p></td>
				<td style="width: 9%; text-align: center"><p>Duration</p></td>
				<td style="width: 25%; text-align: center"><p>Remarks</p></td>
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
					<td style="text-align: center"><p><?php echo date('m/d/Y', strtotime($value->birthdate)); ?></p></td>
					<td style="text-align: center"><p <?php echo (getRemainingDays($value->seaman_expiry) <= 90)? 'class="alert-expire"' : ''?>><?php echo $value->seaman_nos; ?></p></td>
					<td style="text-align: center"><p><?php echo date('m/d/Y', strtotime($value->embarked)); ?></p></td>
					<td style="text-align: center"><p><?php echo $value->duration; ?></p></td>
					<td style="padding: 0 3px;"><p><?php echo $value->endorsement; ?></p></td>
				</tr>
			<?php
				endforeach;
			endif;
			?>
		</table>
		<p><strong>Note:</strong></p>
    	<div class="footer"><span class="pagenum"><?php echo isset($control_nos)? $control_nos : ''; ?></span></div>
	</div>
</body>
</html>