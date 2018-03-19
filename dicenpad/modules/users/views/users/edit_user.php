<script id="option-edit-template" type="text/template">
    <div class="inopts row">
        <div class="span4">
            <div class="control-group" style="border-bottom:1px solid #eee;padding-bottom:5px;">
                <div class="control-group">
                    <label class="control-label" for="inputlast">Last Name :</label>
                    <div class="controls">
                        <input id="inputlast" type="text" name="last_name" value="<%= (last_name)? last_name : '' %>" class="validate[required]" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputfirst">First Name :</label>
                    <div class="controls">
                        <input id="inputfirst" type="text" name="first_name" value="<%= (first_name)? first_name : '' %>" class="validate[required]"  />
                    </div>
                </div>
                <div class="control-group" >
                    <label class="control-label" for="inputmiddle">Middle Name :</label>
                    <div class="controls">
                        <input id="inputmiddle" type="text" name="middle_name" value="<%= (middle_name)? middle_name : '' %>"  />
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputlogin">Username :</label>
                <div class="controls">
                    <input id="inputlogin" type="text" name="login" value="<%= (login)? login : '' %>" disabled="disabled" />
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
            <div class="control-group">
                <label class="control-label" for="inputInactive">Published :</label>
                <div class="controls" style="padding-top: 5px;">
                    <input type="radio" value="1" name="inactive" <%= (inactive == 1)? "checked='checked'" : '' %>  id="inactive" /> Yes
                    <input type="radio" value="0" name="inactive" <%= (inactive == 0)? "checked='checked'" : '' %> id="inactive" /> No
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputemail">Email :</label>
                <div class="controls">
                    <input id="inputemail" type="text" name="email" value="<%= (email)? email : '' %>" class="validate[required,custom[email]]"  />
                </div>
            </div>
        </div>
        <div class="span4">
            <div class="control-group">
                <label class="control-label" for="role_id" style="width: 80px;">Group :</label>
                <div class="controls" style="margin-left: 100px;">
                    <select name="role_id" id="role_id">
                    <?php 
                    if($roles){
                        foreach ($roles as $value) {
                            echo "<option value='{$value->role_id}' ";
                        ?>
                        <%= (role_id == "<?php echo $value->role_id ?>")? 'selected="selected"' : '' %>
                        <?php
                            echo ">{$value->role}</option>";
                        } 
                    }
                    ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="department_id" style="width: 80px;">Department :</label>
                <div class="controls" style="margin-left: 100px;">
                    <select name="department_id" id="department_id">
                    <?php 
                    if($departments){
                        foreach ($departments as $value) {
                            echo "<option value='{$value->department_id}' ";
                        ?>
                        <%= (department_id == "<?php echo $value->department_id ?>")? 'selected="selected"' : '' %>
                        <?php
                            echo ">{$value->department}</option>";
                        } 
                     }
                    ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form_id" style="width: 80px;">Position :</label>
                <div class="controls" style="margin-left: 100px;">
                    <select name="position_id" id="position_id">
                    <?php 
                    if($positions){
                        foreach ($positions as $value) {
                            echo "<option value='{$value->position_id}' ";
                        ?>
                        <%= (position_id == "<?php echo $value->position_id ?>")? 'selected="selected"' : '' %>
                        <?php
                            echo ">{$value->position}</option>";
                        } 
                     }
                    ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="editData" style="width: 800px; margin: -250px 0 0 -390px;">    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit User <small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form id='form-modal' class="form-horizontal">
            <div id="container-option-edit"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-primary" id="options-update">Submit Changes</a>
    </div>    
</div>
<!-- End Add -->