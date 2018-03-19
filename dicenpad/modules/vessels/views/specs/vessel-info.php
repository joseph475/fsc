<div id="personal-info">
	<div class="row-title">VESSEL INFORMATION</div> 
	<div class="row-details" style="padding-top: 20px;">
		<div id="profile-header">
			<div class="pull-right">
			<?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
			<a class="btn btn-success" href="<?php echo site_url("vessel-entry/"  . _p($about, 'id')); ?>" id="edit-profile-btn"> Edit Profile </a>	
			<?php endif; ?> 
			<a href="<?php echo site_url('vessels-master-list'); ?>" class="btn" >Master List</a>	 
			</div>
			<!-- Profile Header -->
			<img src="<?php echo $thumb_url; ?>" width="106" id="user-photo">
			<h2><?php echo _p($about, 'vessel_name'); ?></h2>
			<h5><span>PRINCIPAL:</span> <?php echo _p($about, 'principal'); ?></h5>
			<h5><span>FLAG:</span> <?php echo _p($about, 'flag'); ?></h5>
			<h5><span>TYPE:</span> <?php echo _p($about, 'vessel_sub_type'); ?></h5>
			<h5><span>MANNING COMPANY:</span> <?= (_p($about, 'company_id') == 1)?  'FAIR SHIPPING CORP': 'CORDIAL SHIPPING INC.'; ?></h5>

			<div class="clearfix"></div>
		</div>

		<div style="margin-bottom: 20px"></div>
				
		<table class="responsive-table" id="options-table-1">
			<tbody>
				<tr>
					<td width="15%"><h5>Builder</h5></td>
					<td width="28%"><?php echo _p($about, 'builder'); ?></td>
					<td width="15%"><h5>Control #</h5></td>
					<td width="15%"><?php echo _p($about, 'control_nos'); ?></td>
					<td width="15%"><h5>Contract Duration</h5></td>
					<td width="20%"><?php echo _p($about, 'duration'); ?></td>
				</tr>
				<tr>
					<td><h5>Built In</h5></td>
					<td><?php echo _p($about, 'builtin'); ?></td>	
					<td><h5>Engine</h5></td>
					<td><?php echo _p($about, 'engine'); ?></td>
					<td><h5>Registered</h5></td>
					<td><?php echo _p($about, 'registered'); ?></td>	
				</tr>
				<tr>
					<td><h5>Manufacturer</h5></td>
					<td><?php echo _p($about, 'manufacturer'); ?></td>	
					<td><h5>Trade Route</h5></td>
					<td><?php echo _p($about, 'trade'); ?></td>
					<td><h5>Year Built</h5></td>
					<td><?php echo _p($about, 'e_year'); ?></td>	
				</tr>
				<tr>
					<td><h5>Gross Ton (MT)</h5></td>
					<td><?php echo _p($about, 'gross'); ?></td>
					<td><h5>Net Ton (MT)</h5></td>
					<td><?php echo _p($about, 'net'); ?></td>
					<td><h5>DWT (MT)</h5></td>
					<td><?php echo _p($about, 'dwt'); ?></td>
				</tr>
				<tr>
					<td><h5>Length (M)</h5></td>
					<td><?php echo _p($about, 'length'); ?></td>
					<td><h5>Depth (M)</h5></td>
					<td><?php echo _p($about, 'depth'); ?></td>
					<td><h5>Breadth (M)</h5></td>
					<td><?php echo _p($about, 'breadth'); ?></td>
				</tr>
				<tr>
					<td><h5>Cylinder</h5></td>
					<td><?php echo _p($about, 'cylinder'); ?></td>
					<td><h5>HP (P.S)</h5></td>
					<td><?php echo _p($about, 'hp'); ?></td>
					<td><h5>Speed (KNOTS)</h5></td>
					<td><?php echo _p($about, 'speed'); ?></td>
				</tr>
				<tr>
					<td><h5>Certificate Nos.</h5></td>
					<td><?php echo _p($about, 'certi_nos'); ?></td>
					<td><h5>Certification Date</h5></td>
					<td><?php echo ($about)? _p($about, 'certi_validity') : ''; ?></td>
					<td><h5>Certification Validity</h5></td>
					<td><?php echo ($about)?  _p($about, 'certi_validity_to'): ''; ?></td>
				</tr>
				<tr>
					<td><h5>Order Nos.</h5></td>
					<td><?php echo _p($about, 'order_nos'); ?></td>
					<td><h5>Accreditation Date</h5></td>
					<td><?php echo ($about)? _p($about, 'order_date') : ''; ?></td>
					<td><h5>CBA</h5></td>
					<td><?php echo _p($about, 'cba'); ?></td>
				</tr>
				<tr>
					<td><h5>Official Nos.</h5></td>
					<td><?php echo _p($about, 'official_nos'); ?></td>
					<td><h5>IMO Nos.</h5></td>
					<td><?php echo _p($about, 'imo_nos'); ?></td>	
					<td><h5>Classification</h5></td>
					<td><?php echo _p($about, 'classification'); ?></td>			
				</tr>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>
