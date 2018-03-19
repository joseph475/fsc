<script id="option-edit-template" type="text/template">
    <div class="inopts">
        <div class="control-group popover-title">
            <h3><%= (fullname)? fullname : '' %> <span class="pull-right"><%= (crew_id)? crew_id : 0 %></span></h3>
            <h5><%= (position)? position : '' %> <span class="pull-right"><%= (vessel_name)? vessel_name : '' %></span></h5>
        </div>
        <div class="control-group">
            <label class="control-label" for="remarks">Remarks :</label>
            <div class="controls">
                <textarea name="remarks" id="remarks"><%= remarks %></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="published">Published : </label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="published" <%= (published == 1)? "checked='checked'" : '' %>  id="published" /> Yes
                <input type="radio" value="0" name="published" <%= (published == 0)? "checked='checked'" : '' %> id="published" /> No
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="remark">File :</label>
            <div class="controls">
                <span class="btn fileinput-button">
                    <i class="icon-plus icon-black"></i>
                    <span>Change file...</span>
                    <input type="file" name="userfile" id="userfiles">
                </span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="date_receive">File Date :</label>
            <div class="controls">
                <input class="ddate" type="text" placeholder="00/00/0000" name="date_receive" value="<%= date_receive %>" />
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Conduct <small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form method="post" action="" id="upload_file" class="form-horizontal">
            <div id="container-option-edit"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-primary" id="options-update">Submit Changes</a>
    </div>
</div>
<!-- End Edit -->