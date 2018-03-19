<div id="personal-info">
	<div class="row-title">AGENT INFORMATION</div> 
	<div class="row-details" style="padding-top: 20px;">
		
		<div class="pull-right">
		<?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
		<a class="btn btn-success" href="<?php echo site_url("agent-entry/"  . _p($about, 'hash')); ?>" id="edit-profile-btn" > Edit Profile </a>	
		<?php endif; ?>   
		<a href="<?php echo site_url("agent-master-list"); ?>" class="btn" >Master List</a>      
		</div>
		<div class="clearfix" style="margin-bottom: 20px"></div>	

		<table class="responsive-table" id="options-table-1">
			<tbody>
				<tr>
					<td width="15%"><h5>Name</h5></td>
					<td width="55%"><?php echo _p($about, 'name'); ?></td>
					<td width="15%"><h5>Status</h5></td>
					<td width="15%"><?php echo _p($about, 'status'); ?></td>
				</tr>
				<tr>
					<td><h5>Principal</h5></td>
					<td><?php echo _p($about, 'principal'); ?></td>
					<td><h5>Email</h5></td>
					<td><?php echo _p($about, 'email'); ?></td>
				</tr>
				<tr>
					<td><h5>Address</h5></td>
					<td><?php echo _p($about, 'address'); ?></td>
					<td><h5>Port</h5></td>
					<td><?php echo _p($about, 'port'); ?></td>
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
					<td><h5>Person In-Charge</h5></td>
					<td><?php echo _p($about, 'incharge'); ?></td>	
					<td><h5>Tel Nos.</h5></td>
					<td><?php echo _p($about, 'contact'); ?></p></td>	
				</tr>
				<tr>
					<td><h5>Designation</h5></td>
					<td><?php echo _p($about, 'designate'); ?></td>	
					<td></td>
					<td></td>	
				</tr>
			<tbody>
		</table>
		
		<div class="clearfix"></div>
	</div>
</div>