<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - POEA Information</title>
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body, * {
			font-size: 12px; 
		}
		p { margin: 0; }

		@page { margin: 0.2in 0.5in 0.1in 0.5in;} 

		.header { text-align: center; margin-bottom: 5px; }
		.header h4, .header h5 { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.gen_info h4 { text-decoration: underline; }
		.square { border: 1px solid #000; width: 12px; height: 12px; }

		table { margin: 0; padding: 0 }	
		table td { padding: 1px 0; vertical-align: middle;  }	/*  border: 1px solid #cecece */
		table th { font-weight: bold; text-align: left; }
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 11px; padding: 0; text-align: center; font-weight: bold; }

		.table2 { width: 100%; font-size: 11px;  }
		.table2 td { padding: 0; }
	</style>
</head>
<body>
	<div class="header">
		<table width="100%">
			<tr>
				<td style="width: 25%; vertical-align: top;">
					<p style="font-size: 10px;"><?php 
						if ($company_id == 1) {
							echo select_iso(1); 
						}
					?></p>
					<div style="border: 1px solid #000; padding: 0 3px 6px 3px; margin-bottom: 10px;">
						<table class="table2">
							<tr>
								<td style="text-align: center;" colspan="2">Payment Date</td>
							</tr>
							<tr>
								<td colspan="2">OWWA</td>
							</tr>
							<tr>
								<td style="width: 10%;">Membership</td>
								<td style="width: 90%;" class="uline">&nbsp;</td>
							</tr>
						</table>
						<table class="table2">
							<tr>
								<td style="width: 20%;">PhilHealth/Medicare</td>
								<td style="width: 80%;" class="uline">&nbsp;</td>
							</tr>
						</table>
					</div>

					<table class="table2">
						<tr>
							<td style="width: 70%;">OFW e-Card / ID No:</td>
							<td style="width: 40%;" class="uline">&nbsp;</td>
						</tr>
					</table>

					<table class="table2">
						<tr>
							<td style="width: 30%;">SSS No:</td>
							<td style="width: 70%;" class="uline">&nbsp;</td>
						</tr>
					</table>

					<table class="table2">
						<tr>
							<td style="width: 30%;">GSIS No:</td>
							<td style="width: 70%;" class="uline">&nbsp;</td>
						</tr>
					</table>

					<table class="table2">
						<tr>
							<td style="width: 50%;">PhilHealth No:</td>
							<td style="width: 50%;" class="uline">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td style="width: 50%; text-align: center; vertical-align: top; padding-top: 5px;" >
					<h4>PHILIPPINE OVERSEAS EMPLOYMENT ADMINISTRATION</h4>
					<h4>OVERSEAS WORKER WELFARE ADMINISTRATION</h4>
					<h4>PHILIPPINE HEALTH INSURANCE CORPORATION</h4>
					<h5 style="margin-top: 10px;">INFORMATION SHEET</h5>
				</td>
				<td style="width: 25%; text-align: center; vertical-align: top;" >
					<div style="border: 1px solid #000; padding: 0 3px 6px 3px;">
						<table class="table2">
							<tr>
								<td style="text-align: center;" colspan="2">(For POEA/OWWA)</td>
							</tr>
							<tr>
								<td style="width: 30%;">CGG no.:</td>
								<td style="width: 70%;" class="uline">&nbsp;</td>
							</tr>
						</table>
						<table class="table2">
							<tr>
								<td style="width: 30%;">RPS no.:</td>
								<td style="width: 70%;" class="uline">&nbsp;</td>
							</tr>
						</table>
						<table class="table2">
							<tr>
								<td style="width: 50%;">Assessment no.:</td>
								<td style="width: 50%;" class="uline">&nbsp;</td>
							</tr>
						</table>
						<table class="table2">
							<tr>
								<td colspan="2">Assessed Amount</td>
							</tr>
							<tr>
								<td style="width: 25%; text-align: right;">POEA:</td>
								<td style="width: 75%;" class="uline">&nbsp;</td>
							</tr>
							<tr>
								<td style="text-align: right;">OWWA</td>
								<td class="uline">&nbsp;</td>
							</tr>
							<tr>
								<td style="text-align: right;">PHILHEALTH</td>
								<td class="uline">&nbsp;</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
		
	</div>
	<div>
		<table style="width: 100%;">
			<tr>
				<td style="text-align: left;"><p>I. <u><b>PERSONAL DATA</b></u></p></td>
				<td style="width: 65%;"></td>
				<td style="width: 17%; text-align: center; "><p><b>Change/s (if any)</b></p></td>
			</tr>
			<tr>
				<td class="td_label"></td>
				<td class="td_label"></td>
				<td class="td_label" style="font-weight: normal; font-size: 9px; ">(for balik-manggagawa)</td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 8%;"><p>Name: </p></th>
				<td style="width: 25%;" class="uline"><p><?php echo isset($lastname)? $lastname : ''; ?></p></td>
				<td style="width: 25%;" class="uline"><p><?php echo isset($firstname)? $firstname : ''; ?></p></td>
				<td style="width: 25%;" class="uline"><p><?php echo isset($middlename)? $middlename : ''; ?></p></td>
				<td style="width: 17%;" class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td class="td_label"></td>
				<td class="td_label">Family Name (Apelyido)</td>
				<td class="td_label">First Name (Pangalan)</td>
				<td class="td_label">Middle Name (Gitnang Apelyido)</td>
				<td class="td_label"></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 30%;"><p>Address in the Philippines: (Tirahan): </p></th>
				<td style="width: 70%;" class="uline"><p><?php echo isset($pres_address)? limit_string($pres_address, 55) : ''; ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 13%;"><p>Telephone No.: </p></th>
				<td style="width: 20%; text-align: center;" class="uline"><p><?php echo isset($pres_tel)? $pres_tel : ''; ?></p></td>
				<th style="width: 13%; text-align: center;"><p>Tel. No. 2</p></th>
				<td style="width: 20%;" class="uline"><p><?php echo isset($prov_tel)? $prov_tel : ''; ?></p></td>
				<th style="width: 13%; text-align: center;"><p>Email Address: </p></th>
				<td style="width: 20%;" class="uline"><p><?php echo isset($email)? $email : '' ; ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 12%; vertical-align: top; padding-bottom: 0;"><p>Date of Birth: </p></th>
				<td style="width: 20%; text-align: center; vertical-align: middle; padding-bottom: 0;" ><p style="border-bottom: 1px solid #000;"><?php echo isset($birthdate)? $birthdate : ''; ?></p></td>
				<th style="width: 10%; text-align: center; vertical-align: middle; padding-bottom: 0;"><p>Sex: </p></th>
				<td style="width: 10%; vertical-align: top; padding-bottom: 0;">
					<table width="100%">
						<tr>
							<td style="width: 30%; text-align: center; vertical-align: top"><div class="square"><?php echo ($gender == 'Male')? 'X' : ''; ?></div></td>
							<td style="width: 20%; vertical-align: top">M</td>
							<td style="width: 30%; text-align: center; vertical-align: top"><div class="square"><?php echo ($gender == 'Female')? 'X' : ''; ?></div></td>
							<td style="width: 20%; vertical-align: top">F</td>
						</tr>
					</table>
				</td>
				<th style="width: 15%; text-align: center; vertical-align: middle; padding-bottom: 0;"><p>Civil Status: </p></th>
				<td style="width: 20%; vertical-align: top; padding-bottom: 0;">
					<table width="100%">
						<tr>
							<td style="width: 15%; text-align: center; vertical-align: top"><div class="square"><?php echo ($civil_status == 'Single')? 'X' : ''; ?></div></td>
							<td style="width: 35%; vertical-align: top ">Single</td>
							<td style="width: 15%; text-align: center; vertical-align: top"><div class="square"><?php echo ($civil_status == 'Widowed')? 'X' : ''; ?></div></td>
							<td style="width: 35%; vertical-align: top">Widowed</td>
						</tr>
					</table>
				</td>
				<td style="width: 13%; padding-top: 0;" class="uline"></td>
			</tr>
		</table>
		<table style="width: 100%;">
			<tr>
				<td style="width: 12%; padding-top: 0;" ></td>
				<td style="width: 20%; vertical-align: top; padding-top: 0;" class="td_label">MM/DD/YY</td>
				<td style="width: 35%; padding-top: 0;" colspan="3" ></td>
				<td style="width: 20%; vertical-align: top; padding-top: 0;">
					<table width="100%">
						<tr>
							<td style="width: 15%; text-align: center; vertical-align: top"><div class="square"><?php echo ($civil_status == 'Married')? 'X' : ''; ?></div></td>
							<td style="width: 35%; vertical-align: top">Married</td>
							<td style="width: 15%; text-align: center; vertical-align: top"><div class="square"><?php echo ($civil_status == 'Divorced')? 'X' : ''; ?></div></td>
							<td style="width: 35%; vertical-align: top">Separated</td>
						</tr>
					</table>
				</td>
				<td style="width: 13%; padding-top: 0;" class="uline"></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 12%;"><p>Place of Birth: </p></th>
				<td style="width: 78%;" class="uline"><p><?php echo isset($birthplace)? $birthplace : ''; ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 12%;"><p>Passport No.: </p></th>
				<td style="width: 25%;" class="uline"><p><?php echo isset($passport_nos)? $passport_nos : ''; ?></p></td>
				<th style="width: 28%; text-align: center;"><p>Highest Educational Attainment: </p></th>
				<td style="width: 35%;" class="uline"><p><?php echo isset($attainment)? $attainment : ''; ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 23%;"><p>Name of Spouse(if married): </p></th>
				<td style="width: 29%;" class="uline"><p><?php echo isset($spouse)? $spouse : ''; ?></p></td>
				<th style="width: 26%; text-align: center;"><p>Mother's Full Maiden Name: </p></th>
				<td style="width: 24%;" class="uline"><p><?php echo isset($middlename)? $middlename : ''; ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;" cellspacing="5">
			<tr>
				<th colspan="3">Legal Beneficiaries (Mga tatanggap ng benepisyo mula sa OWWA)</th>
			</tr>
			<tr>
				<th style="width: 30%; text-align: center;">Name</th>
				<th style="width: 15%; text-align: center;">Relation to Worker</th>
				<th style="width: 55%; text-align: center;">Address</th>
			</tr>
			<?php
				if($beneficiaries):
					foreach ($beneficiaries as $value):				
				?>
					<tr>
						<td class="uline"><p><?php echo $value->child_name; ?></p></td>
						<td class="uline" style="text-align: center;"><p><?php echo $value->relationship; ?></p></td>
						<td class="uline"><p><?php echo limit_string($value->child_address, 50); ?></p></td>
					</tr>
				<?php 
					endforeach;
				else:
					for ($i=0; $i <= 3 ; $i++):					
				?>
					<tr>
						<td class="uline"><p>&nbsp;</p></td>
						<td class="uline"><p>&nbsp;</p></td>
						<td class="uline"><p>&nbsp;</p></td>
					</tr>
				<?php
					endfor;
				endif;
			?>
		</table>

		<table style="width: 100%;" cellspacing="5">
			<tr>
				<th colspan="3">Allottee(Itinalaga na padadalhan ng bahagi ng sahod ng OFW/Seafarer)</th>
			</tr>
			<tr>
				<td class="uline"><p><?php echo isset($beneficiary)? $beneficiary : ''; ?></p></td>
				<td class="uline" style="text-align: center;"><p><?php echo isset($benef_relation)? $benef_relation : '' ; ?></p></td>
				<td class="uline"><p><?php echo isset($benef_add)? limit_string($benef_add, 50) : ''; ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;" cellspacing="5">
			<tr>
				<th colspan="2">Legal Dependents (Mga tatanggap ng benepisyo mula sa PhilHealth)</th>
				<th style="text-align: center;">Relationship of Dependent to</th>
				<th></th>
			</tr>
			<tr>
				<th style="width: 45%; text-align: center;">Name of Spouse/children/Parent</th>
				<th style="width: 10%; text-align: center;">Sex</th>
				<th style="width: 25%; text-align: center;">Worker</th>
				<th style="width: 21%; text-align: center;">Date of Birth</th>
			</tr>
			<?php
				if($beneficiaries):
					foreach ($beneficiaries as $value):				
				?>
					<tr>
						<td class="uline"><p><?php echo $value->child_name; ?></p></td>
						<td class="uline" style="text-align: center;"><p><?php echo $value->child_gender; ?></p></td>
						<td class="uline" style="text-align: center;"><p><?php echo $value->relationship; ?></p></td>
						<td class="uline" style="text-align: center;"><p><?php echo ($value->child_birthdate != '')? date('m/d/Y', strtotime($value->child_birthdate)) : '' ; ?></p></td>
					</tr>
				<?php 
					endforeach; 
				else:
					for ($i=0; $i <= 3 ; $i++):					
				?>
					<tr>
						<td class="uline"><p>&nbsp;</p></td>
						<td class="uline"><p>&nbsp;</p></td>
						<td class="uline"><p>&nbsp;</p></td>
						<td class="uline"><p>&nbsp;</p></td>
					</tr>
				<?php
					endfor;
				endif;
			?>
			
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 28%; text-align: left;"><p>II. <u><b>CONTRACT PARTICULARS</b></u></p></td>
				<td style="width: 55%;"></td>
				<td style="width: 17%; text-align: center; "><p><b>Change/s (if any)</b></p></td>
			</tr>
			<tr>
				<td class="td_label"></td>
				<td class="td_label"></td>
				<td class="td_label" style="font-weight: normal; font-size: 9px; ">(for balik-manggagawa)</td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 33%;"><p>Name of Principal/Company/Employer: </p></th>
				<td style="width: 50%;" class="uline"><p><?php echo isset($principal)? $principal : ''; ?></p></td>
				<td style="width: 17%;" class="uline"><p>&nbsp;</p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 8%;"><p>Address: </p></th>
				<td style="width: 57%; " class="uline"><p style="<?php echo (strlen($prin_address) >= 50)? "font-size: 9px;" : '' ?>"><?php echo isset($prin_address)? $prin_address : ''; ?></p></td>
				<th style="width: 15%; text-align: center; "><p>Email Address: </p></th>
				<td style="width: 12%;" class="uline"><p><?php echo isset($prin_email)? $prin_email : ''; ?></p></td>
				<td style="width: 8%;" class="uline"><p>&nbsp;</p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 15%;"><p>Name of Vessel: </p></th>
				<td style="width: 41%;" class="uline"><p><?php echo isset($vessel_name)? $vessel_name : ''; ?></p></td>
				<th style="width: 16%; text-align: center; "><p>Principal Tel #: </p></th>
				<td style="width: 17%;" class="uline"><p><?php echo isset($principal_tel)? $principal_tel : ''; ?></p></td>
				<td style="width: 11%;" class="uline"><p>&nbsp;</p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 21%;"><p>Position of OFW/Seafarer: </p></th>
				<td style="width: 30%;" class="uline"><p><?php echo isset($position)? $position : ''; ?></p></td>
				<th style="width: 17%; text-align: center; "><p>Contract Duration: </p></th>
				<td style="width: 9%; text-align: center;" class="uline"><p><?php echo isset($duration)? $duration : ''; ?></p></td>
				<td style="width: 6%;"><p>month</p></td>
				<td style="width: 17%;" class="uline"><p>&nbsp;</p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<th style="width: 15%;"><p>Monthly Salary: </p></th>
				<td style="width: 17%;" class="uline"><p><?php echo isset($basic_salary)? $basic_salary : ''; ?></p></td>
				<th style="width: 11%; text-align: center; "><p>Currency: </p></th>
				<td style="width: 30%;" class="uline"><p>DOLLAR</p></td>
				<td style="width: 27%;" class="uline"><p>&nbsp;</p></td>
			</tr>
		</table>

		<table style="width: 100%; margin-bottom: 5px;">
			<tr>
				<th style="width: 58%;"><p>Last date of arrival in the Phils of the OFW balik-manggagawa/seafarer: </p></th>
				<td style="width: 25%;" class="uline"><p>&nbsp;</p></td>
				<td style="width: 17%;" class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<th><p>Date of scheduled departure/ return of balik-mangagawa to the jobsite: </p></th>
				<td class="uline"><p>&nbsp;</p></td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<th><p>Name of Philippine Recruitment/Manning Agency(if applicable): </p></th>
				<td colspan="2" class="uline"><p><?= ($company_id == 1)? 'FAIR SHIPPING CORPORATION' : 'CORDIAL SHIPPING INC.' ?></p></td>
			</tr>
		</table>

		<p style="font-weight: bold; margin-bottom: 5px;">I hereby certify that the above statements are true and correct and further declare that the 
		above-name dependents have not been declare by my spouse/brother/sister. (Ako ay nagpapatunay 
		na ang nasa itaas na pahayag ay totoo at tama at dagdag kong inihahayag na ang nasabing 
		makikinabang sa itaas ay hindi inihayag ng aking asawa o kapatid).</p>

		<table style="width: 100%;">
			<tr>
				<td></td>
				<td style="width: 30%; height: 12px;" class="uline"></td>
			</tr>
			<tr>
				<td class="td_label"></td>
				<td class="td_label" style="font-size: 12px;"><p>Signature/Thumbmark of OFW/Seafarer</p></td>
			</tr>
		</table>
	</div>
</body>
</html>
