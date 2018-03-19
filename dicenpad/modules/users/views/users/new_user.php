<div style="margin-bottom: 50px"></div>

<div class="container-fluid container-narrow" id="user-module">
	<div class="row-fluid">    
        <div class="span12">
			<div class="page-header">
				<h2>User Manager <small>» Add New</small></h2>
			</div>
			<div class="row-fluid inopts">
				<div id="alert-div"></div>
			    <form id='form-modal' class="form-horizontal" autocomplete="off">    
			       	<div class="span6">
			            <div class="control-group" style="border-bottom:1px solid #eee;padding-bottom:5px;">
			                <div class="control-group">
			                    <label class="control-label" for="inputlast">Last Name :</label>
			                    <div class="controls">
			                        <input id="inputlast" type="text" name="last_name" value="" class="validate[required]" />
			                        <input type="hidden" value="0"/>
			                    </div>
			                </div>
			                <div class="control-group">
			                    <label class="control-label" for="inputfirst">First Name :</label>
			                    <div class="controls">
			                        <input id="inputfirst" type="text" name="first_name" value="" class="validate[required]"  />
			                    </div>
			                </div>
			                <div class="control-group" >
			                    <label class="control-label" for="inputmiddle">Middle Name :</label>
			                    <div class="controls">
			                        <input id="inputmiddle" type="text" name="middle_name" value=""  />
			                    </div>
			                </div>
			            </div>
			            <div class="control-group">
			                <label class="control-label" for="inputInactive">Published :</label>
			                <div class="controls" style="padding-top: 5px;">
			                    <input type="radio" value="1" name="inactive" checked="checked" id="inactive" /> Yes
			                    <input type="radio" value="0" name="inactive" id="inactive" /> No
			                </div>
			            </div>
			            <div class="control-group">
			                <label class="control-label" for="company_id">Company :</label>
			                <div class="controls">
			                    <select name="company_id" id="company_id">
			                    <?php 
			                        if($companys) {
			                            foreach ($companys as  $value) {
			                                echo "<option value='{$value->company_id}' >{$value->company}</option>";
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
			                            foreach ($roles as  $value) {
			                                echo "<option value='{$value->role_id}' >{$value->role}</option>";
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
			                        if($departments) {
			                            foreach ($departments as  $value) {
			                                echo "<option value='{$value->department_id}' >{$value->department}</option>";
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
			                        if($positions) {
			                            foreach ($positions as  $value) {
			                                echo "<option value='{$value->position_id}' >{$value->position}</option>";
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
			                    <input id="inputemail" type="text" name="email" value="" class="validate[required,custom[email]]"  />
			                </div>
			            </div>
			            <div class="control-group">
			                <label class="control-label" for="inputlogin">Username :</label>
			                <div class="controls">
			                    <input id="inputlogin" type="text" name="login" value="" class="validate[required]"  />
			                </div>
			            </div>
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
			    </div>
			</form>
		</div>
	</div>	
</div>

<script type="text/javascript">
    $(document).ready(function () {
    	$('.alert').alert();
    	window.regModel = new RegModel();
		var aboutView = new AboutView({model: regModel});    	
    });
</script>

<script type="text/template" id="alertTemplate">
	<div class="alert alert-<%= type %>">
		<button class="close" data-dismiss="alert" type="button">×</button>
		<%= message %>
	</div>
</script>  
