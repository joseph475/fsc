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
                <label class="control-label" for="inputSent" style="width: 80px;">Date Sent :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="date_sent" id="inputSent" class="ddate" value="<%= (ds)? ds : '' %>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputSentThru" style="width: 80px;">Sent Thru:</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="sent_thru" id="inputSentThru" value="<%= (sent_thru)? sent_thru : '' %>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputAwb_no" style="width: 80px;">AWB Nos:</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="awb_no" id="inputAwb_no" value="<%= (awb_no)? awb_no : '' %>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputSend_by" style="width: 80px;">Sent By:</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="send_by" id="inputSend_by" value="<%= (send_by)? send_by : '' %>" />
                </div>
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData" style="width: 800px; margin: -250px 0 0 -390px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Send Docs<small>&raquo; Setup</small></h3>
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