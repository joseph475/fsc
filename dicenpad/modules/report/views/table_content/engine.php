<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Engine Department</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body, .* {
			font-size: 12px; 
		}

		@page { margin: 0.2in 0.5in 0.3in 0.5in;}
		
		p { margin: 0; }

		.header { text-align: center; margin-bottom: 30px; }
		.header h4, .header h5 { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.gen_info h4 { text-decoration: underline; }

		table { margin: 0; padding: 0 }	
		table td { padding: 0; vertical-align: middle;  }	/*  border: 1px solid #cecece */
		table th { font-weight: bold; text-align: left; }
		table td p { margin: 0; }
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 12px; padding: 0; text-align: center; }
		
		.table1 { width: 100%; font-size: 10px; }
		.table1 td { padding: 1px 0; }
	</style>
</head>
<body>
	<div class="header">
		<h4>TABLE OF CONTENTS</h4>
		<h4>OF ENGINE DEPARTMENT CREW DOCUMENT</h4>
	</div>

	<div class="gen_info">

		<table style="width: 55%;">
			<tr>
				<th style="width: 19%;"><p>NAME </p></th>
				<td style="width: 1%;">:</td>
				<td style="width: 80%;" class="uline"><p><?php echo _p($about, 'fullname'); ?></p></td>
			</tr>
			<tr>
				<th><p>POSITION </p></th>
				<td>:</td>
				<td class="uline"><p><?php echo _p($about, 'position'); ?></p></td>
			</tr>
			<tr>
				<th><p>VESSEL </p></th>
				<td>:</td>
				<td class="uline"><p><?php echo _p($about, 'vessel_name'); ?></p></td>
			</tr>
			<tr>
				<th><p>DATE </p></th>
				<td>:</td>
				<td class="uline"><p><?php echo date('m/d/Y') ; ?></p></td>
			</tr>
		</table>

		<table style="margin-bottom: 5px;" class="table1">
			<tr>
				<td style="width: 70%;"></td>
				<td style="width: 1%;"></td>
				<th style="width: 29%; text-align: center;">REMARKS</th>
			</tr>
			<tr>
				<td>1. PERSONAL HISTORY CARD</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td>2. APPLICATION FORM</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td style="padding-left: 25px;">A. INTERVIEW RECORD</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td style="padding-left: 25px;">B. QUESTIONNAIRE & ANSWERS</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td style="padding-left: 25px;">C. MEDICAL HISTORY</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td style="padding-left: 25px;">D. Verification & Checklist of Crew Document</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td style="padding-left: 45px;">(OPERATION / CREWING DEPARTMENT)</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td style="padding-left: 25px;">E. ADDITIONAL INFORMATION OF CREW</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td style="padding-left: 25px;">F. FAMILY BACKGROUND</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td style="padding-left: 25px;">G. TRAINING CERTIFICATES STCW '95 CHECKLIST</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td style="padding-left: 25px;">H. CONDUCT REPORT</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
			<tr>
				<td style="padding-left: 25px;">I. PANAMA CHECKLIST</td>
				<td>:</td>
				<td class="uline"><p>&nbsp;</p></td>
			</tr>
		</table>

		<table class="table1">
			<tr>
				<td style="width: 41%;"></td>
				<td style="width: 1%;"></td>
				<th style="width: 15%; text-align: center; text-decoration: underline;">Number</th>
				<th style="width: 12%; text-align: center; text-decoration: underline;">Date of Issuance</th>
				<th style="width: 12%; text-align: center; text-decoration: underline;">Date of Expiration</th>
				<th style="width: 19%; text-align: center; text-decoration: underline;">Reg./Panama Endo.</th>
			</tr>
		<?php 
		if($docs_by_engine):
		$counter = 2;
		foreach ($docs_by_engine as $value): 
			$counter++;
		?>
			<tr>
				<td style="width: 41%;"><?php echo $counter . '. ' . strtoupper($value->document); ?></td>
				<td style="width: 1%;">:</td>
				<td style="width: 15%;" class="uline"><p style="padding: 0 3px;"><?php echo $value->docs_nos; ?></p></td>
				<td style="width: 12%; text-align: center;" class="uline"><p><?php echo ($value->date_issued != '0000-00-00')? date('m/d/Y', strtotime($value->date_issued)) : ''; ?></p></td>
				<td style="width: 12%; text-align: center;" class="uline"><p><?php echo ($value->date_expired != '0000-00-00')? date('m/d/Y', strtotime($value->date_expired))  : ''; ?></p></td>
				<td style="width: 19%;" class="uline"><p style="padding: 0 3px;"><?php echo $value->remarks; ?></p></td>
			</tr>
		<?php 
		endforeach; 
		endif;
		?>
		</table>

		<table style="width: 40%; margin: 40px auto 0 auto;">
			<tr>
				<td class="uline">&nbsp;</td>
			</tr>
			<tr>
				<td style="text-align: center;">OPERATION STAFF 1</td>
			</tr>
		</table>
		
	</div>
</body>
</html>