<script id="option-add-template" type="text/template">
    <div class="inopts">
        <div class="control-group">
            <label class="control-label" for="salutation">Title :</label>
            <div class="controls">
                <input id="salutation" type="text" name="salutation" value="" />
                <div class="clearfix"></div>
                <p class="help-inline"><small>Ex. (Mr./Mrs./Ms./Engr.)</small></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="firstname">First Name :</label>
            <div class="controls">
                <input id="firstname" type="text" name="firstname" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="middlename">Middle Name :</label>
            <div class="controls">
                <input id="middlename" type="text" name="middlename" value=""  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="lastname">Last Name :</label>
            <div class="controls">
                <input id="lastname" type="text" name="lastname" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="admin_position_id">Label :</label>
            <div class="controls">
                <select style="width:40%;" name="admin_position_id" id="admin_position_id">
                    <option value='President'>President</option>
                    <option value='Vice President'>Vice President</option>
                    <option value='Liaison Officer'>Liaison Officer</option>
                    <option value='Crewing Manager'>Crewing Manager</option>
                    <option value='Prepared by'>Approved by</option>
                    <option value='Prepared by'>Prepared by</option>
                    <option value='Checked by'>Checked by</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="form_id">Form :</label>
            <div class="controls">
                <select name="form_id" id="form_id">
                    <option value='POEA or RPS' >POEA or RPS</option>
                    <option value='Expired Documents' >Expired Documents</option>
                    <option value='Checklist' >Checklist</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="published">Published :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="published" checked="checked" id="published" /> Yes
                <input type="radio" value="0" name="published" id="published" /> No
            </div>
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="addData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Add Signatory <small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div id="container-option-add"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-success" id="options-submit">Submit</a>
    </div>
</div>
<!-- End Add -->