
<div id="schedule-info">
		
	<div class="row-details" >	

		<div class="pull-right">
			<?php if(isset($id)): ?>
				<?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
				<a class="btn resume-print" rel="tooltip" title="Export" target="_blank"
	                href="<?php echo site_url("schedule-for-crew-replacement/"  . $control_nos); ?>" >
	                <i class="icon-pdf"></i> 
	            </a> 
	            <?php endif; ?>
        	<?php endif; ?>
        	<a class="btn" title="Master List" href="<?php echo site_url("schedule-list"); ?>" >Back to List</a>

        	<?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
            <a id="sched_save-btn" class="btn <?php echo isset($id)? 'btn-success' : 'btn-primary'; ?>" data-original-title="<?php echo isset($id)? 'Update' : 'Save'; ?>"><?php echo isset($id)? 'Update' : 'Save'; ?></a>
        	<?php endif; ?>
        </div>

		<div class="clearfix"></div>

		<div style="margin-bottom: 20px"></div>

		<div id="alert-div"></div>
		
		<table class="responsive-table inoptsinfo" id="options-table-sched">
			<tbody>
				<tr>
					<td width="16%"><h5>VESSEL NAME</h5></td>
					<td>
						<?php 
						if (isset($id)) {
							echo isset($vessel_name)? $vessel_name : '';
							echo "<input type='hidden' name='vessel_id' value='{$vessel_id}'/>";
						}else {
							if($vessels){
	                        	echo "<select name='vessel_id' id='vessel_id' >";
			                        foreach ($vessels as $v_value){ 
			                            echo "<option value='{$v_value->id}' ";
			                            if(isset($vessel_id)){
			                            	if($v_value->id == $vessel_id) echo "selected='selected'";
			                            }
			                            echo ">{$v_value->vessel_name}</option>";
			                        } 
			                    echo "</select>";
	                        }
						}
                        ?>
					</td>
					<td width="16%"><h5>Reference #</h5></td>
					<td>
						<?php 
							if(isset($control_nos)): 
						?>
						<input type="hidden" value="<?php echo isset($control_nos)? $control_nos : 0; ?>" name="control_nos" />
						<input type="text" value="<?php echo isset($control_nos)? $control_nos : 0; ?>" readonly="readonly" />
						<?php 
							else:
								echo isset($control_message)? $control_message : '';
							endif; 
						?>
					</td>
				</tr>
				<tr>
					<td><h5>JOINING DATE</h5></td>
					<td><input id="inputjoining_date" class="jrdate" placeholder="mm/dd/yyyy" style="width:60%;"  type="text" name="joining_date" value="<?php echo isset($j_date)? date('m/d/Y', strtotime($j_date)) : ''; ?>"  /></td>
					<td><h5>REPAT DATE</h5></td>
					<td><input id="inputrepat_date" class="jrdate" placeholder="mm/dd/yyyy" style="width:60%;"  type="text" name="repat_date" value="<?php echo isset($r_date)? date('m/d/Y', strtotime($r_date)) : ''; ?>"  /></td>
				</tr>
				<tr>
					<td><h5>AIRPORT</h5></td>
					<td><input id="inputairport" type="text" name="airport" value="<?php echo isset($airport)? $airport : ''; ?>" style="width:97%;"  /></td>
					<td><h5>PORT</h5></td>
					<td><input id="inputjoining_port" type="text" name="joining_port" value="<?php echo isset($joining_port)? $joining_port : ''; ?>" style="width:97%;"  /></td>
				</tr>
				<tr>
					<td><h5>HANDLING AGENT</h5></td>
					<td>
					<?php if($agents): 
						$hid = isset($han_agent_id)? $han_agent_id : 0;
					?>
						<select style="width:100%;" name="han_agent_id" id="han_agent_id">
							<option value='0'>&nbsp;</option>
				           	<?php 
				            foreach ($agents as $key => $value) {
				                echo "<option value='{$value->id}' ";
				                echo ($hid == $value->id)? 'selected="selected"' : '';
				                echo ">{$value->fullname}</option>";
				            } ?>
			            </select>
			        <?php endif; ?>
					</td>
					<td><h5>CHARTERER'S AGENT</h5></td>
					<td>
					<?php if($agents): 
						$cid = isset($cha_agent_id)? $cha_agent_id : 0;
					?>
						<select style="width:100%;" name="cha_agent_id" id="cha_agent_id">
							<option value='0'>&nbsp;</option>
				           	<?php 
				            foreach ($agents as $key => $value) {
				                echo "<option value='{$value->id}' ";
				                echo ($cid == $value->id)? 'selected="selected"' : '';
				                echo ">{$value->fullname}</option>";
				            } ?>
			            </select>
			        <?php endif; ?>
					</td>
				</tr>
				<tr>
					<td><h5>REVISION</h5></td>
					<td>
						<input id="inputrevision" type="text" name="revision" value="<?php echo isset($revision)? $revision : ''; ?>" style="width:97%;"/>
					</td>
					<td><h5>VISA REQUIREMENTS</h5></td>
					<td><input id="inputvisa" type="text" name="visa" value="<?php echo isset($visa)? $visa : ''; ?>" style="width:97%;"/></td>
				</tr>
				<tr>
					<td><h5>Company</h5></td>
					<td>
						<?php 
							$company_id = isset($company_id)? $company_id : 0;
						?>
						<select name="company_id">
							<option value="1" <?= ($company_id == 1)? 'selected="selected"' : ''; ?> >Fair Shipping Corporation</option>
							<option value="2" <?= ($company_id == 2)? 'selected="selected"' : ''; ?> >Cordial Shipping Incorporated </option>
						</select>
					</td>
					<td colspan="2" rowspan="2">
						<?php 
							$is_approve 	= isset($is_approve)? $is_approve : 0;
							$advised_agent 	= isset($advised_agent)? $advised_agent : 0;
							$final_flight 	= isset($final_flight)? $final_flight : 0;
							$final_dispatch = isset($final_dispatch)? $final_dispatch : 0;
						?>
						<div><input type="checkbox" class="in_is_approve" name="is_approve" value="1" <?php echo ($is_approve == 1)? "checked='checked'" : '' ?> /> APPROVE CREW REPLACEMENT </div>
						<div><input type="checkbox" class="in_advised_agent" name="advised_agent" value="1" <?php echo ($advised_agent == 1)? "checked='checked'" : '' ?> /> ADVISED AGENT</div>
						<div><input type="checkbox" class="in_final_flight" name="final_flight" value="1" <?php echo ($final_flight == 1)? "checked='checked'" : '' ?> /> FINAL FLIGHT</div>
						<div><input type="checkbox" class="in_final_dispatch" name="final_dispatch" value="1" <?php echo ($final_dispatch == 1)? "checked='checked'" : '' ?> /> FINAL DISPATCH</div>
					</td>
				</tr>
				<tr>
					<td><h5>REMARKS</h5></td>
					<td>
						<textarea id="inputremarks" name="remarks" style="width: 96%; height: 30px;" ><?php echo isset($remarks)? $remarks : ''; ?></textarea>
					</td>
				</tr>
				<tr>
					<td><h5>CREATED DATE</h5></td>
					<td><input id="inputcreated_date" class="jrdate" placeholder="mm/dd/yyyy" style="width:60%;"  type="text" name="srp_date" value="<?php echo isset($s_date)? date('m/d/Y', strtotime($s_date)) : ''; ?>"  /></td>
					<td><h5>PRINCIPAL <br/>APPROVAL DATE</h5></td>
					<td><input id="inputapproval_date" class="jrdate" placeholder="mm/dd/yyyy" style="width:60%;"  type="text" name="approval_date" value="<?php echo isset($a_date)? date('m/d/Y', strtotime($a_date)) : ''; ?>"  /></td>
				</tr>
				<tr>
					<td><h5>AIRPORT TERMINAL</h5></td>
					<td><input style="width:60%;"  type="text" name="terminal" id="terminal" value="<?php echo isset($terminal)? $terminal : ''; ?>" /></td>
					<td><h5>MEETING TIME</h5></td>
					<td><input type="text" style="width:60%;"  name="arrival_time" id="arrival_time" value="<?php echo isset($arrival_time)? $arrival_time : ''; ?>" /></td>
				</tr>
			</tbody>
		</table>
		
		<div class="clearfix"></div>
	</div>

	<!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {  

            <?php if(isset($id)): ?>
		    	var schedcollection = new SchedCollection();
		    	schedcollection.id = <?= $id; ?>; 
		    	var schedMasterView = new SchedMasterView({collection: schedcollection});
		    <?php else: ?>
		    	window.schedModel = new SchedModel();
	    		var schedMasterView = new SchedMasterView({model: schedModel});
	    	<?php endif; ?> 
    	 	$(".jrdate").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"}); 
        });
    </script>

    <script type="text/template" id="alertTemplate">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>

</div>
