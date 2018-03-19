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

		table { margin:auto; margin: 0; padding: 0; font-size: 11px;width: 100%}	
		table td { padding: 2px 0; vertical-align: middle; border: 1px solid #000; }	/*  border: 1px solid #cecece */
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 6px; padding: 0; text-align: center; }
		.alert-expire {color: #ff0500;}
      	.footer { position: fixed; bottom: 0px; text-align: center; font-weight: bold; }
      	.tdheader{border-collapse: collapse; width: 100%;}
      	.tdheader p{ font-weight: bold; font-size: 12px; font-family: tahoma;}
      	.tdheader td{border: none; padding-bottom: 7px;}
      	hr{padding:0px; margin: 0px; height:1px;border:none;color:#333;background-color:#333;}
	</style>
</head>
<body>

		<h4 style="margin-bottom: 15px; text-decoration: underline; text-align: center; font-size: 15px;">CREW LIST</h4>
	</div>
	<div class="body">

 			<?php 
			if($data): 

				$latestjoin = date('m/d/Y',strtotime('01/01/1900'));

				foreach ($data as $value):
					$principal = $value->principal;
					$vessel_flag = $value->vessel_flag;
					
					$origdate = date('m/d/Y', strtotime($value->original_date));	
				
					// $latestjoin = (strtotime($latestjoin) > strtotime($origdate))? $latestjoin : $origdate;	
					

					if((strtotime($latestjoin) > strtotime($origdate))){
						$latestjoin = $latestjoin;
					}
					else
					{
						$latestjoin = $origdate;
						$joining_port = $value->objoin;
					}	

				endforeach;
			endif;
			?>
		<table class="tdheader">
			<tr>
				<td>
					<p class="tlabel">Ship's Name : <?php echo _p($vessel, 'prefix') . ' ' . _p($vessel, 'vessel_name'); ?></p>
				</td>
				<td>

					<p class="tlabel" style="text-align: right;">Date : <?php  echo $latestjoin ?></p>
				</td>
			</tr>
			<tr>
				<td>
					<p class="tlabel">Flag : <?php echo $vessel_flag?></p>
				</td>
				<td>
					<p class="tlabel" style="text-align: right;">Joining Port : <?php echo $joining_port?></p>
				</td>
			</tr>
		</table>

		<table style="width: 100%; margin-bottom: 5px;" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 3%; text-align: center"><p>No:</p></td>
				<td style="width: 6%; text-align: center"><p>Rank</p></td>
				<td style="width: 24%; text-align: center"><p>Name</p></td>
				<td style="width: 10; text-align: center"><p>Birth Date <br> <hr> Age</p></td>
				<td style="width: 9%; text-align: center"><p>S/Book #</p></td>
				<td style="width: 16%; text-align: center"><p>Nationality <br> Prev. Vessel</p></td>
				<td style="width: 29%; border-right:none;"><p style="display: inline-block; width: 70px; margin-left: 3px;">Joining Date</p><p style="display: inline-block; text-align:left; margin-left: 30px;">Place</p></td>
				<td style="width: 5%; text-align: center"><p>MONS.<br>O/Brd</p></td>
				
			</tr>
			<?php 
			if($data): 
				$counter = 0;
				foreach ($data as $value):
					$counter++;
				$status_id = $value->status_id;
			    $age = date_diff(date_create($value->birthdate), date_create('now'))->y;

			    $last_vessel = $value->last_vessel;
			    if($value->historycount <= 1){
			    	$last_vessel = 'NEW CREW';
			    }

			?>
				<tr>

					<td style="text-align: center"><p><?php echo $counter; ?></p></td>
					<td style="text-align: center"><p><?php echo $value->code; ?></p></td>
					<td style="padding: 0 3px;"><p style="font-size: 10px;"><?php echo $value->fullname; ?></p></td>
					<td style="text-align: center; padding:2px;"><p><?php echo date('m/d/Y', strtotime($value->birthdate)) . '<br>' . $age . ' y'; ?></p></td>
					<td style="text-align: center"><p <?php echo (getRemainingDays($value->seaman_expiry) <= 90)? 'class="alert-expire"' : ''?>><?php echo $value->seaman_nos; ?></p></td>
					<td style="text-align: center;"><p style="font-size: 10px;"><?php echo '<span style="font-size:12px;">Filipino</span><br>' . $last_vessel ?></p></td>
					<td style="border-right:none; padding-left: 2px;"><p style="display: inline-block; width: 70px; margin-left: 3px;"><?php echo date('m/d/Y', strtotime($value->original_date)) ?></p><p style="display: inline-block; font-size: 9px;"><?php echo $value->objoin?></p> <br> <p style="text-align: center; font-size: 9px; font-weight: bold;"><?php echo $value->endorsement?></p></td>
					<?php
						$num = intval($value->duration);
					?>
					<td style="text-align: center"><p><?php echo $num;?></p></td>

					

					
				</tr>
			<?php
				endforeach;
			endif;
			?>
		</table>
		<h5 style="margin: 15px 0; text-align: right; margin-right: 20px; ">As of <?php echo date('Y/m/d', strtotime($dateto)) ; ?></h5>
<!-- 		<h1 style="text-align: center; font-size:20px;">Santoku Senpaku Co.,Ltd.</h1> -->

    	<div class="footer"><span class="pagenum"><?= _p($vessel, 'control_nos') ?></span></div>
	</div>
</body>
</html>