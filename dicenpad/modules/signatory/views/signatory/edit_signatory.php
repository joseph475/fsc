<script id="option-edit-template" type="text/template">
    <div class="inopt">
        <div class="control-group">
            <label class="control-label" for="salutation">Title :</label>
            <div class="controls">
                <input id="salutation" type="text" name="salutation" value="<%= (salutation)? salutation : '' %>" />
                <div class="clearfix"></div>
                <p class="help-inline"><small>Ex. (Mr./Mrs./Ms./Engr.)</small></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="firstname">First Name :</label>
            <div class="controls">
                <input id="firstname" type="text" name="firstname" value="<%= (firstname)? firstname : '' %>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="middlename">Middle Name :</label>
            <div class="controls">
                <input id="middlename" type="text" name="middlename" value="<%= (middlename)? middlename : '' %>"  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="lastname">Last Name :</label>
            <div class="controls">
                <input id="lastname" type="text" name="lastname" value="<%= (lastname)? lastname : '' %>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="admin_position_id">Label :</label>
            <div class="controls">
                <select style="width:40%;" name="admin_position_id" id="admin_position_id">
                    <option value='President' <%= (admin_position_id == 'President')? 'selected="selected"' : '' %> >President</option>
                    <option value='>Vice President' <%= (admin_position_id == '>Vice President')? 'selected="selected"' : '' %> >>Vice President</option>
                    <option value='Liaison Officer' <%= (admin_position_id == 'Liaison Officer')? 'selected="selected"' : '' %> >Liaison Officer</option>
                    <option value='Crewing Manager' <%= (admin_position_id == 'Crewing Manager')? 'selected="selected"' : '' %> >Crewing Manager</option>
                    <option value='Approved by' <%= (admin_position_id == 'Approved by')? 'selected="selected"' : '' %> >Approved by</option>
                    <option value='Prepared by' <%= (admin_position_id == 'Prepared by')? 'selected="selected"' : '' %> >Prepared by</option>
                    <option value='Checked by' <%= (admin_position_id == 'Checked by')? 'selected="selected"' : '' %> >Checked by</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form_id">Form :</label>
            <div class="controls">
                <select name="form_id" id="form_id">
                    <option value='POEA or RPS' <%= (form_id == 'POEA or RPS')? 'selected="selected"' : '' %> >POEA or RPS</option>
                    <option value='Expired Documents' <%= (form_id == 'Expired Documents')? 'selected="selected"' : '' %> >Expired Documents</option>
                    <option value='Checklist' <%= (form_id == 'Checklist')? 'selected="selected"' : '' %> >Checklist</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="published">Published :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="published" <%= (published == 1)? "checked='checked'" : '' %> id="published" /> Yes
                <input type="radio" value="0" name="published" <%= (published == 0)? "checked='checked'" : '' %> id="published" /> No
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Signatory <small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div id="container-option-edit"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-primary" id="options-update">Submit Changes</a>
    </div>
</div>
<!-- End Edit -->