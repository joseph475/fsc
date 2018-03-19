<div class="accordion-group row-section"> 
		
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#principal-info">
		<div class="row-title">	PRINCIPAL INFORMATION</div> 
	</a>		
	
	<div id="principal-info" class="accordion-body collapse in">
			
			<div class="row-details" id="fileupload">	
				<div id="alert-div"></div>
				
				<div id="profile-header">
					<div class="pull-right">
						<?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
						<a id="save-btn" class="btn btn-primary" >Save</a>	
						<?php endif; ?>
						<?php if($hash): ?>
						<a href="<?php echo site_url("principal-resume/{$hash}");?>" class="btn">View Resume</a>	
						<?php endif; ?>
						<a href="<?php echo site_url('principal-master-list'); ?>" class="btn" >Master List</a>	
					</div>
					<form enctype="multipart/form-data" method="post" action="<?php echo site_url('upload/upload_img');?>">
						<div class="span2 imgdiv">
							<div id="profile-img-container">
								<img src="<?php echo $thumb_url;?>" class="thumbnail" id="profile-img-default">
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
					
					<div class="clearfix" style="margin-bottom: 20px;"></div>
				</div>
				
				<table class="responsive-table" id="options-table-1">
					<tbody>
						<tr>
							<td width="15%"><h5>Principal Name</h5></td>
							<td width="63%"><input type="text" class="fw98 ab" id="inputfullname" value="<?php echo _p($about, 'fullname'); ?>" name="fullname"/></td>
							<td width="12%"><h5>Code</h5></td>
							<td width="10%"><input type="text" class="fw93 ab" id="inputcode" value="<?php echo _p($about, 'code'); ?>" name="code" /></td>							
						</tr>
						<tr>
							<td><h5>Alternate Name</h5></td>
							<td><input type="text" class="fw98 ab" id="inputalt" value="<?php echo _p($about, 'alternate'); ?>" name="alternate"/></td>
							<td><h5>Status</h5></td>
							<td>
								<select name="status" class="ab">
									<?php 
										$arrayName = array('Active', 'Inactive');
										foreach ($arrayName as $key) {
											echo "<option value='{$key}' " . (($key == _p($about, 'status'))? 'selected="selected"' : '') . ">{$key}</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td><h5>Address</h5></td>
							<td><input type="text" class="fw98 ab" id="inputaddress" value="<?php echo _p($about, 'address'); ?>" name="address"/></td>	
							<td><h5>SSS Nos.</h5></td>
							<td><input type="text" class="fw93 ab" id="inputsss" value="<?php echo _p($about, 'sss'); ?>" name="sss"/></td>
						</tr>
						<tr>
							<td><h5>Tel Nos.</h5></td>
							<td>
								<input type="text" class="ab" id="inputtelno1" style="width: 30%" placeholder="Tel Nos. 1" value="<?php echo _p($about, 'telno1'); ?>" name="telno1"/>
								<input type="text" class="ab" id="inputtelno2" style="width: 30%" placeholder="Tel Nos. 2" value="<?php echo _p($about, 'telno3'); ?>" name="telno3"/>
								<input type="text" class="ab" id="inputtelno3" style="width: 30%" placeholder="Tel Nos. 3" value="<?php echo _p($about, 'telno3'); ?>" name="telno3"/>
							</td>
							<td><h5>Telex</h5></td>
							<td><input class="fw93 ab" type="text" id="inputtelex" value="<?php echo _p($about, 'telex'); ?>" name="telex"/></td>
						</tr>
						<tr>
							<td><h5>Fax Nos.</h5></td>
							<td>
								<input type="text" class="ab" id="inputfax1" style="width: 30%" placeholder="Fax Nos. 1" value="<?php echo _p($about, 'fax1'); ?>" name="fax1"/>
								<input type="text" class="ab" id="inputfax2" style="width: 30%" placeholder="Fax Nos. 2" value="<?php echo _p($about, 'fax2'); ?>" name="fax2"/>
								<input type="text" class="ab" id="inputfax3" style="width: 30%" placeholder="Fax Nos. 3" value="<?php echo _p($about, 'fax3'); ?>" name="fax3"/>
							</td>
							<td><h5>Cable</h5></td>
							<td><input type="text" class="fw93 ab" id="inputcable" value="<?php echo _p($about, 'cable'); ?>" name="cable"/></td>
						</tr>
						<tr>
							<td><h5>Person In-Charge 1</h5></td>
							<td colspan="3">
								<input type="text" class="ab" id="inputperson1" style="width: 45%" placeholder="Name" value="<?php echo _p($about, 'person1'); ?>" name="person1"/>
								<input type="text" class="ab" id="inputdesignate1" style="width: 30%" placeholder="Designation" value="<?php echo _p($about, 'designate1'); ?>" name="designate1"/>
								<input type="text" class="ab" id="inputcontact1" style="width: 20%" placeholder="Tel Nos" value="<?php echo _p($about, 'contact1'); ?>" name="contact1"/>
							</td>
						</tr>
						<tr>
							<td><h5>Person In-Charge 2</h5></td>
							<td colspan="3">
								<input type="text" class="ab" id="inputperson2" style="width: 45%" placeholder="Name" value="<?php echo _p($about, 'person2'); ?>" name="person2"/>
								<input type="text" class="ab" id="inputdesignate2" style="width: 30%" placeholder="Designation" value="<?php echo _p($about, 'designate2'); ?>" name="designate2"/>
								<input type="text" class="ab" id="inputcontact2" style="width: 20%" placeholder="Tel Nos" value=<?php echo _p($about, 'contact2'); ?>"" name="contact2"/>
							</td>
						</tr>
						<tr>
							<td><h5>Accredited Date</h5></td>
							<td>
								<input type="text" class="ab date1" id="inputaccredited" style="width: 30%" placeholder="00/00/0000" value="<?php echo _p($about, 'accredited'); ?>" name="accredited"/>
							</td>
							<td colspan="2"></td>
						</tr>
					</tbody>
				</table>
			</div>
		<!-- </form> -->
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
    	$('.alert').alert();
    	
    	<?php if($about): ?>
	    	var principalcollection = new PrincipalCollection();
	    	principalcollection.id = <?php echo $id; ?>; 
	    	principalcollection.photo = "<?php echo $photo; ?>"; 
	    	var principalView = new PrincipalView({collection: principalcollection});
	    <?php else: ?>
	    	window.principalModel = new PrincipalModel();
    		var principalView = new PrincipalView({model: principalModel});
    	<?php endif; ?>
    });
</script>

<script type="text/template" id="alertTemplate">
	<div class="alert alert-<%= type %>">
		<button class="close" data-dismiss="alert" type="button">×</button>
		<%= message %>
	</div>
</script>


