
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - POEA Contract</title>
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body {
			font-size: 12px; 
		}
		
		.header { text-align: center; margin-bottom: 30px; }
		.header h4 { font-weight: normal; }
		.header h4, .header h5 { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.gen_info h4 { text-decoration: underline; }

		table { margin: 0; padding: 0; }	
		table td { padding: 2px 0; vertical-align: middle;  }	/*  border: 1px solid #cecece */
		table td p { margin: 0; }
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 12px; padding: 0; text-align: center; }

		.acenter { text-align: center; }

		ol li { padding: 0 0 15px 0; }
	</style>
</head>
<body>
	<p>
	<?php 
		if ($company_id == 1) {
			echo select_iso(3); 
		}
	?>
	</p>
	<div class="header">
		<h4>Republic of the Philippines</h4>
		<h4>Department of Labor and Employment</h4>
		<h4>PHILIPPINE OVERSEAS EMPLOYMENT ADMINISTRATION</h4>
		<h5 style="margin-top: 20px;">CONTRACT OF EMPLOYMENT</h5>
	</div>

	<div class="gen_info">
		<p><strong>KNOWN ALL MEN BY THESE PRESENTS:</strong></p>
		<p style="text-indent: 30px;">This Contract, entered into voluntarily by and between:</p>

		<table style="width: 100%; ">
			<tr>
				<td><p>Name of Seafarer: </p></td>
				<td class="uline" colspan="5"><p><?php echo isset($fullname)? $fullname : ''; ?> </p></td>
			</tr>
			<tr>
				<td><p>Date of Birth: </p></td>
				<td class="uline"><p><?php echo isset($birthdate)? date('F d, Y', strtotime($birthdate)) : ''; ?></p></td>
				<td style="text-align: center;"><p>Place of Birth: </p></td>
				<td  class="uline" colspan="3"><p><?php echo isset($birth_province)? (($birth_province == '')? htmlentities($birthplace) : htmlentities($birth_province)) : ''; ?></p></td>

			</tr>
			<tr>
				<td><p>Address: </p></td>
				<td class="uline" colspan="5"><p><?php echo isset($pres_address)? htmlentities($pres_address) : ''; ?></p></td>
			</tr>
			<tr>
				<td style="width: 16%;"><p>SIRB No.: </p></td>
				<td style="width: 20%; text-align: center;" class="uline"><p><?php echo isset($seaman_nos)? $seaman_nos : ''; ?></p></td>
				<td style="width: 12%; text-align: center;"><p>SRC No.: </p></td>
				<td style="width: 22%; text-align: center;" class="uline"><p><?php echo isset($src_nos)? $src_nos : ''; ?></p></td>
				<td style="width: 10%; text-align: center;"><p>License No.: </p></td>
				<td style="width: 20%; text-align: center;" class="uline"><p><?php echo isset($marina_nos)? $marina_nos : ''; ?></p></td>
			</tr>
			<tr>
				<td colspan="6"><p>hereinafter referred to as the Seafarer</p></td>
			</tr>
			<tr>
				<td style="text-align: center; padding-bottom: 10px;" colspan="6"><p>and</p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 15%;"><p>Name of Agent: </p></td>
				<td style="width: 85%;" class="uline"><p><?= ($company_id == 1)? 'FAIR SHIPPING CORPORATION , 2079 Fair bldg., Madre Ignacia St. Malate, Manila' : 'CORDIAL SHIPPING INC., 2079 Ignacia Haus., Madre Ignacia St. Malate, Manila' ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 25%;"><p>Name of Principal /Shipowner:  </p></td>
				<td style="width: 75%;" class="uline"><p><?php echo isset($principal)? htmlentities($principal) : ''; ?></p></td>
			</tr>
			<tr>
				<td><p>Address of Principal /Shipowner:</p></td>
				<td class="uline"><p><?php echo isset($prin_address)? htmlentities($prin_address) : ''; ?></p></td>
			</tr>
			<!-- <tr>
				<td class="td_label"></td>
				<td class="td_label">(Principal/Country)</td>
			</tr> -->
			<tr>
				<td colspan="2"><p>for the following vessel:</p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 11%;"><p>Name of Vessel: </p></td>
				<td style=" width: 79%; text-align: center;" class="uline" colspan="5"><p><?php echo isset($vessel_name)? htmlentities($vessel_name) : ''; ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 12%;"><p>IMO Number: </p></td>
				<td style="width: 22%; text-align: center;" class="uline"><p><?php echo isset($imo_nos)? $imo_nos : ''; ?></p></td>
				<td style="width: 25%; text-align: center;"><p>Gross Registered Tonnage (GRT): </p></td>
				<td style="width: 20%; text-align: center;" class="uline"><p><?php echo isset($gross)? $gross : ''; ?></p></td>
				<td style="width: 10%; text-align: center;"><p>Year Built: </p></td>
				<td style="width: 11%; text-align: center;" class="uline"><p><?php echo isset($e_year)? $e_year : ''; ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 6%;"><p>Flag: </p></td>
				<td style="width: 19%; text-align: center;" class="uline"><p><?php echo isset($flag)? strtoupper($flag) : ''; ?></p></td>
				<td style="width: 12%; text-align: center;"><p>Vessel Type: </p></td>
				<td style="width: 19%; text-align: center;" class="uline"><p><?php echo isset($vessel_sub_type)? $vessel_sub_type : ''; ?></p></td>
				<td style="width: 17%; text-align: center;"><p>Classification Society: </p></td>
				<td style="width: 27%; text-align: center;" class="uline"><p><?php echo isset($classification)? $classification : ''; ?></p></td>
			</tr>
			<tr>
				<td colspan="6"><p>hereinafter referred to as the Employer</p></td>
			</tr>
		</table>
	</div>
	<div class="sec3">
		<p style="text-align: center; "><strong>WITNESSETH</strong></p>
		<ol>
			<li>That the seafarer shall be employed on board under the following terms and conditions:
				<table style="width: 100%; margin-left: 20px; margin-top: 10px;">
					<tr>
						<td style="width: 23%;"><p>1.1 Duration of Contract: </p></td>
						<td style="width: 77%;" class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>">
							<p>
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
								?>
							</p>
						</td>
					</tr>
					<tr>
						<td><p>1.2 Position: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><?php echo isset($position)? $position : ''; ?></p></td>
					</tr>
					<tr>
						<td><p>1.3 Basic Monthly Salary: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><?php echo isset($basic_salary)? $basic_salary : ''; ?></p></td>
					</tr>
					<tr>
						<td><p>1.4 Hours of Work: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><?php echo isset($hourly_work)? $hourly_work : ''; ?></p></td>
					</tr>
					<tr>
						<td><p>1.5 Overtime: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><?php echo isset($overtime)? $overtime : ''; ?></p></td>
					</tr>
					<tr>
						<td><p>1.6 Vacation Leave with Pay: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>">
							<p>
								<?php echo isset($leave_pay)? $leave_pay . ' Per Month; ' : ''; ?>
								<?php echo ($company_id == 2)? $other_benefits . ' Other Benefit' : ''; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td><p>1.7 Point of Hire: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><strong><?php echo isset($point_of_hire)? htmlentities($point_of_hire) : ''; ?></strong></p></td>
					</tr>

				</table>
				<table style="width: 100%; margin-left: 20px;">
					<tr>
						<td style="width: 35%;"><p>1.8 Collective Bargaining Agreement, if any: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><?php if($cba == "NON CBA"){echo "NON CBA";}else{echo isset($bargain)? $bargain : '';} ?></p></td>
					</tr>
					

					<tr id="divhide">
						<td style="width: 35%;"><p>1.9 Fixed Supervisory Allowance: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><?php if($division =="Officers"){echo $other_benefits;}
						else{echo "Not Applicable";} ?></p></td>
					</tr>
					<tr id="divhide">
						<td style="width: 35%;"><p>1.10 Subsistence Allowance: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><?php echo $s_allowance; ?></p></td>
					</tr>
				</table>
			</li>
			<li>The herein terms and conditions in accordance with POEA Governing Board Resolution No. 9 and 
				Memorandum Circular No. 10, both series of 2010, shall be strictly and faithfully observed.	</li>
			<li>Any alterations or changes, in any part of this Contract shall be evaluated, verified, processed 
				and approved by the Philippine Overseas Employment Administration (POEA). Upon approval, the 
				same shall be deemed an integral part of the Standard Terms and Conditions Governing the Employment 
				of Filipino Seafarers On-Board Ocean Going Vessels.	</li>
			<li>Violations of the terms and conditions of this Contract with its approved addendum shall be 
				ground for disciplinary action against the erring party. </li>
		</ol>

		<?php 
			//$date = isset($date)? $date : date('Y-m-d');
		?>
		<p style="margin-left: 60px;">IN WITNESS WHEREOF the parties have hereto set their hands this <span style="text-decoration: underline; padding: 0 5px; "><?php echo date('d', strtotime($date));  ?></span> day of 
			<span style="text-decoration: underline; padding: 0 5px;"><?php echo date('F Y', strtotime($date));  ?></span> at Manila, Philippines<?php if($contractstatus =="EXT"){echo " / On board.";}else{echo ".";};?></p>
		
		<table style="width: 95%; margin: 40px auto 0 auto; ">
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align: center;"><?php echo isset($signatory->poea1)? strtoupper(htmlentities($signatory->poea1)) : ''; ?></td>
			</tr>
			<tr>
				<td style="width: 30%; text-align: center;" class="uline"><p><?php echo isset($fullname)? htmlentities($fullname) : ''; ?></p></td>
				<td></td>
				<td style="width: 30%; text-align: center;" class="uline"><p><?php echo isset($signatory->poea1pos)? strtoupper(htmlentities($signatory->poea1pos)) : ''; ?></p></td>
			</tr>
			<tr>
				<td class="td_label">Seafarer</td>
				<td class="td_label"></td>
				<td class="td_label">For the Employer</td>
			</tr>
			<tr>
				<td class="td_label"></td>
				<td class="td_label"></td>
				<td class="td_label">Name and Signature/Designation</td>
			</tr>
			<tr>
				<td colspan="3" style="padding: 10px 0 20px; 0"><p>Verified and approved by the POEA:</p></td>
			</tr>	
			<tr>
				<td class="uline">&nbsp;</td>
				<td></td>
				<td class="uline">&nbsp;</td>
			</tr>
			<tr>
				<td class="td_label">Date</td>
				<td class="td_label"></td>
				<td class="td_label">Name and Signature of POEA Official</td>
			</tr>
		</table>
	</div>
</body>
</html>