
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Panama Checklist</title>
    <meta name="description" content="">
    <meta name="author" content="MJRC">
	<style type="text/css">
		body {
			font-size: 12px; 
			font-family: sans-serif
		}
		.container{
			width: 90%;
			margin: auto;
		}
		.header { text-align: center; margin-bottom: 30px; }


		h1{font-family:"segoe ui", "segoe", "optima",'calibri', sans-serif,arial; text-align: center; font-weight:lighter; display: block; padding: 0px; margin: 0px; font-size: 25px;}

		.clear { clear: both; }
		.t1val{ border-bottom: 1px solid black; padding-top: 10px; }
		.t1label{padding-top: 10px; text-align: left; width: 22%;}

		.t2label{padding-top: 10px; text-align: left; width: 253px; }
		.t2val{width: 385px; border-bottom: 1px solid black;}

		.t3label{padding-top: 10px; padding-left: 50px; text-align: left;}	
		
		.t3val{border-bottom: 1px solid black; text-align: left;}


		.t4 td{padding-top: 0px;}
		.t3indent{text-indent: 40px;}
		td p{padding:0px ;margin: 0px; display: inline-block;}
		.excempted{border-bottom: 0px;}
		.alert-expire {
		  	color: #ff0500;
		  	font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<p style="text-align: left; margin-bottom: 15px;">FSC-OP-025 REV. 05</p>
			<h1>CHECKLIST FOR PANAMA APPLICATION</h1>
			<h1>FOR JOINING CREW</h1>
		</div>

		<div class="content">
			<table  style="text-align: center; width: 40%;">
				
				<tr>
					<td class="t1label">DATE :</td>
					<td class="t1val"><?php echo $date?></td>
				</tr>
				<tr>
					<td class="t1label">NAME :</td>
					<td class="t1val" style="font-weight: bold; text-align: center; font-size: 12px;"><?php echo $fullname?></td>
				</tr>

				<tr>
					<td class="t1label">RANK :</td>
					<td class="t1val"><?php echo $position?></td>
				</tr>

			</table>

			<table style="text-align: left;">

				<tr>
					<td class="t2label" colspan="1">Signature of Crew :</td>
					<td class="t2val" colspan="2"></td>
				</tr>
				<tr>
					<td class="t2label" colspan="1">Assigned Vessel :</td>
					<td class="t2val" colspan="2"><?php echo $vessel_name?></td>
				</tr>
			</table>

				<?php 
					if($docs):

					$docs_id = array(3,6,7,240,13, 14, 15, 16, 203,209,205,208,212,235,207,202,204,7,8,240);

					foreach ($docs as $value): 	

					$code = ($value->docs_nos)? $value->docs_nos : 'N/A';
					$capacity = ($value->capacity)? $value->capacity : 'N/A';

					$expiry = ($value->date_expired)? date('F d, Y', strtotime($value->date_expired)) : str_repeat("&nbsp;", 1) ;
					$endorsement = ($value->endorsement)? $value->endorsement : 'N/A';
					$remarks = ($value->remarks)? $value->remarks : 'N/A';

					if (in_array($value->docs_id, $docs_id)):

						if($value->docs_id == 3){$passport = $code;}
						if($value->docs_id == 240){$GOC = $code;}
						if($value->docs_id == 7){$COC = $code;}
						if($value->docs_id == 6){$COE = $code;}

						if($value->docs_id == 16){$pan_sso = $code; $pan_sso_expiry = $expiry;}
						if($value->docs_id == 13){$pan_booklet = $code; $pan_booklet_expiry = $expiry; $cap = $capacity;}
						if($value->docs_id == 15){$pan_gmdss = $code; $pan_gmdss_expiry = $expiry;}
						if($value->docs_id == 203){$pan_pscrb = $code; $pan_pscrb_expiry = $expiry;}
						if($value->docs_id == 209){$pan_aff = $code; $pan_aff_expiry = $expiry;}
						if($value->docs_id == 205){$pan_mcare = $code; $pan_mcare_expiry = $expiry;}
						if($value->docs_id == 208){$pan_ais = $code; $pan_ais_expiry = $expiry;}
						if($value->docs_id == 212){$pan_sso = $code; $pan_sso_expiry = $expiry;}
						if($value->docs_id == 235){$pan_ecdis = $code; $pan_ecdis_expiry = $expiry;}
						if($value->docs_id == 207){$pan_bsc = $code; $pan_bsc_expiry = $expiry;}
						if($value->docs_id == 202){$pan_sdsd = $code; $pan_sdsd_expiry = $expiry;}
						if($value->docs_id == 204){$pan_nc2 = $code; $pan_nc2_expiry = $expiry;}
						if($value->docs_id == 7){$prc_coc = $code; $prc_coc_expiry = $expiry; $prc_coc_endorsement = $endorsement; $prc_coc_remarks = $remarks;}
						if($value->docs_id == 240){$goc = $code; $goc_expiry = $expiry; $goc_remarks = $remarks;}
						if($value->docs_id == 8){$tesda_cop = $code; $tesda_cop_expiry = $expiry; $tesda_cop_remarks = $remarks;}
	
					endif;	
				  	endforeach;
					endif;
					
				?>

			<table class="t3" style="text-align: left; border-collapse: collapse;">
		
				<tr>
					<td class="t3label" style="width: 208px;">PANAMA SSO LICENSE :</td>
					<td class="t3val" style="width: 115px;"><?php echo isset($pan_sso)? $pan_sso : 'N/A'?></td>

					<td class="t3val"  style="width: 160px;">
					<p <?php echo (getRemainingDays(isset($pan_sso_expiry)? $pan_sso_expiry : '') <= 90)? 'class="alert-expire"' : 'class="normal"' ?>>
					<?php echo isset($pan_sso_expiry)? $pan_sso_expiry : ''?></p></td>

					<td class="t3val" style="width: 115px; text-align: right;">

					</td>

				</tr>

				<tr>
					<td class="t3label" style="width: 208px;">PANAMA BOOKLET / LICENSE :</td>
					<td class="t3val" style="width: 115px;"><?php echo isset($cap)? $cap : 'N/A'?></td>
					<td class="t3val"  style="width: 160px;">
					<p <?php echo (getRemainingDays(isset($pan_booklet_expiry)? $pan_booklet_expiry : '') <= 90)? 'class="alert-expire"' : 'class="normal"' ?>>
					<?php echo isset($pan_booklet)? $pan_booklet . ' ' . $pan_booklet_expiry : ''?></p></td>


					<td class="t3val" style="width: 115px; text-align: right;">
						<?php if($division == "Ratings"){ echo isset($passport)? ($passport == "N/A")? '' : $passport : '';}?>
						<?php if($division == "Officers"){ echo isset($COC)? ($COC == "N/A")? '' : $COC : '';}?>
					</td>
				</tr>

				<tr>
					<td class="t3label" style="width: 208px;">PANAMA GMDSS "DECK" :</td>
					<td class="t3val" style="width: 115px;"><?php echo isset($pan_gmdss)? $pan_gmdss : 'N/A'?></td>

					<td class="t3val"  style="width: 160px;">
					<p <?php echo (getRemainingDays(isset($pan_gmdss_expiry)? $pan_gmdss_expiry : '') <= 90)? 'class="alert-expire"' : 'class="normal"' ?>>
					<?php echo isset($pan_gmdss_expiry)? $pan_gmdss_expiry : ''?></p></td>

					<td class="t3val" style="width: 115px; text-align: right;">
						<?php if($division == "Officers"){ echo isset($GOC)? ($GOC == "N/A")? '' : $GOC : '';}?>
					</td>
				</tr>

				<tr>
					<td class="t3label excempted" colspan="4" style="width: 208px; padding-top: 40px;">PANAMA ENDORSEMENT :</td>
				</tr>

			</table>

			<table class="t4" style="text-align: left; margin-top: 15px; border-collapse: collapse;">
				<tr>
					<td class="t3label t3indent" style="width: 208px;">= CHEM/OIL/LPG</td>
					<td class="t3val" style="width: 195px;">N/A</td>
					<td class="t3val" style="width: 190px;"></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">= PSC & RB</td>
					<td class="t3val" style="width: 195px;"><?php echo isset($pan_pscrb)? $pan_pscrb : 'N/A'?></td>

					<td class="t3val"  style="width: 190px;">
					<p <?php echo (getRemainingDays(isset($pan_pscrb_expiry)? $pan_pscrb_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($pan_pscrb_expiry)? $pan_pscrb_expiry : ''?></p></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">= ATFF</td>
					<td class="t3val" style="width: 195px;"><?php echo isset($pan_aff)? $pan_aff : 'N/A'?></td>

					<td class="t3val"  style="width: 190px;">
					<p <?php echo (getRemainingDays(isset($pan_aff_expiry)? $pan_aff_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($pan_aff_expiry)? $pan_aff_expiry : ''?></p></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">= M/CARE</td>
					<td class="t3val" style="width: 195px;"><?php echo isset($pan_mcare)? $pan_mcare : 'N/A'?></td>

					<td class="t3val"  style="width: 190px;">
					<p <?php echo (getRemainingDays(isset($pan_mcare_expiry)? $pan_mcare_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($pan_mcare_expiry)? $pan_mcare_expiry : ''?></p></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">= AIS</td>
					<td class="t3val" style="width: 195px;"><?php echo isset($pan_ais)? $pan_ais : 'N/A'?></td

					<td class="t3val"  style="width: 190px;">
					<p <?php echo (getRemainingDays(isset($pan_ais_expiry)? $pan_ais_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($pan_ais_expiry)? $pan_ais_expiry : ''?></p></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">= SSO</td>
					<td class="t3val" style="width: 195px;"><?php echo isset($pan_sso)? $pan_sso : 'N/A'?></td>

					<td class="t3val"  style="width: 190px;">
					<p <?php echo (getRemainingDays(isset($pan_sso_expiry)? $pan_sso_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($pan_sso_expiry)? $pan_sso_expiry : ''?></p></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">= ECDIS </td>
					<td class="t3val" style="width: 195px;"><?php echo isset($pan_ecdis)? $pan_ecdis : 'N/A'?></td>

					<td class="t3val"  style="width: 190px;">
					<p <?php echo (getRemainingDays(isset($pan_ecdis_expiry)? $pan_ecdis_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($pan_ecdis_expiry)? $pan_ecdis_expiry : ''?></p></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">= BSC</td>
					<td class="t3val" style="width: 195px;"><?php echo isset($pan_bsc)? $pan_bsc : 'N/A'?></td>

					<td class="t3val"  style="width: 190px;">
					<p <?php echo (getRemainingDays(isset($pan_bsc_expiry)? $pan_bsc_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($pan_bsc_expiry)? $pan_bsc_expiry : ''?></p></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">= SDSD</td>
					<td class="t3val" style="width: 195px;"><?php echo isset($pan_sdsd)? $pan_sdsd : 'N/A'?></td>

					<td class="t3val"  style="width: 190px;">
					<p <?php echo (getRemainingDays(isset($pan_sdsd_expiry)? $pan_sdsd_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($pan_sdsd_expiry)? $pan_sdsd_expiry : ''?></p></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">= NC I / II</td>
					<td class="t3val" style="width: 195px;"><?php echo isset($pan_nc2)? $pan_nc2 : 'N/A'?></td>

					<td class="t3val"  style="width: 190px;">
					<p <?php echo (getRemainingDays(isset($pan_nc2_expiry)? $pan_nc2_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($pan_nc2_expiry)? $pan_nc2_expiry : ''?></p></td>

				</tr>

			</table>

			<table class="t4" style="text-align: left; margin-top: 10px; border-collapse: collapse;">

				<tr>
					<td class="t3label" style="width: 208px;">PRC / COC</td>
					<td class="t3val" style="width: 195px; "><?php echo isset($prc_coc)? $prc_coc : 'N/A'?></td>
					
					<td class="t3val"  style="width: 195px;">
					<p <?php echo (getRemainingDays(isset($prc_coc_expiry)? $prc_coc_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($prc_coc_expiry)? $prc_coc_expiry : ''?></p></td>

				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">ENDORSEMENT :</td>
					<td class="t3val" colspan = "2" style="width: 390px;"><?php if($division == 'Officers'){echo isset($COE)? $COE : 'N/A';}?></td>
				</tr>

				<tr>
					<td class="t3label t3indent" style="width: 208px;">REGULATION :</td>
					<td class="t3val" colspan = "2" style="width: 390px;"><?php echo isset($prc_coc_remarks)? $prc_coc_remarks : 'N/A'?></td>
				</tr>

			</table>

			<table class="t4" style="text-align: left; margin-top: 10px; border-collapse: collapse;">

				<tr>
					<td class="t3label" style="width: 208px;">GOC</td>
					<td class="t3val"  style="width: 195px;"><?php echo isset($goc)? $goc : 'N/A'?></td>
					<td class="t3val"  style="width: 195px;">
					<p <?php echo (getRemainingDays(isset($goc_expiry)? $goc_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>><?php echo isset($goc_expiry)? $goc_expiry : ''?></p></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">REGULATION :</td>
					<td class="t3val" colspan="2" style="width: 390px;"><?php echo isset($goc_remarks)? $goc_remarks : 'N/A'?></td>
				</tr>

			</table>

			<table class="t4" style="text-align: center; margin-top: 10px; border-collapse: collapse;">

				<tr>
					<td class="t3label" style="width: 208px;">TESDA COC / COP :</td>
					<td class="t3val"  style="width: 195px;"><?php echo isset($tesda_cop)? $tesda_cop : 'N/A'?></td>
					<td class="t3val"  style="width: 195px;">
					<p <?php echo (getRemainingDays(isset($tesda_cop_expiry)? $tesda_cop_expiry : '') <= 90)? 'class="alert-expire"' : '' ?>>
					<?php echo isset($tesda_cop_expiry)? $tesda_cop_expiry : ''?></p></td>
				</tr>
				<tr>
					<td class="t3label t3indent" style="width: 208px;">REGULATION :</td>
					<td class="t3val" colspan="2" style="width: 390px;"><?php echo isset($tesda_cop_remarks)? $tesda_cop_remarks : 'N/A'?></td>
				</tr>

			</table>

		<table  style="text-align: center; width: 40%; margin-top: 20px;">
				<tr>
					<td class="t1label">REMARKS :</td>
				</tr>
		</table>

		<h3 style="text-align: center; color: red;"><?php echo $remarks1 ?></h3>
		<h3 style="text-align: center;"><?php echo $remarks2 ?></h3> <br>


		<p style="margin:0px; margin-top: 5px; border-top: 2px solid black; display: block; width: 25%; text-indent: 20px;">OPERATION STAFF /</p>
		<p style="text-indent: 20px; margin:0px;padding: 0px; ">PANAMA-IN-CHARGE</p>

		</div>
	</div>

</body>
</html>