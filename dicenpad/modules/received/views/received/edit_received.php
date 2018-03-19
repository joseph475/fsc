<script id="option-edit-template" type="text/template">
    <div class="inopts row">
        <div class="span4">
            <div class="control-group popover-title">
                <h3><%= (fullname)? fullname : '' %> <span class="pull-right"><%= (crew_id)? crew_id : 0 %></span></h3>
                <h5><%= (position)? position : '' %> <span class="pull-right"><%= (vessel_name)? vessel_name : '' %></span></h5>
            </div>
            <div class="control-group">
                <label class="control-label" for="document">Document :</label>
                <div class="controls">
                    <textarea name="document" id="document"><%= (document)? document : '' %></textarea>
                    <div class="clearfix"></div>
                    <p class="help-inline"><small>Document must be separated by comma (,)</small></p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="remarks">Remarks :</label>
                <div class="controls">
                    <textarea name="remarks" id="remarks"><%= (remarks)? remarks : '' %></textarea>
                </div>
            </div>
        </div>
        <div class="span4" >
            <div class="control-group">
                <label class="control-label" for="inputReceived" style="width: 80px;">Date Received :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="date_received" id="inputReceived" class="ddate" value="<%= (dr)? dr : '' %>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputChecked" style="width: 80px;">Date Checked :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="date_check" id="inputReceived" class="ddate" value="<%= (dc)? dc : '' %>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputExpired" style="width: 80px;">Date Expired :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="date_expired" id="inputExpired" class="ddate" value="<%= (de)? de : '' %>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputFrom" style="width: 80px;">From:</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="receivedfrom" id="inputFrom" value="<%= (receivedfrom)? receivedfrom : '' %>" />
                </div>
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData" style="width: 800px; margin: -250px 0 0 -390px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Received Docs<small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div id="container-option-edit"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0)" class="btn" data-dismiss="modal">Cancel</a>
        <a href="javascript:void(0)" class="btn btn-primary" id="options-update">Submit Changes</a>
    </div>
</div>
<!-- End Edit -->