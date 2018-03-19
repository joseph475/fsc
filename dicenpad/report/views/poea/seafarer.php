
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - SEAFARER EMPLOYMENT CONTRACT</title>
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body {
			font: 12px arial,sans-serif;
		}

		@page { margin: 0.3in 0.5in 0.1in 0.5in;} 

		.header { text-align: center; margin-bottom: 20px; }
		.header h4, .header h5, p { margin: 0; }
		.header h4 { margin-bottom: 15px; font-size: 12pt; }

		.clear { clear: both; }

		p { text-indent: 10px; }

		table { margin: 0; padding: 0; font-size: 12px; width: 100%; }	
		table td { padding: 4px 3px; vertical-align: middle;   }
		table td.uline { border-bottom: 1px solid #000; }
		table td.bline { border-bottom: 1px dashed #000; }
		table td.td_label { font-size: 12px; padding: 0; text-align: center; }

		.table1 { margin-bottom: 10px;  }
		.table1 td { border-bottom: 1px solid dashed; }
		.table1 td.noborder { border-bottom: none;}


		.table2 { border: 1px solid #000; margin-bottom: 25px; }
		.table2 td span { font-size: 9px; }

		.table3 { margin-bottom: 25px;  }
		.table3 td { border: 1px solid #000; vertical-align: top;}
		.table3 td p { font-size: 9px; text-align: left; vertical-align: top; text-indent: 0; }
		.table3 td span { padding-left: 50px; font-weight: bold; }
	</style>
</head>
<body>
	<div class="header">
		<h4>APPENDIX 6</h4>
		<h4>SEAFARER'S EMPLOYMENT CONTRACT</h4>
	</div>

	<div class="gen_info">
		<table class="table1">
			<tr>
				<td style="width: 5%;" class="noborder">Date</td>
				<td style="width: 30%; text-align: center; "><?php echo $date; ?></td>
				<td style="width: 65%;">and agreed to be effective from</td>
			</tr>
		</table>

		<table class="table2" style="padding: 5px 0;">
			<tr>
				<td style="width: 63%;"><span>This Employment Contract is entered into between the seafarer and Owner/Agent of the Owner of the ship <br/>(hereinafter called the company.)</span></td>
				<td style="width: 37%; padding: 0; vertical-align: text-top;"><div style="border-bottom: 1px dashed #000;"><b><?php echo isset($vessel_name)? $vessel_name : '&nbsp;'; ?> </b></div></td>
			</tr>
		</table>

		<p>THE SEAFARER</p>
		<table class="table3" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 50%;" colspan="2">
					<p>Surname:</p>
					<span><?php echo isset($lastname)? $lastname : '&nbsp;'; ?></span>
				</td>
				<td style="width: 50%;">
					<p>Given Names:</p>
					<span><?= isset($firstname)? $firstname : '&nbsp;'; ?><?= isset($middlename)? ', ' . $middlename : '&nbsp;'; ?></span>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="height: 40px; ">
					<p>Full home address:</p>
					<span><?php echo isset($pres_address)? $pres_address : '&nbsp;'; ?></span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p>Position:</p>
					<span><?php echo isset($position)? $position : '&nbsp;'; ?></span>
				</td>
				<td style="text-align: center;">
					<p>Medical certificate issued on:</p>
					<span><?php echo isset($medical_issued)? $medical_issued : '&nbsp;'; ?></span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p>Estimated time of taking up position:</p>
					<span><?php echo isset($est_time)? $est_time : '&nbsp;'; ?></span>
				</td>
				<td style="text-align: center;">
					<p>Port where position is taken up:</p>
					<span><?php echo isset($port_taken)? $port_taken : '&nbsp;'; ?></span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p>Nationality:</p>
					<span>FILIPINO</span>
				</td>
				<td style="text-align: center;">
					<p>Passport no:</p>
					<span><?php echo isset($passport_nos)? $passport_nos : '&nbsp;'; ?></span>
				</td>
			</tr>
			<tr>
				<td>
					<p>Date of Birth:</p>
					<span><?php echo isset($birthdate)? date('d-M-y', strtotime($birthdate)) : '&nbsp;'; ?></span>
				</td>
				<td>
					<p>Place of Birth:</p>
					<span style="display: inline-block;"><?php echo isset($birth_province)? (($birth_province == '')? $birthplace : $birth_province) : '&nbsp'; ?></span>
				</td>
				<td style="text-align: center;">
					<p>Seaman's book no:</p>
					<span><?php echo isset($seaman_nos)? $seaman_nos : '&nbsp;'; ?></span>
				</td>
			</tr>
		</table>

		<table cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 50%;"><p>THE EMPLOYER</p></td>
				<td style="width: 50%;"><p>THE PRINCIPAL</p></td>
			</tr>
		</table>
		
		<table class="table3" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 50%;">
					<p>Name:</p>
					<span><?= ($company_id == 1)? 'FAIR SHIPPING CORPORATION' : 'CORDIAL SHIPPING INC.' ?></span>
				</td>
				<td style="width: 50%;">
					<p>Name:</p>
					<span><?php echo isset($principal)? $principal : '&nbsp;'; ?></span>
				</td>
			</tr>
			<tr>
				<td style="height: 30px;">
					<p>Address:</p>
					<span><?= ($company_id == 1)? '2079 Fair bldg. Madre Ignacia St. Malate, Manila' : 'Ignacia Haus, 2079 Madre Ignacia St. Malate, Manila' ?></span>
				</td>
				<td style="text-align: center; vertical-align: middle;">
					<p>Address:</p>
					<span style="padding: 0;"><?php echo isset($prin_address)? limit_string($prin_address, 100) : '&nbsp;'; ?></span>
				</td>
			</tr>
		</table>

		<p>THE SHIP</p>
		<table class="table3" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="2">
					<p>Name:</p>
					<span><?php echo isset($vessel_name)? $vessel_name : '&nbsp;'; ?></span>
				</td>
				<td style="width: 25%;">
					<p>IMO No:</p>
					<span><?php echo isset($imo_nos)? $imo_nos : '&nbsp;'; ?></span>
				</td>
			</tr>
			<tr>
				<td style="width: 50%;">
					<p>Flag:</p>
					<span><?php echo isset($flag)? strtoupper($flag) : '&nbsp;'; ?></span>
				</td>
				<td style="width: 50%;" colspan="2">
					<p>Port of registry:</p>
					<span><?php echo isset($registered)? $registered : '&nbsp;'; ?></span>
				</td>
			</tr>
		</table>

		<p>TERMS OF THE CONTRACT</p>
		<table class="table3" cellpadding="0" cellspacing="0" style="margin-bottom: 8px;">
			<tr>
				<td style="width: 33%; ">
					<p>Period of employment:</p>
					<span><?php echo isset($duration)? $duration . ' Months' : '&nbsp;'; ?></span>
				</td>
				<td style="width: 33%; text-align: center;">
					<p>Wages from and including:</p>
					<span style="padding: 0;">Upon Departure Manila</span>
				</td>
				<td style="width: 34%; text-align: center;">
					<p>Basic hours of work per week:</p>
					<span style="padding: 0;"><?php echo isset($hourly_work)? $hourly_work : '&nbsp;'; ?></span>
				</td>
			</tr>
			<tr>
				<td style="width: 33%;">
					<p>Basic monthly wages:</p>
					<span><?php echo isset($basic_salary)? $basic_salary : '&nbsp;'; ?></span>
				</td>
				<td style="width: 33%; text-align: center;">
					<p>Monthly overtime: (103 hours guaranteed)</p>
					<span style="padding: 0;"><?php echo isset($ot_fixed)? $ot_fixed : '&nbsp;'; ?></span>
				</td>
				<td style="width: 34%; text-align: center;">
					<p>Overtime rate for hours worked in excess 103 hrs:</p>
					<span style="padding: 0;"><?php echo isset($ot_hourly)? $ot_hourly . ' as per CBA per hour' : '&nbsp;'; ?></span>
				</td>
			</tr>
			<tr>
				<td style="width: 33%; text-align: center;">
					<p>Leave: Number of days per month:</p>
					<span style="padding: 0;"><?php echo isset($leave_day)? $leave_day : '&nbsp;'; ?></span>
				</td>
				<td style="width: 33%; text-align: center;">
					<p>Monthly leave pay:</p>
					<span style="padding: 0;"><?php echo isset($leave_pay)? $leave_pay : '&nbsp;'; ?></span>
				</td>
				<td style="width: 34%;">
					<p>Monthly subsistence allowance on leave:</p>
					<span><?php echo isset($s_allowance)? $s_allowance : '&nbsp;'; ?></span>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="height: 30px; vertical-align: top;">
					<p>1. The current IBF Collective shall be considered to be incorporated into and to form part of the contract</p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="height: 30px; vertical-align: top;">
					<p>2. The ship's Articles shall be deemed for all purposes to include the terms of this contract (including the applicable IBF Agreement) 
						and it shall be the duty of the Company to ensure that the ship's Articles reflect these terms. These terms shall take precedence over all
						other terms.</p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="height: 30px; vertical-align: top;">
					<p>3. The Seafarer has read, understood and agreed to the terms and conditions of employment as identified in the Collective Agreement and enter into this Contract freely.</p>
				</td>
			</tr>
		</table>

		<p style="margin-bottom: 8px;">CONFIRMATION OF THE CONTRACT</p>
		<table class="table3" cellpadding="0" cellspacing="0" style="margin-bottom: 0;">
			<tr>
				<td style="width: 50%;">
					<p>Signature of Employer</p>
					<span>&nbsp;</span>
				</td>
				<td style="width: 50%;">
					<p>Signature of seafarer</p>
					<span><?php echo isset($fullname)? $fullname : '&nbsp;'; ?> - <?php echo isset($code)? $code : '&nbsp;'; ?></span>
					<table cellpadding="0" cellspacing="0" style="margin: 0;">
						<tr>
							<td style="padding: 0; border: none;"><p>Place:</p></td>
							<td  style="padding: 0; border: none;"><p>Date:</p></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<h3 style="margin-bottom: 0; text-align: center; padding-top: 5px;">36</h3>
	</div>
</body>
</html>