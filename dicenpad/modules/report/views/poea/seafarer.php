
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
		span { font-size:10px; }

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

		.table3 { margin-bottom: 15px; }
		.table3 td { border: 1px solid #000; vertical-align: top;}
		.table3 td p { font-size: 9px; text-align: left; vertical-align: top; text-indent: 0; }
		.table3 td span { padding-left: 20px; font-weight: bold;}

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
				<td style="width: 80%;">The employment agreement is entered into on <strong><?php echo $date; ?></strong></td>
				<td style="width: 20%; text-align: center; "> at <strong>PHILIPPINES</strong></td>
			</tr>
			<tr>
				<td>It is agreed to be effective from</td>
			</tr>
		</table>

		<table class="table2" style="padding: 5px 0;">
			<tr>
				<td style="width: 63%;"><span>This Employment Contract is entered into between the seafarer and Owner/Agent of the Owner of the ship</span></td>
				<td style="width: 37%; padding: 0; vertical-align: text-top;"><div style="border-bottom: 1px dashed #000;"><b><?php echo isset($vessel_name)? $vessel_name : '&nbsp;'; ?> </b></div></td>
			</tr>
		</table>

		<p><strong>THE SEAFARER</strong></p>
		<table class="table3" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 50%;" colspan="2">
					<p>Surname: <span style="text-align:right;"><?php echo isset($lastname)? $lastname : '&nbsp;'; ?></span></p>
				</td>
				<td style="width: 50%;">
					<p>
						Given Names: 
						<span><?= isset($firstname)? $firstname : '&nbsp;'; ?><?= isset($middlename)? ', ' . $middlename : '&nbsp;'; ?></span>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="height: 20px; ">
					<p>
						Birth Place:
						<span><?php echo isset($birth_province)? (($birth_province == '')? $birthplace : $birth_province) : '&nbsp'; ?></span>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;">
					<p>
						Position:
						<span><?php echo isset($position)? $position : '&nbsp;'; ?></span>
					</p>
				</td>
				<td style="text-align: center;">
					<p>
						Medical certificate issued on:
						<span><?php echo isset($date_issued)? $date_issued : '&nbsp;'; ?></span>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;">
					<p>
						Nationality:
						<span>FILIPINO</span>
					</p>
				</td>
				<td style="text-align: center;">
					<p>
						Passport no:
						<span><?php echo isset($passport_nos)? $passport_nos : '&nbsp;'; ?></span>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p>
						Date of Birth:
						<span><?php echo isset($birthdate)? date('d-M-y', strtotime($birthdate)) : '&nbsp;'; ?></span>
					</p>
				</td>
				<td>
					<p>
						Seaman's book no:
						<span><?php echo isset($seaman_nos)? $seaman_nos : '&nbsp;'; ?></span>
					</p>
				</td>
			</tr>
		</table>


		<p><strong>THE EMPLOYER</strong></p>		
		<table class="table3" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<p>
						Name:
						<span><?= ($company_id == 1)? 'FAIR SHIPPING CORPORATION' : 'CORDIAL SHIPPING INC.' ?></span>
					</p>
				</td>
			</tr>
			<tr>
				<td style="height: 30px;">
					<p>Address:</p>
					<span><?= ($company_id == 1)? '2079 Fair bldg. Madre Ignacia St. Malate, Manila' : 'Ignacia Haus, 2079 Madre Ignacia St. Malate, Manila' ?></span>
				</td>
			</tr>
		</table>

		<p><strong>THE SHIP</strong></p>
		<table class="table3" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width: 50%;">
					<p>
						Name:
						<span><?php echo isset($vessel_name)? $vessel_name : '&nbsp;'; ?></span>
					</p>
				</td>
				<td style="width: 50%;">
					<p>
						IMO No:
						<span><?php echo isset($imo_nos)? $imo_nos : '&nbsp;'; ?></span>
					</p>
				</td>
			</tr>
			<tr>
				<td style="width: 50%;">
					<p>
						Flag:
						<span><?php echo isset($flag)? strtoupper($flag) : '&nbsp;'; ?></span>
					</p>
				</td>
				<td style="width: 50%;">
					<p>
						Port of registry:
						<span><?php echo isset($registered)? $registered : '&nbsp;'; ?></span>
					</p>
				</td>
			</tr>
		</table>

		<p><strong>THE TERMINATION OF THE AGREEMENT AND THE CONDITIONS</strong></p>
		<table class="table3" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<p>Case(i): The Agreement for an indefinite period</p>
				</td>
			</tr>
			<tr>
				<td style="height: 20px; vertical-align: top;">
					<p>The Conditions entitling either party to terminte the agreement and the required notice period</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Case(ii) : The Agreement for a definite period</p>
				</td>
			</tr>
			<tr>
				<td style="height: 20px; vertical-align: top;">
					<p>The date fixed for the agreement's expiry</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Case(iii) : The agreement for a voyage</p>
				</td>
			</tr>
			<tr>
				<td style="height: 20px; vertical-align: top;">
					<p>The port of destination and the time which has to expire after arrival before the seafarer should be discharged</p>
				</td>
			</tr>			
		</table>

		<p><strong>TERMS OF THE CONTRACT</strong></p>
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
					<span><?php if($basic_salary == 'USD N/A'){echo 'N/A'; }else{echo isset($basic_salary)? $basic_salary : '&nbsp;'; } ?></span>
				</td>
				<td style="width: 33%; text-align: center;">
					<p>Monthly overtime: (103 hours guaranteed)</p>
					<span style="padding: 0;"><?php if($ot_fixed == 'USD N/A'){echo 'N/A'; }else{echo isset($ot_fixed)? $ot_fixed : '&nbsp;'; } ?></span>
				</td>
				<td style="width: 34%; text-align: center;">
					<p>Monthly subsistence allowance on leave:</p>
					<span><?php if($s_allowance == 'USD N/A'){echo 'N/A'; }else{echo isset($s_allowance)? $s_allowance : '&nbsp;'; } ?></span>
				</td>
			</tr>
			<tr>
				<td style="width: 33%; text-align: center;">
					<p>Leave: Number of days per month:</p>
					<span style="padding: 0;"><?php echo isset($leave_day)? $leave_day : '&nbsp;'; ?></span>
				</td>
				<td style="width: 33%; text-align: center;">
					<p>Monthly leave pay:</p>
					<span style="padding: 0;"><?php if($leave_pay == 'USD N/A'){echo 'N/A'; }else{echo isset($leave_pay)? $leave_pay : '&nbsp;'; } ?></span>
				</td>
				<td style="width: 34%;">
					
				</td>
			</tr>
			<tr>
				<td colspan="3" style="vertical-align: top;">
					<p>1. The current Collective Agreement shall be considered to be incorporated into and to form part of contract</p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="vertical-align: top;">
					<p>2. The seafarer's entitlement to repatriation</p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="vertical-align: top;">
					<p>3. References to the collective agreement</p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="vertical-align: top;">
					<p>4. Particulars which national law may require</p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="vertical-align: top;">
				<p>5. The ship's Articles shall be deemed for all purposes to include the terms of this contract (including the applicable IBF Agreement)
						and it shall be the ship's Articles reflect these terms. These terms shall take precedence over all over items</p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="vertical-align: top;">
					<p>6. The seafarer has read, understood and agreed to the terms and condition of employment as identified in the Collective Agreement and enter into this Contract Freely</p>
				</td>
			</tr>			
		</table>

		<p><strong>CONFIRMATION OF THE CONTRACT</strong></p>
		<table class="table3" cellpadding="0" cellspacing="0" style="margin-bottom: 0;">
			<tr>
				<td style="width: 50%;">
					<p>Signature of Employer</p>
					<span>&nbsp;</span>
				</td>
				<td style="width: 50%;">
					<p>Signature of seafarer</p>
					<span><?php echo isset($fullname)? $fullname : '&nbsp;'; ?> - <?php echo isset($code)? $code : '&nbsp;'; ?></span>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>