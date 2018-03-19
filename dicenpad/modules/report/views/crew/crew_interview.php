<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Crew Interview Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body, * {
			font: 12px arial,sans-serif;
		}
		p { margin: 0; }

		.header { text-align: center; margin-top: 25px; }
		.header h2, .header h6 { margin: 0; }
		.header h2 { font-size: 14px; text-decoration: underline; }
		.header h6 { font-size: 11px; margin-top: 8px; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }

		table { margin: 0; padding: 0; width: 100%; border-right: none; border-left: none;}	
		table th, table td { border: 1px solid #000; text-align: left; vertical-align: middle; padding: 2px 4px; }
		table td:first-child, table th:first-child { border-left: none; }
		table td:last-child, table th:last-child { border-right: none; }
		table td p { margin: 0; padding: 0 1px; }
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 12px; padding: 0; text-align: center; }

		.table2 { margin-bottom: 10px; }
		.table2 td {border: none; text-align: left; }

		.table3 { margin-bottom: 10px; }
		.table3 td {border: none; text-align: left; padding: 0; }

		ol li { padding: 0 0 15px 0; }

		.alert-expire {
		  	color: #ff0500;
		}
      	.footer { position: fixed; bottom: 0px; text-align: center; }

	</style>
</head>
<body>
	<p style="margin-top: 20px;">
	<?php 
		if (_p($vessel, 'company_id') == 1) {
			echo '<span style="border: 1px solid #000; padding: 2px 4px">FSC-CR-009 Rev. 01</span>';
		}
	?>
	</p>
	<div class="header" >
		<h2>CREW INTERVIEW REPORT</h2>
		<h6>(<?= strtoupper(_p($interview,'vesseltype')) ?> DEPARTMENT)</h6>
	</div>
	<div class="body">

		<table cellpadding="0" cellspacing="0" class="table2" style="margin: 25px 0 8px 0">
			<tr>
				<td style="text-align: right">Date: </td>
				<td width="5%">&nbsp;</td>
				<td width="15%" class="uline"><center><?= date('F d, Y') ?></center></td>
			</tr>
		</table>

		<div style="border-right: 1px solid #000; border-left: 1px solid #000;">
			<table cellpadding="0" cellspacing="0" style="margin-bottom: 8px">
				<tr>
	                <td width="10%"><strong>Name</strong></td>
	                <td width="25%"><?= isset($fullname)? $fullname : '' ?></td>    
	                <td width="5%"><strong>Rank</strong></td>
	                <td width="15%"><?= _p($interview,'rank_interview') ?></td>  
	                <td width="5%"><strong>Age</strong></td>
	                <td width="10%"><?= _p($interview, 'age') ?></td>
	            </tr>
	        </table>

	        <table cellpadding="0" cellspacing="0" style="margin-bottom: 10px">
	            <tr>
	                <td width="20%"><strong>Assigned Vessel</strong></td>
	                <td width="30%"><?= _p($interview,'vesselname_interview') ?></td>    
	                <td>Tentative Schedule</td>
	                <td><?= _p($interview,'tentative_sched') ?></td>
	            </tr>
			</table>

			<table cellpadding="0" cellspacing="0" style="margin-bottom: 15px">
	            <tr>
	                <td width="20%" rowspan="<?= (_p($interview,'vesseltype') == 'Engine')? '4' : '5' ?>" style="vertical-align: top;"><strong>Previous Vessels</strong></td>
	                <td width="30%">Kind of Vessels</td>
	                <td width="50%"><?= _p($interview,'prevkindvessel') ?></td>
	            </tr>
	            <?php if(_p($interview,'vesseltype') == 'Engine'): ?>
	            <tr>
	                <td>Kind of Engines</td>
	                <td><?= _p($interview,'prevkindengine') ?></td>
	            </tr>
	            <?php endif; ?>
	            <?php if(_p($interview,'vesseltype') == 'Deck'): ?>
	            <tr>
	                <td>Kind of Cargoes</td>
	                <td><?= _p($interview,'prevkindcargo') ?></td>
	            </tr>
	            <tr>
	                <td>Trade Route</td>
	                <td><?= _p($interview,'prevtraderoute') ?></td>
	            </tr>
	            <?php endif; ?>
	            <tr>
	                <td>Salaries Last 3 Vessels</td>
	                <td><?= _p($interview,'prevsalary') ?></td>
	            </tr>
	            <tr>
	                <td>Experienced with Foreign Crew</td>
	                <td><?= _p($interview,'prevforeignexp') ?></td>
	            </tr>
	        </table>
			<table cellpadding="0" cellspacing="0" style="margin-bottom: 10px">
				<thead>
	                <tr>
	                    <th width="4%">NO</th>
	                    <th width="23%">EVALUATION</th> 
	                    <th width="35%">OBSERVATION</th>
	                    <th width="8%">GRADE</th>
	                    <th width="30%">REMARKS</th>
	                </tr>
	            </thead>
				<tbody>
					<tr>
	                    <td style="vertical-align: top;"><center>1</center></td>
	                    <td style="vertical-align: top;">GENERAL APPEARANCE</td>
	                    <td style="vertical-align: top;">Features, Grooming, Nature/ Character and Attitude</td>
	                    <td><center><?= _p($interview,'evalgrade1') ?></center></td>
	                    <td><?= _p($interview,'evalremark1') ?></td>
	                </tr>
	                <tr>
	                    <td style="vertical-align: top;"><center>2</center></td>
	                    <td style="vertical-align: top;">PHYSICAL CONDITION</td>
	                    <td style="vertical-align: top;">Height/Weight Ratio, Complex of face/eyes, Color Blindnes and Blood Pressure</td>
	                    <td><center><?= _p($interview,'evalgrade2') ?></center></td>
	                    <td><?= _p($interview,'evalremark2') ?></td>
	                </tr>
	                <tr>
	                    <td style="vertical-align: top;"><center>3</center></td>
	                    <td style="vertical-align: top;">FLEXIBILITY</td>
	                    <td style="vertical-align: top;">Ability to Get along with Other Crew and Any Unfinished Contract</td>
	                    <td><center><?= _p($interview,'evalgrade3') ?></center></td>
	                    <td><?= _p($interview,'evalremark3') ?></td>
	                </tr>
	                <tr>
	                    <td style="vertical-align: top;"><center>4</center></td>
	                    <td style="vertical-align: top;">SELF-CONFIDENCE</td>
	                    <td style="vertical-align: top;">Total Year of Sea Carrier as Position-Applied and Times of Rehired Same Company</td>
	                    <td><center><?= _p($interview,'evalgrade4') ?></center></td>
	                    <td><?= _p($interview,'evalremark4') ?></td>
	                </tr>
	                <tr>
	                    <td style="vertical-align: top;"><center>5</center></td>
	                    <td style="vertical-align: top;">EVALUATION</td>
	                    <td style="vertical-align: top;">Any recommendation from Previous Crew/ Company or Level of his Skills/ Leadership</td>
	                    <td><center><?= _p($interview,'evalgrade5') ?></center></td>
	                    <td><?= _p($interview,'evalremark5') ?></td>
	                </tr>
	                <tr>
	                    <td rowspan="5" style="vertical-align: top;"><center>6</center></td>
	                    <td rowspan="5" style="vertical-align: top;">WORKING ABILITY</td>
	                    <td style="vertical-align: top;"><?= (_p($interview,'vesseltype') == 'Engine')? '1. For ISM/ISO Documentations' : '1. For ISM/ISO and MARPOL Regulations' ?></td>
	                    <td><center><?= _p($interview,'evalgrade6a') ?></center></td>
	                    <td rowspan="5"><?= _p($interview,'evalremark6') ?></td>
	                </tr>
	                <tr>
	                    <td style="vertical-align: top;"><?= (_p($interview,'vesseltype') == 'Engine')? '2. For Regulation of MARPOL' : '2. For GMDSS System and Computer' ?></td>
	                    <td><center><?= _p($interview,'evalgrade6b') ?></center></td>                            
	                </tr>
	                <tr>
	                    <td style="vertical-align: top;"><?= (_p($interview,'vesseltype') == 'Engine')? '3. For Engine Maintenance' : '3. For Navigation and Watchkeeping' ?></td>
	                    <td><center><?= _p($interview,'evalgrade6c') ?></center></td>                            
	                </tr>
	                <tr>
	                    <td style="vertical-align: top;"><?= (_p($interview,'vesseltype') == 'Engine')? '4. For General Engine Trouble Shootings' : '4. For Char Readings, Light List, Pilot Book' ?></td>
	                    <td><center><?= _p($interview,'evalgrade6d') ?></center></td>
	                </tr>
	                <tr>
	                    <td style="vertical-align: top;"><?= (_p($interview,'vesseltype') == 'Engine')? '5. For Engine Stores, Spares Control' : '5. For Duties and Responsibilites' ?></td>
	                    <td><center><?= _p($interview,'evalgrade6e') ?></center></td>
	                </tr>                        
	                <tr>
	                    <td style="vertical-align: top;" rowspan="2"><center>7</center></td>
	                    <td style="vertical-align: top;" rowspan="2">FINAL EVALUATION</td>
	                    <td style="vertical-align: top;">Total Evaluation</td>
	                    <td colspan="2"><?= _p($interview,'evalgrade7a') ?></td>
	                </tr>                    
	                <tr>
	                    <td style="vertical-align: top;">Average Evaluation</td>
	                    <td colspan="2"><?= _p($interview,'evalgrade7b') ?></td>
	                </tr>
				</tbody>
			</table>
			<table cellpadding="0" cellspacing="0" style="margin-bottom: 8px">
				<thead>
			        <tr>
			            <th width="10%">Grade</th>
			            <td width="17%">5 - Best</td>
			            <td width="18%">4 - Good</td>
			            <td width="18%">3 - Average</td>
			            <td width="18%">2 - Poor</td>
			            <td width="19%">1 - Worst</td>
			        </tr>
			    </thead>
		    </table>
			<table cellpadding="0" cellspacing="0">
	            <tr>
	                <td style="vertical-align: bottom;" width="27%" height="4%">Recommendation</td>
	                <td style="vertical-align: bottom;" width="36%">Good for Vessel MV/MT</td>
	                <td style="vertical-align: bottom;"><?= _p($interview,'goodforvessel') ?></td>
	             </tr>
	        </table>
	    </div>

		<table cellpadding="0" cellspacing="0" class="table2"  style="margin-top: 30px">
            <tr>
                <td>1ST INTERVIEWED BY:</td>
                <td width="10%">&nbsp;</td>
                <td>CHECKED BY:</td>
                <td width="10%">&nbsp;</td>
                <td>APPROVED BY:</td>
            </tr>
            <tr>
                <td class="uline" height="10%" style="vertical-align: bottom;"><?= _p($interview,'interviewby') ?></td>
                <td>&nbsp;</td>
                <td class="uline" style="vertical-align: bottom;"><?= _p($interview,'checkedby') ?></td>
                <td>&nbsp;</td>
                <td class="uline" style="vertical-align: bottom;"><?= _p($interview,'approvedby') ?></td>
            </tr>
        </table>
	</div>
</body>
</html>