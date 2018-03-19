<div class="accordion-group row-section"> 
		
	<?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#personal-info"><?php endif; ?>
		<div class="row-title">	CREW PERSONAL INFORMATION <span class='pull-right'><?php echo ($crew_id)? 'Crew ID: ' . $crew_id : ''; ?></span></div> 
	<?php if($crew_id): ?></a><?php endif; ?>	
		
	
	<div id="personal-info" class="accordion-body collapse in">

		<div class="row-details" id="fileupload">
			<div id="alert0-div"></div>
			
			<div id="profile-header">

				<div id="profile-section1">
					<!-- Profile Header -->
					<div class="span2 imgdiv">
						<img src="<?php echo $pics_url;?>" class="thumbnail">
					</div>
					<div class="span4" style="vertical-align:top">
						<h2><?php echo isset($fullname)? $fullname : '' ?></h2>
						<h4 style="padding-bottom: 5px;"><?php echo isset($position)? $position : '' ?></h4>
					</div>
				</div>

				<div id="profile-section2">
					<div class="pull-right">
						<?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
							<button id="save-btn" class="btn btn-primary" >Save</button>	
						<?php endif; ?>
						<?php if($hash): ?>
							<a href="<?php echo site_url("resume/$hash"); ?>" class="btn"  >View Resume</a>
						<?php endif; ?>
						<a href="<?php echo site_url('crew-master-list'); ?>" class="btn" >Cancel</a>
					</div>
					<form enctype="multipart/form-data" method="post" action="<?php echo site_url('upload/upload_img');?>">
						<div class="span2 imgdiv">
							<div id="profile-img-container">
								<img src="<?php echo $pics_url ?>" class="thumbnail" id="profile-img-default">
							</div>
							<div class="progress progress-striped hidden" id="upload-progress-container"> 
								<div class="bar" id="upload-progress"></div>
							</div>
							<div id="photo-message"></div>
						</div>
						
						<?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
						<div class="span4" style="vertical-align:top">
							<p><small>The image needs to be at least 105 pixels wide or 105 pixels tall.</small></p>
							<span class="btn fileinput-button">
								<i class="icon-plus icon-black"></i>
								<span>Select file...</span>
								<input type="file" name="userfile">
							</span>
						</div>
						<?php endif; ?>
					</form>
				</div>

				<div class="clearfix"></div>
			</div>

			<div style="margin-bottom: 20px"></div>

			<form id='form-modal'>
				<table class="responsive-table" id="options-table-1">
					<tbody>
						<tr>
							<td><h5>Payroll ID</h5></td>
							<td>
								<input type="text" class="ab" id="inputpayroll" placeholder="Payroll ID" style="width:47%;" value="<?php echo $payroll_id ?>" name="payroll_id"/>
							</td>
							<td><h5>Profit Plus ID</h5></td>
							<td colspan="3">
								<input type="text" class="ab" id="inputprofit" placeholder="Profit Plus ID" style="width:47%;" value="<?php echo $profit_id; ?>" name="profit_id"/>
							</td>
						</tr>
						<tr>
							<td width="16%"><h5>Name</h5></td>
							<td colspan="5">
								<input type="text" class="ab validate[required]" id="inputlast" placeholder="Last Name" style="width:32%;" value="<?php echo $lastname ?>" name="lastname"/>
								<input type="text" class="ab validate[required]" id="inputfirst" placeholder="First Name" style="width:32%;" value="<?php echo $firstname; ?>" name="firstname"/>
								<input type="text" class="ab" id="inputmiddle" placeholder="Middle Name" style="width:31%;" value="<?php echo $middlename ?>" name="middlename"/>
							</td>
						</tr>
						<tr>
							<td><h5>Position</h5></td>
							<td>
								<?php if ($status === 'On Board'): ?>
								<input type="hidden" name="position_id" class="ab" value="<?= $position_id ?>">
								<?= $position ?>
								<?php else: ?>
									<select name="position_id" class="ab">
										<?php 
										if($positions){
											foreach ($positions as $p_value){ 
												echo "<option value='{$p_value->id}' " . (($p_value->id == $position_id)? 'selected="selected"' : '') . ">{$p_value->position}</option>";
											} 
										}
										?>
									</select>
								<?php endif; ?>
								
							</td>
							<td><h5>Alternate</h5></td>
							<td>
								<?php if ($status === 'On Board'): ?>
								<input type="hidden" name="position_id2" class="ab" value="<?= $position_id2 ?>">
								<?php else: ?>
									<select name="position_id2" class="ab">
										<option value="0" selected="selected">&nbsp;</option>
										<?php 
										if($positions){
											foreach ($positions as $p_value){ 
												echo "<option value='{$p_value->id}' " . (($p_value->id == $position_id2)? 'selected="selected"' : '') . ">{$p_value->position}</option>";
											} 
										}
										?>
									</select>
								<?php endif; ?>
								
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td><h5>Date of Birth</h5></td>
							<td>
								<input type="text" class="fw93 ab validate[required]" id="inputbirthdate" placeholder="mm/dd/yyy" value="<?php echo !empty($birthdate) ? date('m/d/Y', strtotime($birthdate)) : ''; ?>" name="birthdate"/>
							</td>	
							<td><h5>Place of Birth</h5></td>
							<td colspan="3">
								<input type="text" class="ab" style="width: 47%;" id="inputbirthplace" placeholder="City/Municipality" value="<?php echo isset($birthplace)? $birthplace : '' ?>" name="birthplace"/>
								<input type="text" class="ab" style="width: 47%;" id="birth_province" placeholder="State/Province" value="<?php echo isset($birth_province)? $birth_province : '' ?>" name="birth_province"/>
							</td>
						</tr>
						<tr>
							<td><h5>Present Address</h5></td>
							<td colspan="3"><input type="text" class="fw98 ab validate[required]" id="inputpres_address" value="<?php echo isset($pres_address)? $pres_address : '' ?>" name="pres_address"/></td>
							<td><h5>Tel No. 1</h5></td>
							<td><input type="text" class="fw93 ab" id="inputpres_tel" placeholder="+632" value="<?php echo isset($pres_tel)? $pres_tel : '' ?>" name="pres_tel"/></td>	
						</tr>
						<tr>
							<td><h5>Provincial Address</h5></td>
							<td colspan="3"><input type="text" class="fw98 ab" id="inputprov_address" value="<?php echo isset($prov_address)? $prov_address : '' ?>" name="prov_address"/></td>
							<td><h5>Tel No. 2</h5></td>
							<td><input type="text" class="fw93 ab" id="inputprov_tel" placeholder="+632" value="<?php echo isset($prov_tel)? $prov_tel : '' ?>" name="prov_tel"/></td>	
						</tr>
						<tr>
							<td><h5>Religion</h5></td>
							<td width="19%">
								<select name="religion" class="fw98 ab">
									<?php 
									if($religion_list){
										foreach ($religion_list as $r_value){ 
											echo "<option value='{$r_value->option}' " . (($r_value->option == $religion)? 'selected="selected"' : '') . ">{$r_value->option}</option>";
										} 
									}
									?>
								</select>
							</td>
							<td width="17%"><h5>Civil Status</h5></td>
							<td width="19%">
								<select name="civil_status" class="fw98 ab">
									<?php 
										$arrayName = array('Single', 'Married', 'Divorced', 'Widowed');
										foreach ($arrayName as $key) {
											echo "<option value='{$key}' " . (($key == $civil_status)? 'selected="selected"' : '') . ">{$key}</option>";
										}
									?>
								</select>
							</td>
							<td width="12%"><h5>Sex</h5></td>
							<td width="19%">
								<input type="radio" class="ab" id="inputgender" value="Male" name="gender" <?php echo ($crew_id)? 'checked="checked"' : ''; ?> <?php echo ('Male' == $gender)? 'checked="checked"' : ''; ?> /> Male
								<input type="radio" class="ab" id="inputgender" value="Female" name="gender" <?php echo ('Female' == $gender)? 'checked="checked"' : ''; ?> style="margin-left: 20px; "/> Female
							</td>
						</tr>
						<tr>
							<td><h5>Height (cm)</h5></td>
							<td><input type="text" class="fw93 ab" id="inputheight" placeholder="0" value="<?php echo isset($height)? $height : '' ?>" name="height"/></td>
							<td><h5>Size of Shoes (inch)</h5></td>
							<td><input type="text" class="fw93 ab" id="inputshoe_size" placeholder="0" value="<?php echo isset($shoe_size)? $shoe_size : '' ?>" name="shoe_size"/></td>
							<td><h5>SSS Nos.</h5></td>
							<td><input type="text" class="fw93 ab" id="inputsss_no" placeholder="00-0000000-0" value="<?php echo isset($sss_no)? $sss_no : '' ?>" name="sss_no"/></td>
						</tr>
						<tr>
							<td><h5>Weight (kg)</h5></td>
							<td><input type="text" class="fw93 ab" id="inputweight" placeholder="0" value="<?php echo isset($weight)? $weight : '' ?>" name="weight"/></td>
							<td><h5>Size of Clothes</h5></td>
							<td>
								<select name="clothe_size" class="fw98 ab">
									<?php 
										$arrayName = array('Small', 'Medium', 'Large', 'X Large', 'XX Large', 'XXX Large');
										foreach ($arrayName as $key) {
											echo "<option value='{$key}' " . (($key == $clothe_size)? 'selected="selected"' : '') . ">{$key}</option>";
										}
									?>
								</select>
							</td>
							<td><h5>TIN Nos.</h5></td>
							<td><input type="text" class="fw93 ab" id="inputtin_no" placeholder="000-000-000" value="<?php echo isset($tin_no)? $tin_no : '' ?>" name="tin_no"/></td>
						</tr>
						<tr>
							<td><h5>Blood Type</h5></td>
							<td><input type="text" class="fw93 ab" id="inputblood_type" value="<?php echo isset($blood_type)? $blood_type : '' ?>" name="blood_type"/></td>
							<td><h5>Blood Pressure</h5></td>
							<td><input type="text" class="fw93 ab" id="inputblood_pressure" value="<?php echo isset($blood_pressure)? $blood_pressure : '' ?>" name="blood_pressure"/></td>
							<td><h5>Email</h5></td>
							<td><input type="text" class="fw93 ab" id="inputemail" value="<?php echo isset($email)? $email : '' ?>" name="email"/></td>
						</tr>
						<tr>
							<td><h5>Spouse's Name</h5></td>
							<td><input type="text" class="fw93 ab" id="inputspouse" value="<?php echo isset($spouse)? $spouse : '' ?>" name="spouse"/></td>
							<td><h5>Date of Birth</h5></td>
							<td><input type="text" class="fw93 ab" id="inputspousebdate" placeholder="mm/dd/yyy" value="<?php echo !empty($spouse_bdate) ? date('m/d/Y', strtotime($spouse_bdate)) : ''; ?>" name="spouse_bdate"/></td>	
							<td><h5>Tel No.</h5></td>
							<td><input type="text" class="fw93 ab" id="inputspouse_tel" placeholder="+632" value="<?php echo isset($spouse_telephone)? $spouse_telephone : '' ?>" name="spouse_telephone"/></td>	
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>	
							<td><h5>Address</h5></td>
							<td colspan="3"><input type="text" class="fw98 ab" id="inputspouse_add" value="<?php echo isset($spouse_add)? $spouse_add : '' ?>" name="spouse_add"/></td>	
						</tr>
						<tr>
							<td><h5>Father's Name</h5></td>
							<td><input type="text" class="fw93 ab" id="inputfather" value="<?php echo isset($father)? $father : '' ?>" name="father"/></td>
							<td><h5>Date of Birth</h5></td>
							<td><input type="text" class="fw93 ab" id="inputfatherbdate" placeholder="mm/dd/yyy" value="<?php echo !empty($father_bdate) ? date('m/d/Y', strtotime($father_bdate)) : ''; ?>" name="father_bdate"/></td>	
							<td><h5>Tel No.</h5></td>
							<td><input type="text" class="fw93 ab" id="inputfather_tel" placeholder="+632" value="<?php echo isset($father_telephone)? $father_telephone : '' ?>" name="father_telephone"/></td>	
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>	
							<td><h5>Address</h5></td>
							<td colspan="3"><input type="text" class="fw98 ab" id="inputfather_add" value="<?php echo isset($father_add)? $father_add : '' ?>" name="father_add"/></td>	
						</tr>
						<tr>
							<td><h5>Mother's Name</h5></td>
							<td><input type="text" class="fw93 ab" id="inputmother" value="<?php echo isset($mother)? $mother : '' ?>" name="mother"/></td>
							<td><h5>Date of Birth</h5></td>
							<td><input type="text" class="fw93 ab" id="inputmotherbdate" placeholder="mm/dd/yyy" value="<?php echo !empty($mother_bdate) ? date('m/d/Y', strtotime($mother_bdate)) : ''; ?>" name="mother_bdate"/></td>	
							<td><h5>Tel No.</h5></td>
							<td><input type="text" class="fw93 ab" id="inputmother_tel" placeholder="+632" value="<?php echo isset($mother_telephone)? $mother_telephone : '' ?>" name="mother_telephone"/></td>	
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>	
							<td><h5>Address</h5></td>
							<td colspan="3"><input type="text" class="fw98 ab" id="inputmother_add" value="<?php echo isset($mother_add)? $mother_add : '' ?>" name="mother_add"/></td>	
						</tr>
						<tr>
							<td><h5>Emergency Contact</h5></td>
							<td><input type="text" class="fw93 ab" id="inputemeg_contact" value="<?php echo isset($emeg_contact)? $emeg_contact : '' ?>" name="emeg_contact"/></td>
							<td><h5>Tel No.</h5></td>
							<td colspan="3"><input type="text" class="fw93 ab" id="inputemeg_tel" placeholder="+632" value="<?php echo isset($emeg_tel)? $emeg_tel : '' ?>" name="emeg_tel"/></td>	
						</tr>
						<tr>
							<td colspan="2"></td>	
							<td><h5>Address</h5></td>
							<td colspan="2"><input type="text" class="fw98 ab" id="inputemeg_add" value="<?php echo isset($emeg_add)? $emeg_add : '' ?>" name="emeg_add"/></td>	
							<td></td>
						</tr>
						<tr>
							<td><h5>Beneficiary</h5></td>
							<td colspan="5">
								<input type="text" class="ab" id="inputlast" placeholder="Last Name" style="width:32%;" value="<?php echo isset($benef_lname)? $benef_lname : '' ?>" name="benef_lname"/>
								<input type="text" class="ab" id="inputfirst" placeholder="First Name" style="width:32%;" value="<?php echo isset($benef_fname)? $benef_fname : '' ?>" name="benef_fname"/>
								<input type="text" class="ab" id="inputmiddle" placeholder="Middle Name" style="width:31%;" value="<?php echo isset($benef_mname)? $benef_mname : '' ?>" name="benef_mname"/>
							</td>
						</tr>
						<tr>
							<td><h5>Relationship</h5></td>
							<td>
								<select name="benef_relation" class="ab">
									<option value="" <?php echo ($benef_relation == '')? 'selected="selected"' : ''; ?>>-Select Relation-</option>
									<?php 
									if($relations){
										foreach ($relations as $r_value){ 
											echo "<option value='{$r_value->option}' " . (($r_value->option == $benef_relation)? 'selected="selected"' : '') . ">{$r_value->option}</option>";
										}
									} 
									?>
								</select>
							</td>
							<td><h5>Address</h5></td>
							<td colspan="3"><input type="text" class="fw98 ab" id="inputbenef_add" value="<?php echo isset($benef_add)? $benef_add : '' ?>" name="benef_add"/></td>	
						</tr>
					</tbody>
				</table>
			</form>
			<div class="clearfix"></div>
		</div>
	
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
    	$('.alert').alert();
    	var religion = <?php echo json_encode($religion_list);?>;

    	<?php if($crew_id): ?>
	    	var regcollection = new Regcollection();
	    	regcollection.id = <?php echo $crew_id; ?>; 
	    	regcollection.photo = "<?php echo $photo; ?>"; 
	    	var aboutView = new AboutView({collection: regcollection});
	    <?php else: ?>
	    	window.regModel = new RegModel();
    		var aboutView = new AboutView({model: regModel});
    	<?php endif; ?>

    	 $("#inputbirthdate").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"}); 
    	 $("#inputfatherbdate").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"}); 
    	 $("#inputspousebdate").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"}); 
    	 $("#inputmotherbdate").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"}); 
    });
</script>

<script type="text/template" id="alert0Template">
	<div class="alert alert-<%= type %>">
		<button class="close" data-dismiss="alert" type="button">×</button>
		<%= message %>
	</div>
</script>  