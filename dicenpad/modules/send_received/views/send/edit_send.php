<script id="option-edit-template" type="text/template">
    <div class="inopt row">
        <div class="span8" >
            <div class="control-group popover-title">
                <h3><%= (fullname)? fullname : '' %> <span class="pull-right"><%= (crew_id)? crew_id : 0 %></span></h3>
                <h5><%= (position)? position : '' %> <span class="pull-right"><%= (vessel_name)? vessel_name : '' %></span></h5>
            </div>
        </div>
        <div class="span4" >
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
                <label class="control-label" for="awb_no" style="width: 80px;">AWB No. :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input id="awb_no" type="text" name="awb_no" value="<%= (awb_no)? awb_no : '' %>" placeholder="0" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="sent_thru" style="width: 80px;">Sent Thru :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input id="sent_thru" type="text" name="sent_thru" value="<%= (sent_thru)? sent_thru : '' %>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="date_sent" style="width: 80px;">Date Sent :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input id="date_sent" class="ddate" type="text" placeholder="00/00/0000" name="date_sent" value="<%= (date_sent)? date_sent : '' %>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="send_by_others" style="width: 80px;">Send By:</label>
                <div class="controls" style="margin-left: 100px;">
                    <input id="send_by_others" type="text" name="send_by_others" value="<%= (send_by_others)? send_by_others : '' %>" />
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
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-primary" id="options-update">Submit Changes</a>
    </div>
</div>
<!-- End Edit -->