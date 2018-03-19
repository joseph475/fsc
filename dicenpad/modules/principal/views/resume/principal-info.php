<div id="personal-info">
	<div class="row-title">PRINCIPAL INFORMATION</div> 
	<div class="row-details" style="padding-top: 20px;">
		<div id="profile-header">
			<div class="pull-right">
			<?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>		
			<a class="btn btn-success" href="<?php echo site_url("principal-entry/"  . _p($about, 'hash')); ?>" id="edit-profile-btn" > Edit Profile </a>	
			<?php endif; ?>       
			<a href="<?php echo site_url('principal-master-list'); ?>" class="btn" >Master List</a>	 
			</div>

			<!-- Profile Header -->
			<img src="<?php echo $thumb_url; ?>" width="106" id="user-photo">
			<h2><?php echo _p($about, 'fullname'); ?></h2>
			<h5 style="padding-bottom: 5px;"><?php echo _p($about, 'code'); ?></h5>

			<div class="clearfix"></div>
		</div>

		<div style="margin-bottom: 20px"></div>	

		<table class="responsive-table" id="options-table-1">
			<tbody>
				<tr>
					<td width="15%"><h5>Alternate Name</h5></td>
					<td width="55%"><?php echo _p($about, 'alternate'); ?></td>
					<td width="15%"><h5>Status</h5></td>
					<td width="15%"><?php echo _p($about, 'status'); ?></td>
				</tr>
				<tr>
					<td><h5>Address</h5></td>
					<td><?php echo _p($about, 'address'); ?></td>
					<td><h5>SSS Nos</h5></td>
					<td><?php echo _p($about, 'sss'); ?></td>
				</tr>
				<tr>
					<td><h5>Tel Nos.</h5></td>
					<td><?php echo _p($about, 'telno1'); ?> / <?php echo _p($about, 'telno2'); ?> / <?php echo _p($about, 'telno3'); ?></p></td>	
					<td><h5>Telex</h5></td>
					<td><?php echo _p($about, 'telex'); ?></p></td>	
				</tr>
				<tr>
					<td><h5>Fax Nos.</h5></td>
					<td><?php echo _p($about, 'fax1'); ?> / <?php echo _p($about, 'fax2'); ?> / <?php echo _p($about, 'fax3'); ?></p></td>	
					<td><h5>Cable</h5></td>
					<td><?php echo _p($about, 'cable'); ?></p></td>	
				</tr>
				<tr>
					<td><h5>Person In-Charge 1</h5></td>
					<td><?php echo _p($about, 'person1'); ?></td>	
					<td><h5>Tel Nos.</h5></td>
					<td><?php echo _p($about, 'contact1'); ?></p></td>	
				</tr>
				<tr>
					<td><h5>Designation</h5></td>
					<td><?php echo _p($about, 'designate1'); ?></td>	
					<td></td>
					<td></td>	
				</tr>
				<tr>
					<td><h5>Person In-Charge 2</h5></td>
					<td><?php echo _p($about, 'person2'); ?></td>	
					<td><h5>Tel Nos.</h5></td>
					<td><?php echo _p($about, 'contact2'); ?></p></td>	
				</tr>
				<tr>
					<td><h5>Designation</h5></td>
					<td><?php echo _p($about, 'designate2'); ?></td>	
					<td></td>
					<td></td>	
				</tr>
			<tbody>
		</table>
		
		<div class="clearfix"></div>
	</div>
</div>