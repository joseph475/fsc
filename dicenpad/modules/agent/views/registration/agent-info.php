<div class="accordion-group row-section"> 
		
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#agent-info">
		<div class="row-title">	AGENT INFORMATION</div> 
	</a>		
	
	<div id="agent-info" class="accordion-body collapse in">
			
			<div class="row-details">	
				<div id="alert-div"></div>
				
				<div class="pull-right">
					<?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
					<a id="save-btn" class="btn btn-primary" >Save</a>	
					<?php endif; ?>
					<?php if($hash): ?>
					<a href="<?php echo site_url("agent-resume/{$hash}");?>" class="btn">View Resume</a>	
					<?php endif; ?>
					<a href="<?php echo site_url("agent-master-list"); ?>" class="btn" >Master List</a> 	
				</div>

				<div class="clearfix" style="margin-bottom: 20px;"></div>
				
				<table class="responsive-table" id="options-table-1">
					<tbody>
						<tr>
							<td width="15%"><h5>Agent Name</h5></td>
							<td width="63%"><input type="text" class="fw98 ab" id="inputname" value="<?php echo _p($about, 'fullname'); ?>" name="fullname"/></td>
							<td width="12%"><h5>Principal</h5></td>
							<td width="10%">
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
							<td><h5>Principal</h5></td>
							<td>
								<select name="principal_id" class="ab" style="width: 100%;">
									<option value='0'>&nbsp;</option>
									<?php 
									if($principals){
										foreach ($principals as $value) {
											echo "<option value='{$value->id}' " . (($value->id == _p($about, 'principal_id'))? 'selected="selected"' : '') . ">{$value->fullname}</option>";
										}
									}
									?>
								</select>
							</td>
							<td><h5>Email</h5></td>
							<td><input type="text" class="fw93 ab" id="inputemail" value="<?php echo _p($about, 'email'); ?>" name="email"/></td>
						</tr>
						<tr>
							<td><h5>Address</h5></td>
							<td><input type="text" class="fw98 ab" id="inputaddress" value="<?php echo _p($about, 'address'); ?>" name="address"/></td>	
							<td><h5>Port</h5></td>
							<td><input type="text" class="fw93 ab" id="inputport" value="<?php echo _p($about, 'port'); ?>" name="port"/></td>
						</tr>
						<tr>
							<td><h5>Tel Nos.</h5></td>
							<td>
								<input type="text" class="ab" id="inputtelno1" style="width: 30%" placeholder="Tel Nos. 1" value="<?php echo _p($about, 'telno1'); ?>" name="telno1"/>
								<input type="text" class="ab" id="inputtelno2" style="width: 30%" placeholder="Tel Nos. 2" value="<?php echo _p($about, 'telno2'); ?>" name="telno2"/>
								<input type="text" class="ab" id="inputtelno3" style="width: 30%" placeholder="Tel Nos. 3" value="<?php echo _p($about, 'telno3'); ?>" name="telno3"/>
							</td>
							<td><h5>Telefax</h5></td>
							<td><input class="fw93 ab" type="text" id="inputtelefax" value="<?php echo _p($about, 'telefax'); ?>" name="telefax"/></td>
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
							<td><h5>In-Charge</h5></td>
							<td colspan="3">
								<input type="text" class="ab" id="inputincharge" style="width: 45%" placeholder="Name" value="<?php echo _p($about, 'incharge'); ?>" name="incharge"/>
								<input type="text" class="ab" id="inputdesignation" style="width: 30%" placeholder="Designation" value="<?php echo _p($about, 'designation'); ?>" name="designation"/>
								<input type="text" class="ab" id="inputcontact" style="width: 20%" placeholder="Tel Nos" value="<?php echo _p($about, 'contact'); ?>" name="contact"/>
							</td>
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
	    	var agentcollection = new AgentCollection();
	    	agentcollection.id = <?php echo $id; ?>; 
	    	var agentView = new AgentView({collection: agentcollection});
	    <?php else: ?>
	    	window.agentModel = new AgentModel();
    		var agentView = new AgentView({model: agentModel});
    	<?php endif; ?>
    });
</script>

<script type="text/template" id="alertTemplate">
	<div class="alert alert-<%= type %>">
		<button class="close" data-dismiss="alert" type="button">×</button>
		<%= message %>
	</div>
</script>


