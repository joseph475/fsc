<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Crew Resume</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body, * {
			font: normal 12px arial,sans-serif;
		}
		p { margin: 0;  }

		@page { margin: 0.5in 0.4in;} 

		.header { text-align: center; }
		.header h4, .header h5 { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.gen_info h4 { text-decoration: underline; }

		table { margin: 0; padding: 0; width: 100%; font-size: 9px; }
		table p { font-size: 9px; }	
		table th { font-weight: bold; text-align: left; }
		table td { padding: 2px 0; vertical-align: middle;  }	/*  border: 1px solid #cecece */
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 6px; padding: 0; text-align: center; }

		.table0 td { vertical-align: top; }
		.table1 td { border: 1px solid #000; font-size: 8px; }
		.table1 span, .table1 thead td, .table1 tbody td { font-size: 9px; } 
		.pic { border: 1px solid #000; width: 1in; height: 1in; }
	</style>
</head>
<body>
	<div class="header">
		<h4>FAIR SHIPPING CORPORATION</h4>
		<h5>Manila, Philippines</h5>
	</div>

	<div class="gen_info">
		<?php 
			$ci =& get_instance();
	        $ci->load->config('dir');
	        $upload_path = base_url() . $ci->config->item('upload_dir');

			$image = base_url() . BASE_IMG . 'user-photo.jpg';
			if($photo <> ''){
				$image = $upload_path . 'media/' . $photo;
			} 
		?>
		<table>
			<tr>
				<td style="vertical-align: bottom;"><h4>GENERAL INFORMATION</h4></td>
				<td style="text-align: right; padding-right: 30px;"><img src="<?php echo $image; ?>" class="pic" /></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 19%;"><p>POSITION APPLIED:</p></td>
				<td style="width: 33%;" class="uline"><p><?php echo _p($about, 'position'); ?></p></td>
				<td style="width: 8%; text-align: center"><p>ALTERNATE:</p></td>
				<td style="width: 40%;" class="uline"><p><?php echo _p($about, 'alternate'); ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 19%;"><p>1. Name of Applicant: </p></td>
				<td style="width: 27%;" class="uline"><p><?php echo _p($about, 'lastname'); ?></p></td>
				<td style="width: 27%;" class="uline"><p><?php echo _p($about, 'firstname'); ?></p></td>
				<td style="width: 27%;" class="uline"><p><?php echo _p($about, 'middlename'); ?></p></td>
			</tr>
			<tr>
				<td class="td_label"></td>
				<td class="td_label">(SURNAME)</td>
				<td class="td_label">(FIRST NAME)</td>
				<td class="td_label">(MIDDLE NAME)</td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 19%;"><p>2. Place of Birth: </p></td>
				<td style="width: 30%;" class="uline"><p><?php echo _p($about, 'birthplace'); ?></p></td>
				<td style="width: 12%; text-align: center;"><p>Date of Birth: </p></td>
				<td style="width: 15%;" class="uline"><p><?php echo date('m/d/Y', strtotime(_p($about, 'birthdate'))); ?></p></td>
				<td style="width: 5%; text-align: center;"><p>Age: </p></td>
				<td style="width: 18%;" class="uline"><p><?php echo _p($about, 'age'); ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 19%;"><p>3. Present Address: </p></td>
				<td style="width: 50%;" class="uline"><p><?php echo _p($about, 'pres_address'); ?></p></td>
				<td style="width: 8%; text-align: center;"><p>Tel No.:</p></td>
				<td style="width: 23%;" class="uline"><p><?php echo _p($about, 'pres_tel'); ?></p></td>
			</tr>
			<tr>
				<td><p>4. Provincial Address: </p></td>
				<td class="uline"><p><?php echo _p($about, 'prov_address'); ?></p></td>
				<td style="text-align: center;"><p>Tel No.:</p></td>
				<td class="uline"><p><?php echo _p($about, 'prov_tel'); ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 19%;"><p>5. Civil Status: </p></td>
				<td style="width: 12%;" class="uline"><p><?php echo _p($about, 'civil_status'); ?></p></td>
				<td style="width: 8%; text-align: center;"><p>SSS No.:</p></td>
				<td style="width: 16%;" class="uline"><p><?php echo _p($about, 'sss_no'); ?></p></td>
				<td style="width: 8%; text-align: center;"><p>TIN No.:</p></td>
				<td style="width: 15%;" class="uline"><p><?php echo _p($about, 'tin_no'); ?></p></td>
				<td style="width: 8%; text-align: center;"><p>Religion:</p></td>
				<td style="width: 14%;" class="uline"><p><?php echo _p($about, 'religion'); ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 19%;"><p>6. Working Clothes Size: </p></td>
				<td style="width: 12%;" class="uline"><p><?php echo _p($about, 'clothe_size'); ?></p></td>
				<td style="width: 16%; text-align: center;"><p>Safety Shoes Size:</p></td>
				<td style="width: 8%;" class="uline"><p><?php echo _p($about, 'shoe_size'); ?></p></td>
				<td style="width: 8%; text-align: center;"><p>Height:</p></td>
				<td style="width: 15%;" class="uline"><p><?php echo _p($about, 'height'); ?></p></td>
				<td style="width: 8%; text-align: center;"><p>Weight:</p></td>
				<td style="width: 14%;" class="uline"><p><?php echo _p($about, 'weight'); ?></p></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 19%;"><p>7. Spouse's Name: </p></td>
				<td style="width: 25%;" class="uline"><p><?php echo _p($about, 'spouse'); ?></p></td>
				<td style="width: 8%; text-align: center;"><p>Address:</p></td>
				<td style="width: 48%;" class="uline"><p><?php echo _p($about, 'spouse_add'); ?></p></td>
			</tr>
			<tr>
				<td><p>7. Father's Name: </p></td>
				<td class="uline"><p><?php echo _p($about, 'father'); ?></p></td>
				<td style="text-align: center;"><p>Address:</p></td>
				<td class="uline"><p><?php echo _p($about, 'father_add'); ?></p></td>
			</tr>
			<tr>
				<td><p>8. Mother's Name: </p></td>
				<td class="uline"><p><?php echo _p($about, 'mother'); ?></p></td>
				<td style="text-align: center;"><p>Address:</p></td>
				<td class="uline"><p><?php echo _p($about, 'mother_add'); ?></p></td>
			</tr>
			<tr>
				<td><p>9. Emergency Contact: </p></td>
				<td class="uline"><p><?php echo _p($about, 'emeg_contact'); ?></p></td>
				<td style="text-align: center;"><p>Address:</p></td>
				<td class="uline"><p><?php echo _p($about, 'emeg_add'); ?></p></td>
			</tr>
			<tr>
				<td></td>
				<td style="font-size: 6px; text-align: center; vertical-align: top;"> (NAME) </td>
				<td style="text-align: center;"><p>Tel No.:</p></td>
				<td class="uline"><p><?php echo _p($about, 'emeg_tel'); ?></div></td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 19%;"><p>11. Benficiary: </p></td>
				<td style="width: 27%;" class="uline"><p><?php echo _p($about, 'benef_lname'); ?></p></td>
				<td style="width: 27%;" class="uline"><p><?php echo _p($about, 'benef_fname'); ?></p></td>
				<td style="width: 27%;" class="uline"><p><?php echo _p($about, 'benef_mname'); ?></p></td>
			</tr>
			<tr>
				<td class="td_label"></td>
				<td class="td_label">(SURNAME)</td>
				<td class="td_label">(FIRST NAME)</td>
				<td class="td_label">(MIDDLE NAME)</td>
			</tr>
		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 19%;"><p>Relationship to Seafarer: </p></td>
				<td style="width: 30%;" class="uline"><p><?php echo _p($about, 'benef_relation'); ?></p></td>
				<td style="width: 8%; text-align: center;"><p>Address:</p></td>
				<td style="width: 43%;" class="uline"><p><?php echo _p($about, 'benef_add'); ?></p></td>
			</tr>
		</table>
	</div>

	<div class="child_info">
		<table style="width: 100%;">
			<tr>
				<td><p>12. Children's Name: </p></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td style="width: 33%; text-align: center"><p>NAME</p></td>
				<td style="width: 25%; text-align: center"><p>DATE OF BIRTH</p></td>
				<td style="width: 35%; text-align: center"><p>ADDRESS</p></td>
			</tr>
			<?php 
			if($children):
				foreach ($children as $value): 
			?>
				<tr>
					<td style="text-align: center;" class="uline"><p><?php echo $value->child_name; ?></p></td>
					<td style="text-align: center;" class="uline"><p><?php echo date('m/d/Y', strtotime($value->child_birthdate)); ?></p></td>
					<td style="text-align: center;" class="uline"><p><?php echo $value->child_address; ?></p></td>
				</tr>
			<?php 
				endforeach;
			endif; 
			?>
		</table>
	</div>

	<div class="educ_info">

		<table class="table0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="4"><p>12. Educational Attainment: </p></td>
			</tr>
			<tr>
				<td style="width: 20%; text-align: center"><p>YEAR (Start - End)</p></td>
				<td style="width: 30%; text-align: center"><p>SCHOOL</p></td>
				<td style="width: 25%; text-align: center"><p>Course Finished</p></td>
				<td style="width: 25%; text-align: center"><p>Special Course</p></td>
			</tr>
			<?php 
			if($education):
				foreach ($education as $value): 
			?>
			<tr>
				<td style="text-align: center;" class="uline"><p><?php echo $value->year; ?></p></td>
				<td style="text-align: center;" class="uline"><p><?php echo $value->school; ?></p></td>
				<td style="text-align: center;" class="uline"><p><?php echo $value->course; ?></p></td>
				<td style="text-align: center;" class="uline"><p><?php echo $value->vocational; ?></p></td>
			</tr>
			<?php 
				endforeach;
			endif; 
			?>
		</table>
	</div>

	<?php if($docs): ?>
	<div class="document_info">

		<table style="width: 100%; font-size: 10px;" cellspacing="5">
			<tr>
				<th colspan="5" style="text-decoration: underline;">13. CREW DOCUMENTS: </th>
			</tr>
			<tr>
				<td style="width: 42%; "><p>DESCRIPTION</p></td>
				<td style="width: 15%; text-align: center"><p>Number</p></td>
				<td style="width: 12%; text-align: center"><p>Date Issued</p></td>
				<td style="width: 12%; text-align: center"><p>Expiry Date</p></td>
				<td style="width: 19%; text-align: center"><p>Remarks</p></td>
			</tr>
		</table>
		<?php foreach ($docs as $value): ?>
		<table style="width: 100%; font-size: 10px;">
			<tr>
				<td style="width: 42%;"><p><?php echo $value->document; ?></p></td>
				<td style="width: 15%; " class="uline"><p style="padding: 0 3px;"><?php echo $value->docs_nos; ?></p></td>
				<td style="width: 12%; text-align: center;" class="uline"><p><?php echo date('m/d/Y', strtotime($value->date_issued)); ?></p></td>
				<td style="width: 12%; text-align: center;" class="uline"><p><?php echo date('m/d/Y', strtotime($value->date_expired)); ?></p></td>
				<td style="width: 19%" class="uline"><p style="padding: 0 3px;"><?php echo $value->remarks; ?></p></td>
			</tr>
		</table>
		<?php endforeach; ?>
		
	</div>
	<?php endif; ?>

	<?php if($works): ?>
	<div class="work_info">

		<table class="table1" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th colspan="10" style="text-decoration: underline; padding: 5px 0;">14. WORK HISTORY: </th>
				</tr>
				<tr>
					<td style="width: 20%; "><span style="margin: 0 3px;">Company</span></td>
					<td style="width: 21%; "><span style="margin: 0 3px;">Vessel</span></td>
					<td style="width: 7%; text-align: center">Rank</td>
					<td style="width: 5%; text-align: center">GRT</td>
					<td style="width: 5%; text-align: center">Type</td>
					<td style="width: 8%; text-align: center">Engine</td>
					<td style="width: 12%;"><span style="margin: 0 3px;">Trade</span></td>
					<td style="width: 6%; text-align: center">Embarkation</td>
					<td style="width: 6%; text-align: center">Disembarkation</td>
					<td style="width: 10%; "><span style="margin: 0 3px;">Remarks</span></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($works as $value): ?>
				<tr>
					<td><span style="margin: 0 3px;"><?php echo $value->company; ?></span></td>
					<td><span style="margin: 0 3px;"><?php echo $value->vessel; ?></span></td>
					<td style="text-align: center;"><?php echo $value->rank; ?></td>
					<td style="text-align: center;"><?php echo $value->grt; ?></td>
					<td style="text-align: center;"><?php echo $value->type;?></td>
					<td style="text-align: center;"><?php echo $value->engine;?></td>
					<td><span style="margin: 0 3px;"><?php echo $value->trade; ?></span></td>
					<td style="text-align: center;"><?php echo date('m/d/Y', strtotime($value->embarked)); ?></td>
					<td style="text-align: center;"><?php echo date('m/d/Y', strtotime($value->disembarked)); ?></td>
					<td><span style="margin: 0 3px;"><?php echo $value->remarks; ?></span></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		
	</div>
	<?php endif; ?>
</body>
</html>