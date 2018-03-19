<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Various List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body{
			font: normal 12px arial,sans-serif;
		}
		p { margin: 0;  }

		@page { margin: 0.1in 0.1in 0.2in 0.1in;} 

		.header { text-align: center; }
		.header h4, .header h5 { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }

		table { margin: 0; padding: 0; font-size: 9px; font-family: arial,sans-serif; }	
		table thead { border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 3px 0; }
		table td { padding: 3px 0; vertical-align: middle; }	
		.table0 { font-size: 11px; margin-bottom: 10px; width: 100%; }
		.table0 td { padding: 0; }

		.vlist { width: 100%; }
		.vlist th, .vlist td { font-size: 9px; }

		.alert-expire {
		  	color: #ff0500;
		}
      	.footer { position: fixed; bottom: 8px; text-align: center; font-weight: bold; }
	</style>
</head>
<body>
	<p style="font-size: 10px;">
		<?php 
		if($vessel->company_id == 1){
			echo select_iso(15); 
		} else {
			echo select_iso2(15); 
		}
		?>
	</p>
	<div class="header">
		<h4><?= ($vessel->company_id == 1)? 'FAIR SHIPPING CORPORATION' : 'CORDIAL SHIPPING INC.' ?></h4>
		<h5 style="margin-bottom: 5px;" >Manila, Philippines</h5>

		<h4 style="margin-bottom: 5px; text-decoration: underline;">VARIOUS CERTIFICATE LIST</h4>
	</div>
	<div class="body">
		<table class="table0">
			<tr>
				<td style="width: 10%;">SHIP NAME:</td>
				<td style="width: 15%;"><?php echo $vessel->prefix . ' ' . $vessel->vessel_name; ?></td>
				<td style="width: 75%; text-align: right">As of <?php echo date('M d, Y') ; ?></td>
			</tr>
			<tr>
				<td>FLAG:</td>
				<td><?php echo $vessel->flag; ?></td>
				<td></td>
			</tr>
			<tr>
				<td>TYPE:</td>
				<td><?php echo $vessel->type; ?></td>
				<td></td>
			</tr>
		</table>

		<table class="vlist" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<td style="text-align: center"><p>No</p></td>
					<td style="text-align: center"><p>Rank</p></td>
					<td style="text-align: center"><p>Name</p></td>
					<td style="text-align: center"><p>On-Board/<br/> Date</p></td>
					<td style="text-align: center"><p>Seaman's <br/>Book Nos./<br/> Expiry</p></td>
	                <td style="text-align: center"><p>Passport <br/>Nos./Expiry</p></td>
	                <?php 

	                	$flag_ids = array(159, 130, 117, 15, 183);

						if (in_array($vessel->flag_id, $flag_ids)) {

							if($vessel->flag_id == 15 || $vessel->flag_id == 183) {
								echo "<td style='text-align: center'><p>{$vessel->flag} License Nos./<br/> Expiry</p></td>";
						  	} else {
								echo "<td style='text-align: center'><p>{$vessel->flag} License/<br/> Booklet Nos./<br/> Expiry</p></td>";
						  	}
							echo "<td style='text-align: center'><p>{$vessel->flag} <br/> GMDSS Nos./<br/> Expiry</p></td>";
						}
	                ?>
	                <td style="text-align: center"><p>PRC/TESDA <br/>C.O.C Nos./<br/> Expiry</p></td>
	                <td style="text-align: center"><p>U.S Visa <br/>Expiry</p></td>
	                <td style="text-align: center"><p>Yellow Fever <br/>Expiry</p></td>
	                <td style="text-align: center"><p>Medical <br/>Result Issuance</p></td>
	                <td style="text-align: center"><p>Maritime <br/>Crew <br/>Visa</p></td>

				</tr>
			</thead>
			<tbody>
			<?php 
			if($data): 
				$counter = 0;
				foreach ($data as $value):
					$counter++;		

					$sirb	= ($value->seaman_expiry != '0000-00-00')? $value->seaman_expiry : '';	
					$pass 	= ($value->passport_expiry != '0000-00-00')? $value->passport_expiry : '';
					$book	= ($value->booklet_license_expiry != '0000-00-00')? $value->booklet_license_expiry : '';	
					$gmdss 	= ($value->gmdss_expiry != '0000-00-00')? $value->gmdss_expiry : '';
					$coc 	= ($value->coc_expiry != '0000-00-00')? $value->coc_expiry : '';
					$us 	= ($value->us_expiry != '0000-00-00')? $value->us_expiry : '';
					$yellow = ($value->yellow_expiry != '0000-00-00')? $value->yellow_expiry : '';
					$med 	= ($value->medical_issued != '0000-00-00')? $value->medical_issued : '';
					$mvc 	= ($value->mcv_expiry != '0000-00-00')? $value->mcv_expiry : '';
			?>
				<tr>
					<td style="text-align: center"><p><?= $counter; ?></p></td>
					<td style="text-align: center"><p><?= $value->code; ?></p></td>
					<td style="padding: 0 3px;"><p><?= $value->fullname; ?></p></td>
					<td style="text-align: center"><p><?= $value->onboard_date; ?></p></td>
					<td style="text-align: center"><p><?= ($value->seaman_nos)? $value->seaman_nos : ''; ?></p><p <?php echo (getRemainingDays($value->seaman_expiry) <= 90)? 'class="alert-expire"'  : ''?>><?php echo $sirb; ?></p></td>
					<td style="text-align: center"><p><?= ($value->passport_nos)? $value->passport_nos : ''; ?></p><p <?php echo (getRemainingDays($value->passport_expiry) <= 90)? 'class="alert-expire"' : ''?>><?php echo $pass; ?></p></td>
					<?php if($value->booklet_license != 'N/A' && $value->booklet_license_expiry != 'N/A'): ?>
						<td style="text-align: center"><p><?= ($value->booklet_license)? $value->booklet_license : ''; ?></p><p <?php echo (getRemainingDays($value->booklet_license_expiry) <= 90)? 'class="alert-expire"' : ''?>><?php echo $book; ?></p></td>
					<?php endif; ?>
					<?php if($value->gmdss_nos != 'N/A' && $value->gmdss_expiry != 'N/A'): ?>
						<td style="text-align: center"><p><?= ($value->gmdss_nos)? $value->gmdss_nos : ''; ?></p><p <?php echo (getRemainingDays($value->gmdss_expiry) <= 90)? 'class="alert-expire"' : ''?>><?php echo $gmdss; ?></p></td>
					<?php endif; ?>
					<td style="text-align: center"><p><?= ($value->coc_nos)? $value->coc_nos : ''; ?></p><p <?php echo (getRemainingDays($value->coc_expiry) <= 90)? 'class="alert-expire"' : ''?>><?php echo $coc; ?></p></td>
					<td style="text-align: center"><p <?= (getRemainingDays($value->us_expiry) <= 90)? 'class="alert-expire"' : ''?>><?php echo $us; ?></p></td>
					<td style="text-align: center"><p <?= (getRemainingDays($value->yellow_expiry) <= 90)? 'class="alert-expire"' : ''?>><?php echo $yellow; ?></p></td>
					<td style="text-align: center"><p><?= $med; ?></p></td>
					<td style="text-align: center"><p><?= ($value->mvc_nos)? $value->mvc_nos : ''; ?></p><p <?php echo (getRemainingDays($value->mcv_expiry) <= 90)? 'class="alert-expire"' : ''?>><?php echo $mvc; ?></p></td>
				</tr>
			<?php
				endforeach;
			endif;
			?>
			</tbody>
		</table>

    	<div class="footer"><span class="pagenum"><?= _p($vessel, 'control_nos') ?></span></div>
	</div>
</body>
</html>