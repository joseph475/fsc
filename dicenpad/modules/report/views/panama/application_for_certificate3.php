
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Application For Certificate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="MJRC">
	<style type="text/css">
		body {
			font-size: 12px; 
			font-family: sans-serif;
		}

		@page { margin: 0.0in 0.5in 0.0in 0.5in;}

		.clearfix { clear: both; }

		.header { text-align: center; margin-bottom: 30px; }
		.header h4 { font-weight: bold; font-size: 13px; text-indent: 4px;}
		.header h4, .header h5 { margin: 0; }
		.header h5{ font-size: 14px; font-weight: normal;}

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.gen_info h4 { text-decoration: underline; }

		.panamalogo{display: block; position: relative; top: 45px; left:35px;}
		.prof_pic{display: block; position: relative; left: 60px; border:1px solid gray;}

		table { margin: 0; padding: 0; width: 100%; border-collapse: collapse;}	
		table th, table td { border: 1px solid #000; text-align: center;  vertical-align: top; }
		table td p { margin: 0; padding: 0 1px; }
		table td { padding: 0.5px 0; vertical-align: top;  }	/*  border: 1px solid #cecece */
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 12px; padding: 0; text-align: center; }

		.square { border: 1px solid #000; width: 7px; height: 7px; display: inline-block; margin-top:3px; }
		span.f1{font-weight: lighter;}

		 td.checkboxes{padding: 5px; font-size: 7.5px;}

		
		 td p{display: inline-block; padding:0px ;margin: 0px;}
		 span.phaha{display: inline-block;}
		.acenter { text-align: center; }

		.phehe{text-align: left; text-indent: 2px; font-size: 11px; padding-top: 3px; padding-bottom: 3px;}
	</style>

				<?php

					$array = array();
					

					if($chk_202 != ''){$array[] = $chk_202;}
					if($chk_203 != ''){$array[] = $chk_203;}
					if($chk_204 != ''){$array[] = $chk_204;}
					if($chk_205 != ''){$array[] = $chk_205;}
					if($chk_207 != ''){$array[] = $chk_207;}
					if($chk_208 != ''){$array[] = $chk_208;}
					if($chk_209 != ''){$array[] = $chk_209;}
					if($chk_212 != ''){$array[] = $chk_212;}
					if($chk_235 != ''){$array[] = $chk_235;}

					if($type1 != ''){$type_1 = $type1;}
					if($type2 != ''){$type_2 = $type2;}
					if($type3 != ''){$type_3 = $type3;}
					if($type4 != ''){$type_4 = $type4;}



				?>

</head>
<body>
	<img class ="panamalogo" src="<?php echo base_url() .  BASE_IMG . 'panamalogo.jpg'; ?>" width="70" />
	<div class="header">
		
		<h4>APPLICATION FOR CERTIFITCATES AND ENDORSEMENTS FOR SEAFARERS</h4>
		<h5>SOLICITUD DE TITULOS Y REFRENDOS PARA LA GENTE DE MAR</h5>
	</div>

	<div class="gen_info" style="position: relative; top: -15px;">
			<table style="width: 90%; " align="center" >

			<!-- Type of Application -->

			<tr align="center">
				<td colspan="4" style="font-size: 14px; padding: 7px;"><p><span style="font-weight: bold;">TYPE OF APPLICATION</span> - TIPO DE APLICACION </p>
				</td>
			</tr>	

			<!-- Checkboxes -->

			<tr align="center">
				<td colspan="1" class="checkboxes" style="width: 18%;"><img src="<?php echo isset($type_1)? base_url() .  BASE_IMG . 'checked2.png' : base_url() .  BASE_IMG . 'unchecked2.png' ?>"  style="display: block; position: relative; left: -5px;">CERTIFICATE - <span class = "f1">TITULO</span></td>
				<td colspan="1" class="checkboxes" style="width: 30%;"><img src="<?php echo isset($type_2)? base_url() .  BASE_IMG . 'checked2.png' : base_url() .  BASE_IMG . 'unchecked2.png' ?>"  style="display: block; position: relative; left: -5px;">CERTIFICATE ENDORSEMENT - <span class = "f1">REFRENDO</span></td>
				<td colspan="1" class="checkboxes" style="width: 32%;"><img src="<?php echo isset($type_3)? base_url() .  BASE_IMG . 'checked2.png' : base_url() .  BASE_IMG . 'unchecked2.png' ?>"  style="display: block; position: relative; left: -5px;">COURSE ENDORSEMENT - <span class = "f1">ENDOSO DE CURSO</span></td>
				<td colspan="1"	class="checkboxes" style="width: 20%;"><img src="<?php echo isset($type_4)? base_url() .  BASE_IMG . 'checked2.png' : base_url() .  BASE_IMG . 'unchecked2.png' ?>"  style="display: block; position: relative; left: -5px;">DUPLICATE - <span class = "f1">DUPLICADO</span></td>
			</tr>	

			<!-- APPLICANT 	INFORMATION - DATOS DEL SOLICITANTE --> 

			<tr align="center">
				<td colspan="4" style="font-size: 14px; padding: 4px;"><p><span style="font-weight: bold;">APPLICANT INFORMATION</span> - DATOS DEL SOLICITANTE </p>
				</td>
			</tr>	

			<!-- Given Name and Surname --> 

			<tr>
				<td  colspan="2">
					<p style="font-size: 8px; padding: 0px; text-align:left; padding-left: 5px;"><span style="font-weight: bold; padding: 0px; margin: 0px;">GIVEN NAME</span> - NOMBRE</p><br>
					<p style="font-size: 15px; padding: 0px; text-align:left; padding-left: 5px;"><?php echo $firstname ?></p>
				</td>

				<td  colspan="2">
					<p style="font-size: 8px; padding: 0px; text-align:left; padding-left: 5px;"><span style="font-weight: bold; padding: 0px; margin: 0px;">SURNAME</span> - APELLIDO</p><br>
					<p style="font-size: 15px; padding: 0px; text-align:left; padding-left: 5px;"><?php echo $lastname ?></p>
				</td>
			</tr>

			<!-- Passport and Nationality --> 

			<tr>
				<?php 
					if($docs):

					$docs_id = array(3);

					foreach ($docs as $value): 	

					$pass = ($value->docs_nos)? $value->docs_nos : '';
					if (in_array($value->docs_id, $docs_id)):

				?>

				<td  colspan="2">
					<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">PASSPORT N<sup>0</sup></span> - N<sup>0</sup> DE PASAPORTE</p><br>
					<p style="font-size: 15px; text-align:left; padding-left: 5px;"><?php echo $pass; ?></p>
				</td>

				<?php
					endif;	
				  	endforeach;
					endif;
				?>

				<td  colspan="2">
					<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">NATIONALITY</span> - NACIONALIDAD</p><br>
					<p style="font-size: 15px; text-align:left; padding-left: 5px;">FILIPINO</p>
				</td>

			</tr>

			</table>

			<!-- Country of Birth And Date Of Birth --> 

			<table style="width: 90%; " align="center">

				<tr>
					<td style="width: 65%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">COUNTRY OF BIRTH</span> - PAIS DE NACIMIENTO</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;">PHILIPPINES</p>
					</td>

					<td style="width: 35%">
						<table style="font-size: 8px; ">
							<tr >
								<td colspan="3" style="border-top: 0px; border-left: 0px; border-right: 0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">DATE OF BIRTH</span> - FECHA DE NACIMIENTO</p>
								</td>
							</tr>
							<tr>
								<?php $dates = date_create($birthdate);?>
								<td style="border-top: 0px; border-left: 0px;">
									<?php
									 	echo date_format($dates,"d");
									 ?>
								</td>
								<td style="border-top: 0px; border-left: 0px;">
									<?php
									 	echo date_format($dates,"M");
									 ?>
								</td>
								<td style="border-top: 0px; border-left: 0px; border-right: 0px;">
									<?php
									 	echo date_format($dates,"Y");
									 ?>
								</td>

							</tr>
							<tr>
								<td style="border:0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">DAY</span> - DIA</p>
								</td>
								<td style="border:0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">MONTH</span> - MES</p>
								</td>
								<td style="border:0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">YEAR</span> - ANO</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			<!-- Address and telephone number --> 

			<table style="width: 90%; " align="center">

				<tr>
					<td style="width: 65%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">ADDRESS</span> - DIRECCION</p><br>
						<p style="font-size: 12px; text-align:left; padding-left: 5px;"><?php echo $pres_address ?></p>
					</td>

					<td style="width: 35%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">PHONE</span> - TELEFONO</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;"><?php echo $pres_tel ?></p>
					</td>
				</tr>
			</table>

			<!-- Delivery place --> 

			<table style="width: 90%; " align="center">
				<tr>
					<td  colspan="2" style="width: 48%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">DELIVERY PLACE / CONSULATE</span> - LUGAR DE ENTREGA / CONSULADO</p><br>
						<p style="font-size: 13px; text-align:left; padding-left: 5px;">PANAMA EMBASSY-MAKATI / CONSULATE</p></p>
					</td>

					<td  colspan="2" style="width: 52%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">EMAIL</span> - CORREO ELECTRONICO</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;"><?php echo $email ?></p>
					</td>
				</tr>
			</table>

			<!-- Capacity --> 

			<table style="width: 90%; " align="center">
				<tr>
					<td  colspan="4">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">CAPACITY</span> - GRADO SOLICITADO</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;"><?php echo $pos2 ?></p>
					</td>
				</tr>
			</table>

			<!-- Actual Occupation --> 

			<table style="width: 90%; " align="center">
				<tr>
					<td  colspan="2" style="width: 48%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">ACTUAL OCCUPATION</span> - OCUPACION ACTUAL</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;"><?php echo $pos2 ?></p>
					</td>

					<td  colspan="2" style="width: 52%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">NAME OF THE SHIP</span> - NOMBRE DE BUQUE</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;"><?php echo $vessel_name ?></p>
					</td>
				</tr>
			</table>

			<!-- Endorsements Requested --> 

			<table style="width: 90%; " align="center">
				<tr>
					<td  colspan="4">
						<p style="font-size: 15px; text-align:center; padding: 4px"><span style="font-weight: bold;">ENDORSEMENTS REQUESTED</span> - ENDOSOS A SOLICITAR</p><br>
					</td>
				</tr>
			
				<!-- 1 --> 
				<tr>
					<td  colspan="2" style="width: 48%">
						<p class = "phehe"> 1. <?php echo isset($array[0])? $array[0] : '-' ; ?></p>
					</td>

					<td  colspan="2" style="width: 52%">
						<p class = "phehe"> 5. <?php echo isset($array[4])? $array[4] : '-' ; ?></p>
					</td>
				</tr>

				<!-- 2 --> 
				<tr>
					<td  colspan="2" style="width: 48%">
						<p class = "phehe"> 2. <?php echo isset($array[1])? $array[1] : '-' ; ?></p>
					</td>

					<td  colspan="2" style="width: 52%">
						<p class = "phehe"> 6. <?php echo isset($array[5])? $array[5] : '-' ; ?></p>
					    
					</td>
				</tr>

				<!-- 3 --> 
				<tr>
					<td  colspan="2" style="width: 48%">
						<p class = "phehe"> 3. <?php echo isset($array[2])? $array[2] : '-' ; ?></p>
					</td>

					<td  colspan="2" style="width: 52%">
						<p class = "phehe"> 7. <?php echo isset($array[6])? $array[6] : '-' ; ?></p>
					</td>
				</tr>

				<!-- 4 --> 

				<tr>
					<td  colspan="2" style="width: 48%">
						<p class = "phehe"> 4. <?php echo isset($array[3])? $array[3] : '-' ; ?></p>
					</td>

					<td  colspan="2" style="width: 52%">
						<p class = "phehe"> 8. <?php echo isset($array[7])? $array[7] : '-' ; ?></p>
					</td>
				</tr>

			</table>

			<!-- DETAILS OF BROKER --> 

			<table style="width: 90%; " align="center">
				<tr>
					<td  colspan="4">
						<p style="font-size: 15px; text-align:center; padding: 4px"><span style="font-weight: bold;">DETAILS OF BROKER</span> - DATOS DEL TRAMITADOR</p><br>
					</td>
				</tr>
			</table>	

			<!-- COMPANY NAME --> 

			<table style="width: 90%; " align="center">
				<tr>
					<td  colspan="4">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">COMPANY NAME</span> - NOMBRE DE COMPANIA</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;">FAIR SHIPPING CORPORATION</p>
					</td>
				</tr>
			</table>

			<!-- GIVEN NAME AND SURNAME --> 

			<table style="width: 90%; " align="center">
				<tr>
					<td  colspan="2" style="width: 48%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">GIVEN NAME</span> - NOMBRE</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;">JENNY LEE</p>
					</td>

					<td  colspan="2" style="width: 52%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">SURNAME</span> - APELLIDO</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;">BALAHAY</p>
					</td>
				</tr>

				<tr>
					<td  colspan="2">
					<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">PASSPORT N<sup>0</sup></span> - N<sup>0</sup> DE PASAPORTE</p><br>
					<p style="font-size: 15px; text-align:left; padding-left: 5px;">EC6289602</p>
				</td>

					<td  colspan="2" style="width: 52%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">NATIONALITY</span> - NACIONALIDAD</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;">FILIPINO</p>
					</td>
				</tr>
			</table>

			<!-- Country of Birth And Date Of Birth --> 

			<table style="width: 90%; " align="center">

				<tr>
					<td style="width: 65%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">COUNTRY OF BIRTH</span> - PAIS DE NACIMIENTO</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;">PHILIPPINES</p>
					</td>

					<td style="width: 35%">
						<table style="font-size: 8px; ">
							<tr >
								<td colspan="3" style="border-top: 0px; border-left: 0px; border-right: 0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">DATE OF BIRTH</span> - FECHA DE NACIMIENTO</p>
								</td>
							</tr>
							<tr>
								
								<td style="border-top: 0px; border-left: 0px;">
									<?php
									 echo "05";
									 ?>
								</td>
								<td style="border-top: 0px; border-left: 0px;">
									<?php
									 	echo "JAN";
									 ?>
								</td>
								<td style="border-top: 0px; border-left: 0px; border-right: 0px;">
									<?php
									 	echo "1985";
									 ?>
								</td>

							</tr>
							<tr>
								<td style="border:0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">DAY</span> - DIA</p>
								</td>
								<td style="border:0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">MONTH</span> - MES</p>
								</td>
								<td style="border:0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">YEAR</span> - ANO</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

			<!-- COMPANY ADDRESS--> 

			<table style="width: 90%; " align="center">

				<tr>
					<td style="width: 65%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">COMPANY ADDRESS</span> - DIRECCION DE COMPANIA</p><br>
						<p style="font-size: 14px; text-align:left; padding-left: 5px;">2079 MADRE IGNACIA ST., MALATE MANILA, PHILIPPPINES</p>
					</td>

					<td style="width: 35%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">COMPANY PHONE</span> - TELEFONO DE COMPANIA</p><br>
						<p style="font-size: 15px; text-align:left; padding-left: 5px;">+63-2-526-0636</p>
					</td>
				</tr>
			</table>

			<!-- COMPANY EMAIL--> 

			<table style="width: 90%; " align="center">

				<tr>
					<td style="width: 65%">
						<p style="font-size: 8px; text-align:left; padding-left: 5px;"><span style="font-weight: bold;">COMPANY E-MAIL</span> - CORREO ELECTRONICO DE COMPANIA</p><br>
						<p style="font-size: 14px; text-align:left; padding-left: 5px;">FAIRSHIP@FAIRSHIP.COM.PH</p>
					</td>

					<td style="width: 35%">
						<table style="font-size: 8px; ">
							<tr >
								<td colspan="3" style="border-top: 0px; border-left: 0px; border-right: 0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">DATE OF BIRTH</span> - FECHA DE NACIMIENTO</p>
								</td>
							</tr>
							<tr>
								<?php $dates = date_create($date);?>
								<td style="border-top: 0px; border-left: 0px;">
									<?php
									 	echo date_format($dates,"d");
									 ?>
								</td>
								<td style="border-top: 0px; border-left: 0px;">
									<?php
									 	echo date_format($dates,"M");
									 ?>
								</td>
								<td style="border-top: 0px; border-left: 0px; border-right: 0px;">
									<?php
									 	echo date_format($dates,"Y");
									 ?>
								</td>

							</tr>
							<tr>
								<td style="border:0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">DAY</span> - DIA</p>
								</td>
								<td style="border:0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">MONTH</span> - MES</p>
								</td>
								<td style="border:0px;">
									<p style="font-size: 8px; padding-left: 5px;"><span style="font-weight: bold;">YEAR</span> - ANO</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

			<img src="<?php echo  base_url() .  BASE_IMG . 'tri1.PNG' ?>" style="display: block; position: relative; left:35px; top:10px;">
			

			<div class="sig_and_pics" style="width: 90%; margin: auto;">
				<div class= "sig" style="width: 60%; height:  250px; display: inline-block;">
					<h5 style="display: block; text-align: center; padding-top:10px;">SIGNATURE - <span style="font-weight: lighter;">FIRMA</span></h5>
					<img src="<?php echo  base_url() .  BASE_IMG . 'sigbor.png' ?>"  width="320px" height="110px" style="display: block; position: relative; top:10px; left:35px;">
				</div>

				<div class = "pic" align="center" style="width: 40%; height: 250px; display: inline-block;">
					<h5 style="display: block; text-align: center; padding-top:10px;">PHOTO - <span style="font-weight: lighter;">FOTOGRAFIA</span></h5>
				</div>
			</div>

			<img src="<?php echo  base_url() .  BASE_IMG . 'tri2.png' ?>" style="display: block; position: relative; left:642px;"> 

	</div>

</body>
</html>