<script id="option-edit-template" type="text/template">
    <div class="inopt">
        <div class="control-group">
            <label class="control-label" for="flag">Flag :</label>
            <div class="controls">
                <input id="flag" type="text" name="flag" value="<%= (flag)? flag : '' %>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="code">Code :</label>
            <div class="controls">
                <input id="code" type="text" name="code" value="<%= (code)? code : '' %>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputInactive">Published : </label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="published" <%= (published == 1)? "checked='checked'" : '' %>  id="published" /> Yes
                <input type="radio" value="0" name="published" <%= (published == 0)? "checked='checked'" : '' %> id="published" /> No
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Flag <small>&raquo; Setup</small></h3>
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