<div id="personal-info">
	<div class="row-title">CREW PERSONAL INFORMATION <span class='pull-right'><?php echo ($crew_id)? 'Crew ID: ' . $crew_id : ''; ?></span></div> 
	<div class="row-details" style="padding-top: 20px;">
		<div id="profile-header">

			<!-- Profile Header -->
			<img src="<?php echo $pics_url; ?>" width="106" id="user-photo">
			<h2><?php echo $fullname ?></h2>
			<h5>POSITION: <?php echo $position ?></h5>
			<h5>VESSEL: <?php echo $vessel_name ?></h5>
			<h5>STATUS: <?php echo $status ?>  </h5>
			<h5 class="text-info"><i><?= ($srp_reference)? " For SRP RECOMMENDATION on " . $srp_vessel . " with Ref #<a href='" . site_url("schedule-replacement/" . $srp_reference) . "'>" . $srp_reference . "</a>" : ""  ?></i></h5>

			<div class="clearfix"></div>
		</div> 
		<div class="pull-right">
			<?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
			<a class="btn btn-checklist" rel="tooltip" title="Checklist" 
            href="javascript:void(0);" data-toggle="modal">
                Generate Reports
            </a> 
			<?php endif; ?>        
           
           	<?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
			<a class="btn btn-success" href="<?php echo site_url("crew-applicant/"  . $hash); ?>" id="edit-profile-btn" data-content="This button enable you to edit crew profile" rel="popover" data-original-title="Edit Profile"> Edit Profile </a>	
			<?php endif; ?>         
		</div>

		<div class="clearfix"></div>

		<div style="margin-bottom: 20px"></div>	

		<table class="responsive-table" id="options-table-1">
			<tbody>
				<tr>
					<td width="15%"><h5>Date of Birth</h5></td>
					<td width="55%"><p id="birthdate" class="ab"><?php echo isset($birthdate) ? date('m/d/Y', strtotime($birthdate)) : ''; ?></p></td>
					<td width="15%"><h5>Age</h5></td>
					<td width="15%"><?php echo isset($birthdate)? get_age(date('Y-m-d', strtotime($birthdate))) . ' y/o' : '' ?></td>
				</tr>
				<tr>
					<td><h5>Place of Birth</h5></td>
					<td><p id="birthplace2" class="ab"><?php echo $birthplace2 ?></p></td>
					<td><h5>Date of Hired</h5></td>
					<td><p id="dateofhired" class="ab"><?= ($date_hired)? date('m/d/Y', strtotime($date_hired)) : ''; ?></p></td>
				</tr>
				<tr>
					<td><h5>Present Address</h5></td>
					<td><p id="pres_address" class="ab"><?php echo $pres_address ?></p></td>	
					<td><h5>Tel No. 1</h5></td>
					<td><p id="pres_tel" class="ab"><?php echo $pres_tel ?></p></td>
				</tr>
				<tr>
					<td><h5>Provincial Address</h5></td>
					<td><p id="prov_address" class="ab"><?php echo $prov_address ?></p></td>
					<td><h5>Tel No. 2</h5></td>
					<td><p id="prov_tel" class="ab"><?php echo $prov_tel ?></p></td>
				</tr>
			<tbody>
		</table>
		<table class="responsive-table" id="options-table-1" style="border-top: none;">
			<tbody>
				<tr style="border-top: none;">
					<td width="15%"><h5>Religion</h5></td>
					<td width="25%"><p id="religion" class="ab"><?php echo $religion?></p></td>
					<td width="15%"><h5>Civil Status</h5></td>
					<td width="15%"><p id="civil_status" class="ab"><?php echo $civil_status ?></p></td>
					<td width="15%"><h5>Sex</h5></td>
					<td width="15%"><p id="gender" class="ab"><?php echo $gender ?></p></td>
				</tr>
				<tr>
					<td><h5>Height</h5></td>
					<td><p id="height" class="ab"><?php echo $height ?></p></td>
					<td><h5>Size of Shoes</h5></td>
					<td><p id="shoe_size" class="ab"><?php echo $shoe_size ?></p></td>
					<td><h5>SSS Nos.</h5></td>
					<td><p id="sss_no" class="ab"><?php echo $sss_no ?></p></td>
				</tr>
				<tr>
					<td><h5>Weight</h5></td>
					<td><p id="weight" class="ab"><?php echo $weight ?></p></td>
					<td><h5>Size of Clothes</h5></td>
					<td><p id="clothe_size" class="ab"><?php echo $clothe_size ?></p></td>
					<td><h5>TIN Nos.</h5></td>
					<td><p id="tin_no" class="ab"><?php echo $tin_no ?></p></td>
				</tr>
				<tr>
					<td><h5>Blood Type</h5></td>
					<td><p id="blood_type" class="ab"><?php echo $blood_type ?></td>
					<td><h5>Blood Pressure</h5></td>
					<td><p id="blood_pressure" class="ab"><?php echo $blood_pressure ?></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<table class="responsive-table" id="options-table-1" style="border-top: none;">
			<tbody>
				<tr style="border-top: none;">
					<td width="15%"><h5>Spouse's Name</h5></td>
					<td width="25%"><p id="spouse" class="ab"><?php echo $spouse ?></p></td>
					<td width="15%"><h5>Date of Birth</h5></td>
					<td width="15%"><p id="spouse_bdate" class="ab"><?php echo !empty($spouse_bdate) ? date('m/d/Y', strtotime($spouse_bdate)) : ''; ?></p></td>
					<td width="15%"><h5>Tel Nos.</h5></td>
					<td width="15%"><p id="spouse" class="ab"><?php echo $spouse_telephone ?></p></td>
				</tr>
				<tr style="border-top: none;">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><h5>Address</h5></td>
					<td colspan="3"><p id="spouse_add" class="ab"><?php echo $spouse_add ?></p></td>
				</tr>
				<tr>
					<td><h5>Father's Name</h5></td>
					<td><p id="father" class="ab"><?php echo $father ?></p></td>
					<td><h5>Date of Birth</h5></td>
					<td><p id="father_bdate" class="ab"><?php echo !empty($father_bdate) ? date('m/d/Y', strtotime($father_bdate)) : ''; ?> </p></td>
					<td><h5>Tel Nos.</h5></td>
					<td><p id="spouse" class="ab"><?php echo $father_telephone ?></p></td>
				</tr>
				<tr style="border-top: none;">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><h5>Address</h5></td>
					<td colspan="3"><p id="father_add" class="ab"><?php echo $father_add ?></p></td>
				</tr>
				<tr>
					<td><h5>Mothers's Name</h5></td>
					<td><p id="mother" class="ab"><?php echo $mother ?></p></td>
					<td><h5>Date of Birth</h5></td>
					<td><p id="mother_bdate" class="ab"><?php echo !empty($mother_bdate) ? date('m/d/Y', strtotime($mother_bdate)) : ''; ?></p></td>
					<td><h5>Tel Nos.</h5></td>
					<td><p id="spouse" class="ab"><?php echo $mother_telephone ?></p></td>
				</tr>
				<tr style="border-top: none;">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><h5>Address</h5></td>
					<td colspan="3"><p id="mother_add" class="ab"><?php echo $mother_add ?></p></td>
				</tr>
				<tr>
					<td><h5>Emergency Contact</h5></td>
					<td><p id="emeg_contact" class="ab"><?php echo $emeg_contact ?></p></td>
					<td class="td_title"><h5>Address</h5></td>
					<td colspan="3"><p id="emeg_address" class="ab"><?php echo $emeg_add ?></p></td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td><h5>Tel No.</h5></td>
					<td colspan="3"><p id="emeg_tel" class="ab"><?php echo $emeg_tel ?></td>
				</tr>
				<tr>
					<td><h5>Beneficiary</h5></td>
					<td><p id="beneficiary" class="ab"><?php echo $beneficiary ?></td>
					<td><h5>Relationship</h5></td>
					<td colspan="3"><?php echo $benef_relation ?></td>
				</tr>
				<tr>
					<td><h5>Address</h5></td>
					<td colspan="5"><p id="benef_address" class="ab ab-input fw98"><?php echo $benef_add ?></p></td>
				</tr>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>

	<script type="text/javascript">
	    $(document).ready(function () {
	    	<?php if($crew_id): ?>
		    	var regcollection = new Regcollection();
		    	regcollection.id = <?php echo $crew_id; ?>; 
		    	var personalView = new PersonalView({collection: regcollection});
		    <?php else: ?>
		    	window.regModel = new RegModel();
	    		var personalView = new PersonalView();
	    	<?php endif; ?>
	    });
	</script>

	<!-- Script for autoloading on mobile device -->

	<script id="personal-add-template" type="text/template">
	<div class="inopts">
		<div class="control-group">
	        <label class="control-label" for="report_type">Report Type :</label>
	        <div class="controls">
	            <select name="report_type" id="report_type">
	            	<optgroup label="History Card">
						<option value="1">Standard</option>
						<option value="3">ECL Officer</option>
						<option value="4">ECL Ratings</option>
						<option value="5">Excel Officer</option>
						<option value="6">Excel Ratings</option>
						<option value="14">Wave Officer</option>
						<option value="15">Wave Ratings</option>
						<option value="16">FUYOH</option>
					</optgroup>
	            	<optgroup label="Documents">
						<option value="0">Checklist</option>
						<option value="11">Seafarer Employment</option>
						<option value="19">OFW Information Sheet</option>
					</optgroup>
					<optgroup label="POEA">
						<option value="9">Contract</option>
						<option value="18">Contract for Cadet</option>
						<option value="10">Information Sheet</option>
					</optgroup>
					<optgroup label="RPS">
						<option value="12">Regular</option>
						<option value="13">Verification</option>
					</optgroup>
				</select>
	        </div>
	    </div>
	    <div class="control-group ">
            <label class="control-label" for="inputyear">Effective Year :</label>
            <div class="controls">
                <select name="effective_year" id="effective_year">
                    <?php 
                        for ($x = $effective_year; $x <= date('Y', strtotime('+4 years')); $x++) {
                            echo "<option value='{$x}' >{$x}</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
	    <div class="control-group">
	        <label class="control-label" for="vessel_id">Vessel :</label>
	        <div class="controls">
	            <select name="vessel_id" id="pvessel_id">					
					<?php 
					if($vessels){
						foreach ($vessels as $v_value){ 
							echo "<option value='{$v_value->id}' " . (($vessel_id == $v_value->id)?  "selected='selected'" : "")  . " >{$v_value->vessel_name}</option>";
						} 
					}
					?>
				</select>
				<input type="hidden" name="crew_id" id="crew_id" value="<?php echo $crew_id; ?>">
	        </div>
	    </div>
	    <div class="control-group">
	        <label class="control-label" for="position_id">Position :</label>
	        <div class="controls">
	            <select name="position_id" id="pposition_id"></select>
	        </div>
	    </div>
	    <div class="control-group">
	        <label class="control-label" for="company_id">Company :</label>
	        <div class="controls">
	            <select name="company_id" id="pcompany_id">
	            	<option value="1">FAIR SHIPPING</option>
	            	<option value="2">CORDIAL SHIPPING</option>
	            </select>
	        </div>
	    </div>
	    <div class="control-group hiddenField" >
            <label class="control-label" for="Duration">Duration :</label>
            <div class="controls">
                <input type="text" name="duration" style="width: 80px;" placeholder="Duration in Month/s" value="1"  /> 
	            <select name="status" id="pstatus" style="width: 35%;">
	            	<option value="REG">Regular</option>
	            	<option value="EXT">Promotion/Extension</option>
	            </select>
            </div>
        </div>
	    <div class="control-group hiddenField" >
            <label class="control-label" for="point_of_hire">Point of Hire :</label>
            <div class="controls">
                <input type="text" name="point_of_hire" placeholder="Point of Hire" value="MANILA, PHILIPPINES"  /> 
            </div>
        </div>
	    <div class="control-group">
            <label class="control-label" for="Date">Date :</label>
            <div class="controls">
                <input type="text" name="date" style="width: 120px;" class="idate" placeholder="mm/dd/yyyy" value="<?php echo date('m/d/Y'); ?>"  />
            </div>
        </div>
	    <div class="control-group hiddenField2" >
            <label class="control-label" for="Signatory1"> Signatory 1 :</label>
            <div class="controls">
                <select name="signatory1">
                <?php 
                if($signatorys){
                    foreach ($signatorys as $value) {
                        echo "<option value='{$value->propername} - {$value->admin_position_id}' >{$value->propername}</option>";
                    }  
                }
                ?>
                </select>
            </div>
        </div> 

        <div class="control-group hiddenField2" id="signatory2">
            <label class="control-label" for="Signatory2"> Signatory 2 :</label>
            <div class="controls">
                <select name="signatory2" >
                <?php 
                if($signatorys){
                    foreach ($signatorys as $value) {
                        echo "<option value='{$value->propername} - {$value->admin_position_id}' >{$value->propername}</option>";
                    }  
                }
                ?>
                </select>
            </div>
        </div>

	</div>
	</script>

	<!-- Modal Add -->          
	<div class="modal hide fade" id="addGenerate">		
		<?php echo form_open('report-generator', 'class="form-horizontal" target="_blank"'); ?> 
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal">×</button>
			    <h3>Report <small>&raquo; Generator</small></h3>
			</div>
			<div class="modal-body">
		        <div id="container-personal-add"></div>
			</div>
			<div class="modal-footer">
			    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
			    <button type="submit" class="btn btn-success">Generate</button> 
			</div>
	    <?php echo form_close(); ?>  
	</div>
	<!-- End Add -->
</div>

<script type="text/javascript">
    $(document).ready(function () {

    	$('#report_type').bind('change', function() {
    		var that = this;
    		var array = ['11', '9', '10', '12', '13', '18'];
    		var array2 = ['0', '9', '12', '13', '18'];

			if(array.indexOf(that.value) > -1) {
    			$('.hiddenField').show();
			} else {
				$('.hiddenField').hide();
			}

			if(array2.indexOf(that.value) > -1) {
    			$('.hiddenField2').show();

    			if(that.value == 9 || that.value == 18) {
    				$('#signatory2').hide();
    			} else {
    				$('#signatory2').show();
    			}
			} else {
				$('.hiddenField2').hide();
			}
    	}); 

        $('#pvessel_id').bind('change', function() {
        	var that = this;

	        $.ajax({
	            url     : BASE_URL + 'report/load-position',
	            data    : { ids : that.value, effective_year : $('#effective_year').val() },
	            type    : 'POST',
	            success : function(data){
	                var $select = $('#pposition_id');  

	                $select.find('option').remove();

	                if(data != false) {
	                    if(data.entry.length == 0 ) {                        
	                        $select.attr('disabled', 'disabled');
	                    } else {
	                        $select.removeAttr('disabled');
	                    }
	                    $.each(data.entry,function(key, value) {
	                        var selected = '';
	                        if(value['id'] === <?php echo $position_id; ?>) {
	                            selected = "selected='selected'";
	                        }

	                        $select.append('<option value=' + value['id'] + ' ' + selected + '>' + value['position'] + '</option>');
	                    });

	                }
	                
	            }
	        });
		});

        $('#effective_year').bind('change', function() {
        	var that = this;

	        $.ajax({
	            url     : BASE_URL + 'report/load-position',
	            data    : { effective_year : that.value, ids : $('#pvessel_id').val() },
	            type    : 'POST',
	            success : function(data){
	                var $select = $('#pposition_id');  

	                $select.find('option').remove();

	                if(data != false) {
	                    if(data.entry.length == 0 ) {                        
	                        $select.attr('disabled', 'disabled');
	                    } else {
	                        $select.removeAttr('disabled');
	                    }
	                    $.each(data.entry,function(key, value) {
	                        var selected = '';
	                        if(value['id'] === <?php echo $position_id; ?>) {
	                            selected = "selected='selected'";
	                        }

	                        $select.append('<option value=' + value['id'] + ' ' + selected + '>' + value['position'] + '</option>');
	                    });

	                }
	                
	            }
	        });
		}); 

		$('#effective_year').trigger('change');
		$('#pvessel_id').trigger('change');
		$('#report_type').trigger('change');   
    });
</script>  