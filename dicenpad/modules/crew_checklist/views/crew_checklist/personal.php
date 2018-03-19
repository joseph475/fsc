<div id="personal-info">
	<div class="row-title">CREW INFORMATION</div> 
	<div class="row-details" style="padding-top: 20px;">
		<div id="profile-header">

			<div class="pull-right">
				<?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
	                <div class="btn-group pull-left" style="margin-right: 5px;">

	                    <a id="edit-profile-btn" href="#" class="btn"> Export Checklist </a>
	                    <a href="#" data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></a>
	                    <ul class="dropdown-menu">
	                        <li>
	                            <?php echo form_open('checklist/grid-type', 'class="form1D" target="_blank"'); ?>                    
				                <input type="hidden" name="crew_id" id="crew_id" value="<?php echo $crew_id; ?>">
				                <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
				                <input type="hidden" name="type_id" id="type_id" value="<?php echo $type_id; ?>">
				                <input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
				                <button type="submit" id="minifest"><i class="icon-pdf"></i> Grid Type</button> 
				                <?php echo form_close(); ?>  
	                        </li>
	                        <li>
	                            <?php echo form_open('checklist/list-type', 'class="form1D" target="_blank"'); ?>                    
				                <input type="hidden" name="crew_id" id="crew_id" value="<?php echo $crew_id; ?>">
				                <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
				                <input type="hidden" name="type_id" id="type_id" value="<?php echo $type_id; ?>">
				                <input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
				                <button type="submit" id="minifest"><i class="icon-pdf"></i> List Type</button> 
				                <?php echo form_close(); ?>   
	                        </li>
	                    </ul>            
	                </div>   
	            <?php endif; ?>         
           
	           	<div class="pull-right" style="margin-right: 3px;">
	                <a class="btn record-set" rel="tooltip" title="Set" 
	                href="javascript:void(0);" data-toggle="modal">
	                    <i class="icon-plus"></i>Signatory
	                </a>
	            </div>      
			</div>

			<!-- Profile Header -->
			<img src="<?php echo $thumb_url; ?>" width="106" id="user-photo">
			<a href="<?php echo site_url("resume/{$hash}"); ?>"><h2><?php echo $fullname ?></h2></a>
			<h5>Position: <?php echo $position ?></h5>
			<h5>Vessel: <?php echo $vessel_name ?></h5>
			<h5>Flag: <?php echo $flag ?></h5>
			<div class="clearfix"></div>		
		</div>

		<div class="clearfix"></div>

		<div style="margin-bottom: 20px"></div>	

		<table class="responsive-table" id="options-table">
			<tbody>
				<tr>
					<td width="15%"><h5>Department</h5></td>
					<td width="55%"><?php echo $department ?></td>
					<td width="15%"><h5>Division</h5></td>
					<td width="15%"><?php echo $division ?></td>
				</tr>
				<tr>
					<td><h5>Status</h5></td>
					<td><?php echo $status ?></td>
					<td><h5>Date of Hired</h5></td>
					<td><?php echo date('m/d/Y', strtotime($date_hired)); ?></td>
				</tr>
			<tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>
