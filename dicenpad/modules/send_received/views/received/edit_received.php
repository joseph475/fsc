<script id="option-edit-template" type="text/template">
    <div class="inopt">
        <div class="control-group popover-title">
            <h3><%= (fullname)? fullname : '' %> <span class="pull-right"><%= (crew_id)? crew_id : 0 %></span></h3>
            <h5><%= (position)? position : '' %> <span class="pull-right"><%= (vessel_name)? vessel_name : '' %></span></h5>
        </div>
        <div class="control-group">
            <label class="control-label" for="date_received">Date Received :</label>
            <div class="controls">
                <input id="date_received" class="ddate" type="text" placeholder="00/00/0000" name="date_received" value="<%= (dte_rec)? dte_rec : '' %>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="date_check">Date Check :</label>
            <div class="controls">
                <input id="date_check" class="ddate" type="text" placeholder="00/00/0000" name="date_check" value="<%= (dte_check)? dte_check : '' %>" />
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData">
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
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-primary" id="options-update">Submit Changes</a>
    </div>
</div>
<!-- End Edit -->