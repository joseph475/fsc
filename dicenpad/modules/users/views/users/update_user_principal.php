<div style="margin-bottom: 50px"></div>

<div class="container-fluid container-narrow" id="user-module">
	<div class="row-fluid">    
        <div class="span12">
			<div class="page-header">
				<h2>User Manager <small>» Edit Record</small></h2>
			</div>
			<div class="row-fluid inopts">
				<div id="alert-div"></div>
			    <form id='form-modal' class="form-horizontal" autocomplete="off">    
			       	<div class="span6">
			            <div class="control-group" style="border-bottom:1px solid #eee;padding-bottom:5px;">
			                <div class="control-group">
			                    <label class="control-label" for="inputlast">Last Name :</label>
			                    <div class="controls">
			                        <input id="inputlast" type="text" name="last_name" value="<?php echo isset($lastname)? $lastname : '' ?>" class="validate[required]" />
			                    </div>
			                </div>
			                <div class="control-group">
			                    <label class="control-label" for="inputfirst">First Name :</label>
			                    <div class="controls">
			                        <input id="inputfirst" type="text" name="first_name" value="<?php echo isset($firstname)? $firstname : '' ?>" class="validate[required]"  />
			                    </div>
			                </div>
			                <div class="control-group" >
			                    <label class="control-label" for="inputmiddle">Middle Name :</label>
			                    <div class="controls">
			                        <input id="inputmiddle" type="text" name="middle_name" value="<?php echo isset($middlename)? $middlename : '' ?>"  />
			                    </div>
			                </div>
			            </div>
			            <div class="control-group">
			                <label class="control-label" for="inputInactive">Published :</label>
			                <div class="controls" style="padding-top: 5px;">
			                    <input type="radio" value="1" name="inactive" <?php echo ($inactive == 1)? "checked='checked'" : '' ?>  id="inactive" /> Yes
                   				<input type="radio" value="0" name="inactive" <?php echo ($inactive == 0)? "checked='checked'" : '' ?> id="inactive" /> No
			                </div>
			            </div>

			            <div class="control-group">
			                <label class="control-label" for="company_id">Company :</label>
			                <div class="controls">
			                    <select name="company_id" id="company_id">
			                    <?php 
			                        if($companys) {
			                            foreach ($companys as  $value) {
			                                echo "<option value='{$value->company_id}' ";
			                                echo ($company_id == $value->company_id)? 'selected="selected"' : '';
											echo ">{$value->company}</option>";
			                            } 
			                        }
			                    ?>
			                    </select>
			                </div>
			            </div>

			            <div class="control-group">
			                <label class="control-label" for="role_id">Principal :</label>
			                <div class="controls">
			                    <select name="principal_id" id="principal_id">
			                    <?php 
			                        if($principals) {
			                            foreach ($principals as $value) {
			                            	echo "<option value='{$value->id}' ";
			                                echo ($principal_id == $value->id)? 'selected="selected"' : '';
											echo ">{$value->fullname}</option>";
				                        } 
			                        }
			                    ?>
			                    </select>
			                </div>
			            </div>

			            <div class="control-group">
			                <label class="control-label" for="role_id">Group :</label>
			                <div class="controls">
			                    <select name="role_id" id="role_id">
			                    <?php 
			                        if($roles) {
			                            foreach ($roles as $value) {
			                            	echo "<option value='{$value->role_id}' ";
			                                echo ($role_id == $value->role_id)? 'selected="selected"' : '';
											echo ">{$value->role}</option>";
				                        } 
			                        }
			                    ?>
			                    </select>
			                </div>
			            </div>
			            <div class="control-group">
			                <label class="control-label" for="department_id">Department :</label>
			                <div class="controls">
			                    <select name="department_id" id="department_id">
			                    <?php 
			                    if($departments){
			                        foreach ($departments as $value) {
			                        	echo "<option value='{$value->department_id}' ";
		                                echo ($department_id == $value->department_id)? 'selected="selected"' : '';
										echo ">{$value->department}</option>";
			                        } 
			                     }
			                    ?>
			                    </select>
			                </div>
			            </div>
			            <div class="control-group">
			                <label class="control-label" for="form_id">Position :</label>
			                <div class="controls">
			                    <select name="position_id" id="position_id">
			                    <?php 
			                        if($positions){
			                        foreach ($positions as $value) {
			                        	echo "<option value='{$value->position_id}' ";
		                                echo ($position_id == $value->position_id)? 'selected="selected"' : '';
										echo ">{$value->position}</option>";
			                        } 
			                     }
			                    ?>
			                    </select>
			                </div>
			            </div>
			            <div class="control-group">
			                <div class="controls">
			                    <button type="button" id="submit-btn" class="btn-large btn-primary">Submit</button>
								<div id="msg-container"></div>
			                </div>
			            </div>
			           	
			        </div>
			        <div class="span6">
			            <div class="control-group">
			                <label class="control-label" for="inputemail">Email :</label>
			                <div class="controls">
			                    <input id="inputemail" type="text" name="email" value="<?php echo isset($email)? $email : '' ?>" class="validate[required,custom[email]]"  />
			                </div>
			            </div>
			            <div class="control-group">
			                <label class="control-label" for="username">Username :</label>
			                <div class="controls">
			                    <input type="text" name="username" value="<?php echo isset($login)? $login : '' ?>" class="disabled" readonly="readonly"/>
			                </div>
			            </div>
			            <div class="control-group">
			                <label class="control-label" for="inputpassword">Password :</label>
			                <div class="controls">
		                     	<a class="btn change-password" rel="tooltip" title="Change Password" 
                    			href="javascript:void(0);" data-toggle="modal">
                    				<i class="icon-edit"></i> Change Password?
                    			</a>
			                </div>
			            </div>
			        </div>
			    </div>
			</form>
		</div>
	</div>

	<!-- Modal Add -->          
	<div class="modal hide fade" id="changePass">    
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Change Password <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body inopt">
	        <form id='form-modal' class="form-horizontal " autocomplete="off">
		        <div class="control-group">
		            <div class="control-group">
		                <label class="control-label" for="inputpassword">Password :</label>
		                <div class="controls">
		                    <input id="inputpassword" type="password" name="password" value="" class="validate[required]"  />
		                </div>
		            </div>
		            <div class="control-group">
		                <label class="control-label" for="inputconfirm">Confirm Password :</label>
		                <div class="controls">
		                    <input id="inputconfirm" type="password" name="confirm" value="" class="validate[required,equals[inputpassword]]" />
		                </div>
		            </div>
		        </div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <button href="#" class="btn btn-success" id="change-pass">Submit</button>
	    </div>     
	</div>
	<!-- End Add -->	
</div>

<script type="text/javascript">
    $(document).ready(function () {
    	$('.alert').alert();
    	<?php if($user_id): ?>
	    	var regcollection = new Regcollection();
	    	regcollection.id = <?php echo $user_id; ?>;  
	    	var aboutView = new AboutView({collection: regcollection});
	    <?php else: ?>
	    	window.regModel = new RegModel();
    		var aboutView = new AboutView({model: regModel});
    	<?php endif; ?>	
    });
</script>

<script type="text/template" id="alertTemplate">
	<div class="alert alert-<%= type %>">
		<button class="close" data-dismiss="alert" type="button">×</button>
		<%= message %>
	</div>
</script>  


