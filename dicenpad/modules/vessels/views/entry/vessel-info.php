<div class="row-section"> 
	
	<div class="row-title">	VESSEL SPECIFICATION</div> 
		
	<div id="vessel-info">
			
			<div class="row-details" id="fileupload">	
				<div id="alert-div"></div>
				
				<div id="profile-header">
					<div class="pull-right">
						<?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
							<a id="save-btn" class="btn btn-primary" >Save</a>	
						<?php endif; ?>
						<?php if($id): ?>
							<a href="<?php echo site_url("vessel-specification/{$id}");?>" class="btn" >View Specs</a>	
						<?php endif; ?>
						
						<a href="<?php echo site_url('vessels-master-list'); ?>" class="btn" >Master List</a>	 
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


					<div class="clearfix"></div>
				</div>

				<div style="margin-bottom: 20px"></div>
				
				<table class="responsive-table" id="options-table-1">
					<tbody>
						<tr>
							<td width="12%"><h5>Vessel Name</h5></td>
							<td width="38%"><input type="text" class="fw98 ab" id="inputvessel_name" value="<?php echo _p($about, 'vessel_name'); ?>" name="vessel_name"/></td>
							<td width="5%"><h5>Control #</h5></td>
							<td width="20%"><input type="text" class="fw93 ab" id="inputControl" value="<?php echo _p($about, 'control_nos'); ?>" name="control_nos"/></td>
							<td width="12%"><h5>Principal</h5></td>
							<td width="15%">
								<select name="principal_id" class="ab">
								<?php 
								if($principal){
									foreach ($principal as $p_value){ 
										echo "<option value='{$p_value->id}' " . (($p_value->id == _p($about, 'principal_id'))? 'selected="selected"' : '') . ">{$p_value->fullname}</option>";
									} 
								} else {
									echo "<option value='0'>&nbsp;</option>";
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td><h5>Flag</h5></td>
							<td>
								<select name="flag_id" class="fw93 ab">
								<?php 
								if($flag){
									foreach ($flag as $f_value){ 
										echo "<option value='{$f_value->id}' " . (($f_value->id == _p($about, 'flag_id'))? 'selected="selected"' : '') . ">{$f_value->flag}</option>";
									} 
								} else {
									echo "<option value='0'>&nbsp;</option>";
								}
								?>
								</select>
							</td>
							<td><h5>Registered In</h5></td>
							<td><input type="text" class="fw93 ab" id="inputregistered" value="<?php echo _p($about, 'registered'); ?>" name="registered"/></td>
							<td><h5>Manning Company</h5></td>
							<td>
								<select name="company_id" class="fw93 ab">
									<option value="1" <?php echo ($company_id == '1')? 'selected="selected"' : ''; ?>>FAIR SHIPPING</option>
									<option value="2" <?php echo ($company_id == '2')? 'selected="selected"' : ''; ?>>CORDIAL SHIPPING</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><h5>Builder</h5></td>
							<td><input type="text" class="fw98 ab" id="inputbuilder" value="<?php echo _p($about, 'builder'); ?>" name="builder"/></td>
							<td><h5>Status</h5></td>
							<td>
								<select name="status" class="fw93 ab">
									<option value="active" <?php echo ($status == 'Active')? 'selected="selected"' : ''; ?> >Active</option>
									<option value="inactive" <?php echo ($status == 'Inactive')? 'selected="selected"' : ''; ?> >Inactive</option>
								</select>
							</td>
							<td><h5>Built In</h5></td>
							<td><input type="text" class="fw93 ab" id="inputbuiltin" value="<?php echo _p($about, 'builtin'); ?>" name="builtin"/></td>	
								
						</tr>
						<tr>
							<td><h5>Manufacturer</h5></td>
							<td colspan="3"><input type="text" class="fw98 ab" id="inputmanufacturer" value="<?php echo _p($about, 'manufacturer'); ?>" name="manufacturer"/></td>	
							<td><h5>Engine</h5></td>
							<td><input type="text" class="fw93 ab" id="inputengine" value="<?php echo _p($about, 'engine'); ?>" name="engine"/></td>
						</tr>
						<tr>
							<td><h5>Vessel Type</h5></td>
							<td>
								<select name="type_id" class="ab">
								<?php 
								if($type){
									$vessel_type = '';
									foreach ($type as $t_value){ 
										echo "<option value='{$t_value->id}' " . (($t_value->id == _p($about, 'type_id'))? 'selected="selected"' : '') . ">{$t_value->title}</option>";
									} 
								} else {
									echo "<option value='0'>&nbsp;</option>";
								}
								?>
								</select>
							</td>	
							<td><h5>Year Built</h5></td>
							<td>
								<select name="e_year" class="ab" style="width:100%">
								<?php 
									for ($i = date('Y') ; $i >= 1900; $i--){ 
										echo "<option value='{$i}' " . (($i == _p($about, 'e_year'))? 'selected="selected"' : '') . ">{$i}</option>";
									} 
								?>
								</select>
							</td>
							<td><h5>Trade Route</h5></td>
							<td><input type="text" class="fw93 ab" id="trade" value="<?php echo _p($about, 'trade'); ?>" name="trade"/></td>	
							
						</tr>
						<tr>
							<td><h5>Gross Ton (MT)</h5></td>
							<td width="18%"><input type="text" class="fw93 ab" id="inputgross" placeholder="0" value="<?php echo _p($about, 'gross'); ?>" name="gross"/></td>
							<td width="15%"><h5>Net Ton (MT)</h5></td>
							<td width="20%"><input type="text" class="fw93 ab" id="inputnet" placeholder="0" value="<?php echo _p($about, 'net'); ?>" name="net"/></td>
							<td width="15%"><h5>DWT (MT)</h5></td>
							<td width="15%"><input type="text" class="fw93 ab" id="inputdwt" placeholder="0" value="<?php echo _p($about, 'dwt'); ?>" name="dwt"/></td>
						</tr>
						<tr>
							<td><h5>Length (M)</h5></td>
							<td><input type="text" class="fw93 ab" id="inputlength" placeholder="0" value="<?php echo _p($about, 'length'); ?>" name="length"/></td>
							<td><h5>Depth (M)</h5></td>
							<td><input type="text" class="fw93 ab" id="inputdepth" placeholder="0" value="<?php echo _p($about, 'depth'); ?>" name="depth"/></td>
							<td><h5>Breadth (M)</h5></td>
							<td><input type="text" class="fw93 ab" id="inputbreadth" placeholder="0" value="<?php echo _p($about, 'breadth'); ?>" name="breadth"/></td>
						</tr>
						<tr>
							<td><h5>Cylinder</h5></td>
							<td><input type="text" class="fw93 ab" id="inputcylinder" placeholder="0" value="<?php echo _p($about, 'cylinder'); ?>" name="cylinder"/></td>
							<td><h5>HP (P.S)</h5></td>
							<td><input type="text" class="fw93 ab" id="inputhp" placeholder="0" value="<?php echo _p($about, 'hp'); ?>" name="hp"/></td>
							<td><h5>Speed (KNOTS)</h5></td>
							<td><input type="text" class="fw93 ab" id="inputspeed" placeholder="0" value="<?php echo _p($about, 'speed'); ?>" name="speed"/></td>
						</tr>
						<tr>
							<td><h5>Certificate Nos.</h5></td>
							<td><input type="text" class="fw93 ab" id="inputcerti_nos" value="<?php echo _p($about, 'certi_nos'); ?>" name="certi_nos"/></td>
							<td><h5>Contract Duration</h5></td>
							<td><input type="text" class="fw93 ab" id="inputduration" placeholder="0" value="<?php echo _p($about, 'duration'); ?>" name="duration"/></td>
							<td><h5>Validity</h5></td>
							<td>
								<input type="text" class="ab date2" style="width: 44%;" id="from" placeholder="From" value="<?php echo ($certi_validity != '1970-01-01' && $certi_validity != '0000-00-00')? $certi_validity : ''; ?>" name="certi_validity"/>
								<input type="text" class="ab date2" style="width: 44%;" id="to" placeholder="To" value="<?php echo ($certi_validity_to != '1970-01-01' && $certi_validity_to != '0000-00-00')? $certi_validity_to : ''; ?>" name="certi_validity_to"/>
							</td>
						</tr>
						<tr>
							<td><h5>Order Nos.</h5></td>
							<td><input type="text" class="fw93 ab" id="inputorder_nos" value="<?php echo _p($about, 'order_nos'); ?>" name="order_nos"/></td>
							<td><h5>Accreditation Date</h5></td>
							<td><input type="text" class="fw93 ab date1" id="inputorder_date" placeholder="Date" value="<?php echo ($order_date != '1970-01-01' && $order_date != '0000-00-00')? $order_date : ''; ?>" name="order_date"/></td>
							<td><h5>CBA</h5></td>
							<td>
								<select name="cba" class="ab">
									<?php 
										$arrayName = array('IBF-JSU/AMOSUP IMMAJ', 'IBF-FKSU/AMOSUP KSA', 'NON CBA');
										foreach ($arrayName as $key) {
											echo "<option value='{$key}' " . (($key == _p($about, 'cba'))? 'selected="selected"' : '') . ">{$key}</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td><h5>Official Nos.</h5></td>
							<td><input type="text" class="fw93 ab" id="inputofficial_nos" value="<?php echo _p($about, 'official_nos'); ?>" name="official_nos"/></td>
							<td><h5>IMO Nos.</h5></td>
							<td><input type="text" class="fw93 ab" id="inputimo_nos" value="<?php echo _p($about, 'imo_nos'); ?>" name="imo_nos"/></td>
							<td><h5>Classification</h5></td>
							<td><input type="text" class="fw93 ab" id="inputclassification" value="<?php echo _p($about, 'classification'); ?>" name="classification"/></td>
						</tr>
					</tbody>
				</table>
				
				<div class="clearfix"></div>
			</div>
		<!-- </form> -->
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
    	$('.alert').alert();
    	<?php if(isset($about)): ?>
	    	var vesselcollection = new VesselCollection();
	    	vesselcollection.id = <?php echo $id; ?>; 
	    	vesselcollection.photo = "<?php echo $photo; ?>";
	    	var vesselView = new VesselView({collection: vesselcollection});
	    <?php else: ?>
	    	window.vesselModel = new VesselModel();
	    	var vesselView = new VesselView({model: vesselModel});
    	<?php endif; ?>
    });
</script>

<script type="text/template" id="alertTemplate">
	<div class="alert alert-<%= type %>">
		<button class="close" data-dismiss="alert" type="button">×</button>
		<%= message %>
	</div>
</script>
