<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FSC Crew Management System - Checklist List Type</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dicen, Jomel P.">
	<style type="text/css">
		body {
			font: normal 12px Arial,Georgia,Serif; 
		}

		.header { margin-bottom: 15px; text-transform: uppercase; }
		.header h1, .header h3 { margin: 0; }

		.clear { clear: both; }

		table { margin: 0; padding: 0; width: 100%; }	
		span.sort { width: 10px; } 

		ul li { padding: 0; margin: 0; list-style: none; }
	</style>
</head>
<body>
	<p style="font-size: 10px;"><?php 
		if ($company_id == 1) {
			echo select_iso(17); 
		}
	?></p>
	<div class="header">
		<h2>CREW DOCUMENTS: <?php echo isset($vessel_name)? $vessel_name : ''; ?></h2>

		<h3><?php echo isset($code)? $code : ''; ?> <?php echo isset($fullname)? $fullname : ''; ?></h3>
	</div>

	<div class="gen_info">
		<?php 
		if($data){
			$sortorder = '';
			$style = '';
			echo "<table>";
			foreach ($data as $value){				
				$suborder = ($value->sub_order != '')? $value->sub_order . '. ' : '';
				if($sortorder == $value->sort_order){ 
					$sortorder = '';
					$style = "style='padding-left: 14px;'";
				} else {
					$sortorder = $value->sort_order . '.';
					$style = '';
				}
				echo "<tr>";
				echo "<td width='3%'>{$sortorder}</td>";
				echo "<td>{$suborder} {$value->document}</td>";
				echo "</tr>";
				$sortorder = $value->sort_order . '.';
			}
			echo "</table>";
		}
		?>

		<p>This is to certify that I have checked and confirmed that all my documents are in good order.</p>
		<table cellpadding="0" cellspacing="0" style="margin: 5px 0;">
			<tr>
				<td style="width: 57%;"></td>
				<td style="width: 18%;">ACKNOWLEDGE BY: </td>
				<td style="width: 25%; border-bottom: 1px solid #000;"></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td style="text-align: center; ">Signature &amp; Date</td>
			</tr>
		</table>

	</div>
</body>
</html>