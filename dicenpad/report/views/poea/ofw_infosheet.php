
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

		.header { text-align: center; margin-bottom: 20px; padding-bottom: 0; }
		.header .tblhead {  border-bottom: 17px solid #d9d9d9; } 
		.header .tblhead, .header .tblhead tr  { margin-bottom: 0; padding-bottom: 0; }
		.header .tblhead tr td p { font-size: 14px; }
		.header .tblhead tr td small { font-size: 10px; }

		.clear { clear: both; }

		table { margin: 0; padding: 0; font-size: 10px; width: 100%; }	
		table td { padding: 4px 3px; vertical-align: middle;   }
		table td.uline { border-bottom: 1px solid #000; }
		table td.bline { border-bottom: 1px dashed #000; }
		table td.td_label { font-size: 12px; padding: 0; text-align: center; }

		.table1 { margin-bottom: 0; border: 1px solid solid; padding: 5px;  }
		.table1 td { font-size: 8px; padding: 3px 0;}

		.table2 { border: none; margin-bottom: 0; font-size: 11px; }
		.table2 td { padding: 4px 2px; font-size: 10px; }
		.table2 td p.label { font-size: 10px; padding: 0; margin: 0; }
	</style>
</head>
<body>

	<div class="header">
		<table class="tblhead" style="width: 100%">
			<tr>
				<td style="text-align: center;"><small>THIS FORM IS NOT FOR SALE</small></td>
				<td>&nbsp;</td>
				<td style="text-align: center;"><small>FM-MPC-OIS-D01 </small></td>
			</tr>
			<tr>
				<td style="width: 25%; text-align: center;"><img src="<?php echo base_url() .  BASE_IMG . 'dole-logos.jpg'; ?>" width="86" /></td>
				<td style="width: 55%; text-align: center;"><p>REPUBLIC OF THE PHILIPPINES<br/> DEPARTMENT OF LABOR AND EMPLOYMENT<br/> OVERSEAS WORKERS WELFARE ADMINISTRATION </p></td>
				<td style="width: 20%; text-align: center;"><img src="<?php echo base_url() .  BASE_IMG . 'owwa-logos.jpg'; ?>" width="86" /></td>
			</tr>
		</table>
		
		<table>
			<tr>
				<td style="text-align: center;">
					<table style="margin: 0; padding: 0;">
						<tr>
							<td style="vertical-align: top; font-size: 10px;"><small>Please fill-out this form legibly</small></td>
						</tr>
						<tr>
							<td style="text-align: center;"><h1>OFW INFORMATION SHEET</h1></td>
						</tr>
						<tr>
							<td>
								<table class="table2" style="width: 30%: margin: 0; padding: 0;">
									<tr>
										<td style="width: 15%: padding: 0; margin: 0; font-size: 10px;"><p class="label">Date:</p></td>
										<td style="width: 85%: padding: 0; margin: 0; font-size: 10px;" class="uline"><?= date('m/d/Y') ?></td>
									</tr>
								</table>
							</td>
						<tr>
					</table>
				</td>
				<td style="width: 28%">
					<table class="table1">
						<tr><td colspan="2"><strong>FOR OWWA USE ONLY: </strong> </td></tr>
						<tr><td colspan="2"><strong>LAST PAYMENT OF OWWA CONTRIBUTION</strong></td></tr>
						<tr><td style="width: 30%">OR Number: </td><td class="uline">&nbsp;</td></tr>
						<tr><td>OR Date: </td><td class="uline">&nbsp;</td></tr>
						<tr><td>Validity:   </td><td class="uline">&nbsp;</td></tr>
						<tr><td>Verified by: </td><td class="uline">&nbsp;</td></tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<div class="gen_info">
		<table class="table2">
			<tr>
				<td colspan="4" style="background-color: #d9d9d9">PERSONAL DATA </td>
			</tr>
			<tr>
				<td class="uline"><?php echo isset($lastname)? $lastname : ''; ?></td>
				<td class="uline"><?php echo isset($firstname)? $firstname : ''; ?></td>
				<td class="uline">&nbsp;</td>
				<td class="uline"><?php echo isset($middlename)? $middlename : ''; ?></td>
			</tr>
			<tr>
				<td style="text-align: left; width: 30%; "><p class="label">Last Name</p></td>
				<td style="text-align: center; width: 25%;"><p class="label">First Name</p></td>
				<td style="text-align: center; width: 25%;"><p class="label">Name Ext. (e.g. Jr., III) </p></td>
				<td style="text-align: center; width: 20%;"><p class="label">Middle Name</p> </td>
			</tr>
		</table>

		<table class="table2">
			<tr>
				<td style="text-align: left;"><p class="label">Philippine Address:</p></td>
				<td colspan="4" class="uline"><?php echo isset($pres_address)? limit_string($pres_address, 55) : ''; ?></td>
			</tr>
			<tr>
				<td style="width: 15%;">&nbsp;</td>
				<td style="text-align: center; width: 22%;"><p class="label">House No.</p></td>
				<td style="text-align: center; width: 21%;"><p class="label">Lot No. Block No. Phase No.  </p> </td> 
				<td style="text-align: center; width: 21%;"><p class="label">Street  </p></td>
				<td style="text-align: center; width: 21%;"><p class="label">Subdivision</p></td>
			</tr>
		</table>

		<table class="table2">
			<tr>
				<td colspan="4" class="uline">&nbsp;</td>
			</tr>
			<tr>
				<td style="text-align: center; width: 25%; "><p class="label">Barangay </p></td>
				<td style="text-align: center; width: 25%;"><p class="label"> Municipality/City </p></td>
				<td style="text-align: center; width: 25%;"><p class="label">Province </p></td>
				<td style="text-align: center; width: 25%;"><p class="label">Zipcode </p> </td>
			</tr>
		</table>

		<table class="table2">
			<tr>
				<td style="width: 9%; text-align: left;"><p class="label">Contact No.:</p></td>
				<td style="width: 22%" class="uline"><?php echo isset($pres_tel)? $pres_tel : ''; ?></td>
				<td style="width: 10%; text-align: left;"><p class="label">E-mail Address:</p></td>
				<td style="width: 21%" class="uline"><?php echo isset($email)? $email : '' ; ?></td>
				<td style="width: 9%; text-align: left;"><p class="label">Passport No.:</p></td>
				<td style="width: 22%" class="uline"><?php echo isset($passport_nos)? $passport_nos : ''; ?></td>
			</tr>
		</table>

		<table class="table2">
			<tr>
				<td style="width: 8%; text-align: left;"><p class="label">Birthdate:</p></td>
				<td style="width: 13%" class="uline"><?php echo isset($birthdate)? $birthdate : ''; ?></td>
				<td style="width: 6%; text-align: left;"><p class="label">Sex:</p></td>
				<td style="width: 18%" class="uline"><?php echo isset($gender)? $gender : ''; ?></td>
				<td style="width: 7%; text-align: left;"><p class="label">Religion:</p></td>
				<td style="width: 17%" class="uline"><?php echo isset($religion)? $religion : ''; ?></td>
				<td style="width: 9%; text-align: left;"><p class="label">Civil Status:</p></td>
				<td style="width: 22%" class="uline"><?php echo isset($civil_status)? $civil_status : ''; ?></td>
			</tr>
		</table>

		<table class="table2"  style="margin-bottom: 10px;">
			<tr>
				<td style="width: 22%; text-align: left;"><p class="label">Highest Educational Attainment: </p></td>
				<td style="width: 40%" class="uline"><?php echo isset($attainment)? $attainment : ''; ?></td>
				<td style="width: 8%; text-align: left;"><p class="label">Course:</p></td>
				<td style="width: 30%" class="uline"><?php echo isset($course)? $course : ''; ?></td>
			</tr>
		</table>

		<table class="table2">
			<tr>
				<td colspan="2" style="background-color: #d9d9d9">CONTRACT PARTICULARS  </td>
			</tr>
			<tr>
				<td style="width: 22%; text-align: left;"><p class="label">Name of Company/Employer: </p></td>
				<td style="width: 78%;" class="uline"><?= ($company_id == 1)? 'FAIR SHIPPING CORPORATION' : 'CORDIAL SHIPPING INC.' ?></td>
			</tr>
		</table>

		<table class="table2">
			<tr>
				<td style="width: 8%; text-align: left;"><p class="label">Address: </p></td>
				<td style="width: 92%" class="uline"><?= ($company_id == 1)? '2079 Fair bldg., Madre Ignacia St. Malate, Manila 1004 Philippines' : '2079 Ignacia Haus., Madre Ignacia St. Malate, Manila 1004 Philippines' ?></td>
			</tr>
		</table>

		<table class="table2">
			<tr>
				<td style="width: 8%; text-align: left;"><p class="label">Tel No.: </p></td>
				<td style="width: 25%" class="uline"><?= ($company_id == 1)? '(02)526-0636' : '(02)525-1939' ?></td>
				<td style="width: 12%; text-align: left;"><p class="label"> Jobsite/Country: </p></td>
				<td style="width: 55%" class="uline">Philippines</td>
			</tr>
		</table>

		<table class="table2">
			<tr>
				<td style="width: 8%; text-align: left;"><p class="label">Position:</p></td>
				<td style="width: 22%" class="uline"><?php echo isset($position)? $position : ''; ?></td>
				<td style="width: 17%; text-align: left;"><p class="label"> Monthly Salary/Currency:</p></td>
				<td style="width: 15%" class="uline"><?php echo isset($basic_salary)? $basic_salary : ''; ?></td>
				<td style="width: 12%; text-align: left;"><p class="label">Contract Duration:</p></td>
				<td style="width: 19%" class="uline">
					<?php 
					if($company_id == 2) {
						if(isset($contractstatus)){
							if($contractstatus == 'EXT') {
								echo isset($duration)? $duration . (($duration > 1)? ' Months as of ' : ' Month as of  ') : ''; 
								echo isset($date)? date('F Y', strtotime($date)) : ''; 
							} else {
								echo isset($duration)? $duration . (($duration > 1)? ' Months' : ' Month') : ''; 
							}
						} else {
							echo isset($duration)? $duration . (($duration > 1)? ' Months' : ' Month') : ''; 
						}
					} else {
						echo isset($duration)? $duration . (($duration > 1)? ' Months' : ' Month') : ''; 
					}
					?></td>
			</tr>
		</table>

		<table class="table2" style="margin-bottom: 10px;">
			<tr>
				<td style="width: 22%; text-align: left;"><p class="label">Name of Agency (if applicable): </p></td>
				<td style="width: 78%" class="uline">&nbsp;</td>
			</tr>
		</table>

		<table class="table2">
			<tr>
				<td colspan="9" style="background-color: #d9d9d9;">LEGAL BENEFICIARIES/QUALIFIED DEPENDENTS </td>
			</tr>
			<tr>
				<td style="width: 26%; text-align: center;"><p class="label">Name</p></td>
				<td style="width: 1%;">&nbsp;</td>
				<td style="width: 13%; text-align: center;"><p class="label">Relationship </p></td>
				<td style="width: 1%;">&nbsp;</td>
				<td style="width: 11%; text-align: center;"><p class="label">Date of Birth </p></td>
				<td style="width: 1%;">&nbsp;</td>
				<td style="width: 26%; text-align: center;"><p class="label">Address </p></td>
				<td style="width: 1%;">&nbsp;</td>
				<td style="width: 23%; text-align: center;"><p class="label">Contact No./E-mail Address </p></td>
			</tr>

			<?php
				if($beneficiaries):
					foreach ($beneficiaries as $value):				
				?>
					<tr>
						<td class="uline" ><?php echo $value->child_name; ?></td>
						<td>&nbsp;</td>
						<td class="uline" style="text-align: center;"><?php echo $value->relationship; ?></td>
						<td>&nbsp;</td>
						<td class="uline" style="text-align: center;"><?php echo ($value->child_birthdate != '')? date('m/d/Y', strtotime($value->child_birthdate)) : ''; ?></td>
						<td>&nbsp;</td>
						<td class="uline" style="<?php echo (strlen($value->child_address) >= 30)? 'font-size: 8px;' : '' ?>"><?php echo limit_string($value->child_address, 30); ?></td>
						<td>&nbsp;</td>
						<td class="uline"><?php echo $value->child_telephone; ?></td>
					</tr>
				<?php 
					endforeach;
				else:
					
					for ($i=0; $i <= 3 ; $i++):					
				?>
					<tr>
						<td class="uline">&nbsp;</td>
						<td>&nbsp;</td>
						<td class="uline">&nbsp;</td>
						<td>&nbsp;</td>
						<td class="uline">&nbsp;</td>
						<td>&nbsp;</td>
						<td class="uline">&nbsp;</td>
						<td>&nbsp;</td>
						<td class="uline">&nbsp;</td>
					</tr>
				<?php
					endfor;
				endif;
			?>
			
		</table>

		<p style="font-size: 10px; padding-top: 15px;">I hereby certify that the above information is true and correct. </p>

		<table class="table2"  style="margin-top: 25px; margin-bottom: 20px;">
			<tr>
				<td style="width: 35%;">&nbsp;</td>
				<td style="width: 30%; text-align: center;" class="uline"><?php echo isset($fullname)? $fullname : '&nbsp;'; ?></td>
				<td style="width: 35%;">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="text-align: center;">Signature of Worker </td>
				<td>&nbsp;</td>
			</tr>
		</table>

		<div style="text-align: center;">
			<p style="font-size: 10px;">OWWA Center, 7th St. cor. F.B. Harrison, Pasay City 1300, Philippines . Tel No. 891-7601 to 24 Fax: 804-0638 <br/>24/7 Operation Center -  Hotlines: 551-6641; 551-1560 . Website: www.owwa.gov.ph </p>
		</div>
		
		<p style="text-align: right;">REV: 01 </p>
	</div>
</body>
</html>