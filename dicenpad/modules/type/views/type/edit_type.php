<script id="option-edit-template" type="text/template">
    <div class="inopt">
        <div class="control-group">
            <label class="control-label" for="inputtitle">Title :</label>
            <div class="controls">
                <input id="inputtype" type="text" name="title" value="<%= (title)? title : '' %>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputcode">Code :</label>
            <div class="controls">
                <input id="inputcode" type="text" name="code" value="<%= (code)? code : '' %>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputtype">Type :</label>
            <div class="controls">
                <select name="type" id="type">
                    <option value="MV" <%= (type == 'MV')? 'selected="selected"' : '' %> >MV</option>
                    <option value="MT" <%= (type == 'MT')? 'selected="selected"' : '' %> >MT</option>
                </select>
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
        <h3>Edit Type <small>&raquo; Setup</small></h3>
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