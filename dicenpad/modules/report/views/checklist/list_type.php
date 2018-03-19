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
			font-size: 12px; 
		}
		

		.header { text-align: center; margin-bottom: 30px; }
		.header h4, .header h5, .header p { margin: 0; }

		.clear { clear: both; }
		p.inline_p { display: inline; }
		p.has_pad { padding-right: 15px;  }
		.gen_info h4 { text-decoration: underline; }

		table { margin: 0; padding: 0; }	
		table th { text-align: left; }
		table td { padding: 2px 0; vertical-align: middle;  }	/*  border: 1px solid #cecece */
		table td p { margin: 0; }
		table td.uline { border-bottom: 1px solid #000; }
		table td.td_label { font-size: 12px; padding: 0; text-align: center; }

		ol li { padding: 0 0 15px 0; }
	</style>
</head>
<body>
	<p style="font-size: 10px;"><?php echo select_iso(17); ?></p>
	<div class="header">
		<h4>CREW DOCUMENT CHECKLIST</h4>
		<h5>DECK DEPARTMENT</h5>
		<p>for All Types of Ship</p>
	</div>

	<div class="gen_info">
		<table class="table2" cellpadding="0" cellspacing="0">
			<tbody>
				<?php 
				$counter = 0;

				if($d102):
					echo "<tr><th style='width: 30%; '>DOCUMENTS and CERTIFICATE</th></tr>";
					foreach ($d102 as $key):
						$counter++;
						echo "<tr><td>$counter {$key->document}</td></tr>";
					endforeach;
				endif;
				?>
			</tbody>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tbody>
				<?php 

				if($d102):
					echo "<tr><th style='width: 30%'>FOR TANKER VESSEL ONLY</th></tr>";
					foreach ($d122 as $key):
						$counter++;
						echo "<tr><td>$counter {$key->document}</td></tr>";
					endforeach;
				endif;
				?>
			</tbody>
		</table>

		<table class="table2" cellpadding="0" cellspacing="0">
			<tbody>
				<?php 

				if($d102):
					echo "<tr><th style='width: 30%'>PRC Requirements (as available)</th></tr>";
					foreach ($d121 as $key):
						$counter++;
						echo "<tr><td>$counter {$key->document}</td></tr>";
					endforeach;
				endif;
				?>
			</tbody>
		</table>
	</div>
</body>
</html>