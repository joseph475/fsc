
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
		@page { margin: 0.2in 0.5in 0.1in 0.5in;} 
		
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
		table td.td_label2 { font-size: 10px; padding: 0; text-align: center; font-style: italic; }
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
		<h4>Philippine Overseas Employment Administration</h4>
		<h5 style="margin-top: 20px;">STANDARD CADET TRAINING AGREEMENT <br/> 
			ON SHIPS ENGAGED IN INTERNATIONAL VOYAGE</h5>
	</div>

	<div class="gen_info">
		<p>KNOWN ALL MEN BY THESE PRESENTS:</p>
		<p style="text-indent: 30px; font-style: italic;">This Agreement entered into voluntarily by and between:</p>

		<table style="width: 100%; ">
			<tr>
				<td style="width: 16%;"><p>Name of Cadet: </p></td>
				<td class="uline" style="width: 28%;"><p><?php echo isset($lastname)? htmlentities($lastname) : ''; ?> </p></td>
				<td class="uline" style="width: 28%;"><p><?php echo isset($firstname)? htmlentities($firstname) : ''; ?> </p></td>
				<td class="uline" style="width: 28%;"><p><?php echo isset($middlename)? htmlentities($middlename) : ''; ?> </p></td>
			</tr>
			<tr>
				<td class="td_label"></td>
				<td class="td_label2" style="text-align: left">(Last Name)</td>
				<td class="td_label2" style="text-align: left">(Give Name)</td>
				<td class="td_label2" style="text-align: left">(Middle Name )</td>
			</tr>
			<tr>
				<td><p>Date and Place Birth: </p></td>
				<td class="uline" colspan="5"><p><?php echo isset($birthdate)? date('F d, Y', strtotime($birthdate)) . ', ' : ''; ?> <?php echo isset($birth_province)? (($birth_province == '')? $birthplace : $birth_province) : ''; ?></p></td>
			</tr>
			<tr>
				<td><p>Address: </p></td>
				<td class="uline" colspan="5"><p><?php echo isset($pres_address)? $pres_address : ''; ?></p></td>
			</tr>
		</table>
		<table style="width: 100%; ">
			<tr>
				<td style="width: 16%;"><p>SIRB No.: </p></td>
				<td style="width: 30%;" class="uline"><p><?php echo isset($seaman_nos)? $seaman_nos : ''; ?></p></td>
				<td style="width: 12%;"><p>SRC No.: </p></td>
				<td style="width: 32%;" class="uline"><p><?php echo isset($src_nos)? $src_nos : ''; ?></p></td>
			</tr>
			<tr>
				<td colspan="6" style="font-style: italic;"><p>hereinafter referred to as the Seafarer</p></td>
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
				<td style="width: 33%;"><p>Name and address of Sponsoring Company:  </p></td>
				<td style="width: 67%;" class="uline"><p><?php echo isset($principal)? $principal : ''; ?></p></td>
			</tr>
			<tr>
				<td colspan="2" class="uline"><p><?php echo isset($prin_address)? $prin_address : ''; ?></p></td>
			</tr>
			<tr>
				<td class="td_label2" colspan="2">(Principal / Shipowner / Address)</td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 22%;">Name and Address of School</td>
				<td class="uline"><p><?php echo isset($edu)? $edu : ''; ?></p></td>
			</tr> 
			<tr>
				<td colspan="2" style="font-style: italic;"><p>for the following vessel:</p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 11%;"><p>Name of Vessel: </p></td>
				<td style=" width: 79%;" class="uline" colspan="5"><p><?php echo isset($vessel_name)? $vessel_name : ''; ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 12%;"><p>IMO Number: </p></td>
				<td style="width: 22%;" class="uline"><p><?php echo isset($imo_nos)? $imo_nos : ''; ?></p></td>
				<td style="width: 25%;"><p>Gross Registered Tonnage (GRT): </p></td>
				<td style="width: 20%;" class="uline"><p><?php echo isset($gross)? $gross : ''; ?></p></td>
				<td style="width: 10%;"><p>Year Built: </p></td>
				<td style="width: 11%;" class="uline"><p><?php echo isset($e_year)? $e_year : ''; ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 6%;"><p>Flag: </p></td>
				<td style="width: 19%;" class="uline"><p><?php echo isset($flag)? strtoupper($flag) : ''; ?></p></td>
				<td style="width: 12%;"><p>Vessel Type: </p></td>
				<td style="width: 19%;" class="uline"><p><?php echo isset($vessel_sub_type)? $vessel_sub_type : ''; ?></p></td>
				<td style="width: 17%;"><p>Classification Society: </p></td>
				<td style="width: 27%;" class="uline"><p><?php echo isset($classification)? $classification : ''; ?></p></td>
			</tr>
			<tr>
				<td colspan="6" style="font-style: italic;"><p>hereinafter referred to as the Employer</p></td>
			</tr>
		</table>
	</div>
	<div class="sec3">
		<p style="text-align: center; "><strong>WITNESSETH</strong></p>
		<ol>
			<li>That the Cadet shall be embarked for Training on board under the following terms and conditions:
				<table style="width: 100%; margin-left: 20px; margin-top: 10px;">
					<tr>
						<td style="width: 30%;"><p>1.1 Duration of Contract: </p></td>
						<td style="width: 70%;" class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>">
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
						<td><p>1.3 Monthly Stipend: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><?php echo isset($basic_salary)? $basic_salary : ''; ?></p></td>
					</tr>
					<tr>
						<td><p>1.4 Hours of Training: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><?php echo isset($hourly_work)? $hourly_work : ''; ?></p></td>
					</tr>
					<tr>
						<td><p>1.5 Point of Departure: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p><?php echo isset($point_of_hire)? $point_of_hire : ''; ?></p></td>
					</tr>
					<tr>
						<td><p>1.6 Commencement of Training: </p></td>
						<td class="uline <?= ($company_id == 2)? 'acenter' : '' ;?>"><p>Upon Departure from the Philippines</p></td>
					</tr>
				</table>
			</li>
			<li>The herein terms and conditions as prescribed in the Governing Board Resolution No. 9 and Memorandum
				Circular No. 10, both series of 2010, shall from part of this Agreement and be strictly and faithfully observed.</li>
			<li>Any alterations or changes, in any part of this Agreement shall be evaluated, verified, processed 
				and approved by the Philippine Overseas Employment Administration (POEA). Upon approval, the 
				same shall be deemed an integral part of this POEA approved Standard Cadet Training Agreement.</li>
			<li>Violations of the terms and conditions of this Agreement with its approved Annex shall be 
				ground for disciplinary action against the erring party. </li>
			<li>Training credits earned and documented in the Training Record Book shall be accepted by the school as fullfillment
			of the shipboard training requirements for the grant of a Bachelor of Science Degree in the program in which the cadet is
			enrolled. </li>
		</ol>

		<?php 
			//$date = isset($date)? $date : date('Y-m-d');
		?>
		<p style="margin-left: 60px; ">IN WITNESS WHEREOF the parties have hereto set their hands this <span style="text-decoration: underline; padding: 0 5px; "><?php echo date('d', strtotime($date));  ?></span> day of 
			<span style="text-decoration: underline; padding: 0 5px; "><?php echo date('F Y', strtotime($date));  ?></span> at Manila, Philippines.</p>
		
		<table style="width: 95%; margin: 40px auto 0 auto; ">
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align: center;"><?php echo isset($signatory->poea1)? strtoupper($signatory->poea1) : ''; ?></td>
			</tr>
			<tr>
				<td style="width: 35%; text-align: center;" class="uline"><p><?php echo isset($fullname)? $fullname : ''; ?></p></td>
				<td></td>
				<td style="width: 35%; text-align: center;" class="uline"><p><?php echo isset($signatory->poea1pos)? strtoupper(htmlentities($signatory->poea1pos)) : ''; ?></p></td>
			</tr>
			<tr>
				<td class="td_label">Name and Signature of Cadet</td>
				<td class="td_label"></td>
				<td class="td_label">For the Employer</td>
			</tr>
		</table>
		<table style="width: 35%; margin: 20px auto 0 auto; ">
			<tr>
				<td style="text-align: center;" class="uline">&nbsp;</td>
			</tr>
			<tr>
				<td class="td_label">Name &amp; Signature of School Representative</td>
			</tr>
		</table>
		<table style="width: 95%; margin: 10px auto 0 auto; ">
			<tr>
				<td colspan="3" style="padding: 10px 0 20px; 0"><p>Verified and approved by the POEA:</p></td>
			</tr>	
			<tr>
				<td class="uline">&nbsp;</td>
				<td></td>
				<td class="uline">&nbsp;</td>
			</tr>
			<tr>
				<td class="td_label" style="width: 35%; ">Date</td>
				<td class="td_label"></td>
				<td class="td_label" style="width: 35%; ">Name and Signature of POEA Official</td>
			</tr>
		</table>
	</div>
</body>
</html>