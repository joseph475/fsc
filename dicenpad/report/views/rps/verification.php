<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - RPS Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body, * {
			font: normal 12px arial,sans-serif; 
		}

		@page { margin: 0.2in 0.5in 0.2in 0.5in;}
		
		p { margin: 0; }

		.header { text-align: center; margin-bottom: 20px; }
		.header table td p { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }

		table { margin: 0; padding: 0; width: 100%; }	
		table td { padding: 2px 0; vertical-align: middle; }	/*  border: 1px solid #cecece } */
		table th { font-weight: bold; text-align: left;  }
		table td p { margin: 0; }
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 12px; padding: 0; text-align: center; }
		table td h4 { margin: 0; }
		
		.table2, .table5 { margin-bottom: 20px; }
		.table2 td, .table5 td  { border: 1px solid #000; }
		.table3 td, .table3 th, .table4 td { border: none; padding: 2px 5px; }
		.table4 { margin: 10px 20px; }

		.table5 td { padding: 10px 0; }
		.table5 td p { padding: 0 4px;}
	</style>
</head>
<body>
	<div class="header">
		<table>
			<tr>
				<td style="width: 75%;"> 
					<p>
					<?php 
						if ($company_id == 1) {
							echo select_iso(7); 
						} else {
							echo select_iso2(7); 
						}
					?></p>
					<p style="margin-bottom: 10px;">Effective Date: <?php echo $date; ?></p>
					<p>PHILIPPINE OVERSEAS EMPLOYMENT ADMINISTRATION</p>
					<p>Seabased Employment Accreditation and Processing Center</p>
					<p>SEABASED PROCESSING DIVISION</p>
				</td>
				<td style="vertical-align: middle; width: 25%; text-align: right; "> 
					<table>
						<tr>
							<td style="width: 65%; text-align: right;">RPS Amendment No.:</td>
							<td style="width: 35%;" class="uline">&nbsp;</td>
						</tr>
						<tr>
							<td style="text-align: right;">Date Recieved:</td>
							<td class="uline">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>

		</table>
	</div>

	<div class="gen_info">
		<h4>RPS-REQUEST FOR AMENDMENT FORM</h4>
		<table class="table2" cellspacing="0" cellpadding="0">
			<tr>
				<td style="border-bottom: none; width: 55%;">
					<table class="table3">
						<tr>
							<td style="width: 35%">Name of Agency</td>
							<th style="width: 65%"><?= ($company_id==1)? 'FAIR SHIPPING CORPORATION' : 'CORDIAL SHIPPING INC.' ?></th>
						</tr>
					</table>
				</td>
				<td style="border-left: none; width: 45%;"rowspan="3">
					<table class="table4">
						<tr>
							<td style="width: 50%">&#91; &nbsp; &nbsp; &#93; Name / Spelling</td>
							<td style="width: 50%">&#91; &nbsp; &nbsp; &#93; Transfer of Vessel</td>
						</tr>
						<tr>
							<td>&#91; &nbsp; &nbsp; &#93; Position</td>
							<td>&#91; &nbsp; &nbsp; &#93; Salary</td>
						</tr>
						<tr>
							<td>&#91; &nbsp; &nbsp; &#93; Contract Duration</td>
							<td>&#91; &nbsp; &nbsp; &#93; RE-Issuance</td>
						</tr>
						<tr>
							<td>&#91; &nbsp; &nbsp; &#93; Contract Continuation</td>
							<td>&#91; &nbsp; &nbsp; &#93; Change Principal</td>
						</tr>
					</table>					
				</td>
			</tr>
			<tr>
				<td style="border-bottom: none; ">
					<table class="table3">
						<tr>
							<td style="width: 35%">Name of Accredited Principal</td>
							<td style="width: 65%"><?php echo isset($principal)? strtoupper($principal) : ''; ?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table class="table3">
						<tr>
							<td style="width: 35%">Name of Vessel</td>
							<td style="width: 65%"><?php echo isset($vessel_name)? strtoupper($vessel_name) : ''; ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<table class="table5" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width: 9%; text-align: center; border-bottom: none; border-right: none;"><p>SRC NO.</p></td>
				<td style="width: 31%; text-align: center; border-bottom: none; border-right: none;"><p>NAME OF SEAFARER</p></td>
				<td style="width: 7%; text-align: center; border-bottom: none; border-right: none;"><p>SIR B #</p></td>
				<td style="width: 6%; text-align: center; border-bottom: none; border-right: none;"><p>GENDER</p></td>
				<td style="width: 15%; text-align: center; border-bottom: none; border-right: none;"><p>POSITION</p></td>
				<td style="width: 8%; text-align: center; border-bottom: none; border-right: none;"><p>SALARY</p></td>
				<td style="width: 10%; text-align: center; border-bottom: none; border-right: none; font-size: 10px;">CONTRACT DURATION</td>
				<td style="width: 14%; text-align: center; border-bottom: none; font-size: 9px;">ENGAGED SEAFARER/S/ RE-ENGAGED/CADET/PRV</td>
			</tr>
			<tr>
				<td style="text-align: center; border-right: none;"><p><?php echo isset($src_nos)? $src_nos : ''; ?></p></td>
				<td style="text-align: center; border-right: none;"><p><?php echo isset($fullname)? strtoupper($fullname) : ''; ?></p></td>
				<td style="text-align: center; border-right: none;"><p><?php echo isset($seaman_nos)? $seaman_nos : ''; ?></p></td>
				<td style="text-align: center; border-right: none;"><p><?php echo isset($gender)? strtoupper($gender) : ''; ?></p></td>
				<td style="text-align: center; border-right: none;"><p><?php echo isset($position)? strtoupper($position) : ''; ?></p></td>
				<td style="text-align: center; border-right: none;"><p><?php echo isset($basic_salary)? $basic_salary : ''; ?></p></td>
				<td style="text-align: center; border-right: none;"><p><?php echo isset($duration)? strtoupper($duration) . ' MONTHS' : ''; ?></p></td>
				<td style="text-align: center; "><p>RE-ENGAGED</p></td>
			</tr>
		</table>

		<table style="font-size: 11px; width: 98%; margin: 0 auto;">
			<tr>
				<td style="width: 20%;">Submitted by:</td>
				<td style="width: 60%;"></td>
				<td style="width: 20%;">Requesting Party:</td>
			</tr>
			<tr>
				<td class="uline" style="padding: 15px 0 5px;"><?php echo isset($signatory->poea2)? $signatory->poea2 : ''; ?></td>
				<td></td>
				<td class="uline" style="padding: 15px 0 5px;"><?php echo isset($signatory->poea1)? $signatory->poea1 : ''; ?></td>
			</tr>
			<tr>
				<td class="td_label">SIGNATURE</td>
				<td class="td_label"></td>
				<td class="td_label">SIGNATURE</td>
			</tr>
			<tr>
				<td class="td_label"><?php echo isset($signatory->poea2pos)? $signatory->poea2pos : ''; ?></td>
				<td class="td_label"></td>
				<td class="td_label"><?php echo isset($signatory->poea1pos)? $signatory->poea1pos : ''; ?></td>
			</tr>
		</table>

		<table class="table2" cellspacing="0" cellpadding="0" style="margin-top: 15px;">
			<tr>
				<td style="width: 50%; border-left: none; ">
					<table class="table3" style="width: 97%; margin: 4px auto;">
						<tr>
							<td colspan="2"><h4 style="margin-bottom: 10px;">For POEA Use Only</h5></td>
						</tr>
						<tr>
							<td style="text-align: center" colspan="2"><p style="text-decoration: underline; margin-bottom: 10px;">ORDER OF PAYMENT</p></td>
						</tr>
						<tr>
							<td colspan="2" style="font-size: 11px; padding-bottom: 10px;">Please accept from the above-named Agency the payment</td>
						</tr>
						<tr>
							<td style="width: 65%">&#91; &nbsp; &nbsp; &#93; POEA Processing Fee only</td>
							<td style="width: 35%"></td>
						</tr>
						<tr>
							<td>&#91; &nbsp; &nbsp; &#93; POEA and OWWA Fees</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td class="uline">&nbsp;</td>
						</tr>
						<tr>
							<td class="td_label"></td>
							<td class="td_label">POEA Evaluator</td>
						</tr>
					</table>
				</td>
				<td style="width: 50%; border-left: none; border-right: none;">
					<table class="table3" style="width: 80%; margin: 4px auto;">
						<tr>
							<td style="text-align: center" colspan="3"><p style="text-decoration: underline; margin-bottom: 10px;">PAYMENTS OF FEES</p></td>
						</tr>
						<tr>
							<td style="width: 47%; font-size: 11px;">Processing fee O.R. No.</td>
							<td style="width: 6%;"></td>
							<td style="width: 47%; font-size: 11px;">OWWA Contribution O.R. No.</td>
						</tr>
						<tr>
							<td class="uline" style="padding-top: 10px;">&nbsp;</td>
							<td></td>
							<td class="uline" style="padding-top: 10px;">&nbsp;</td>
						</tr>
						<tr>
							<td class="uline"  style="padding-top: 15px;">&nbsp;</td>
							<td></td>
							<td class="uline"  style="padding-top: 15px;">&nbsp;</td>
						</tr>
						<tr>
							<td style="padding-top: 20px; text-align: center; font-size: 11px;">POEA Cashier/ Collecting Officer</td>
							<td></td>
							<td style="padding-top: 20px; text-align: center; font-size: 11px;">OWWA Cashier/Collecting Officer</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>