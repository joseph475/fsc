<script id="option-edit-template" type="text/template">
    <div class="inopt">
        <div class="control-group">
            <label class="control-label" for="inputOption">Option :</label>
            <div class="controls">
                <input id="inputOption" type="text" name="option" value="<%= option %>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputOptioncode">Option Code :</label>
            <div class="controls">
                <input id="inputoptioncode" type="text" name="option_code" value="<%= (option_code)? option_code : '' %>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputInactive">Published : </label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="inactive" <%= (inactive == 1)? "checked='checked'" : '' %>  id="inactive" /> Yes
                <input type="radio" value="0" name="inactive" <%= (inactive == 0)? "checked='checked'" : '' %> id="inactive" /> No
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Division <small>&raquo; Setup</small></h3>
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