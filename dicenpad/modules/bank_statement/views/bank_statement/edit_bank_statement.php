<script id="option-edit-template" type="text/template">
    <div class="inopt">
        <div class="control-group popover-title">
            <h3><%= (fullname)? fullname : '' %> <span class="pull-right"><%= (crew_id)? crew_id : 0 %></span></h3>
            <h5><%= (position)? position : '' %> <span class="pull-right"><%= (vessel_name)? vessel_name : '' %></span></h5>
        </div>
        <div class="control-group">
            <label class="control-label" for="amount">Amount :</label>
            <div class="controls">
                <input id="amount" type="text" name="amount" value="<%= (amount)? amount : '' %>"  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="type">Type :</label>
            <div class="controls">
                <select id="type" name="type" style="width: 170px;">
                    <option value="AUB" <%= (type == 'AUB')? "selected='selected'" : '' %>>AUB</option>
                    <option value="CA" <%= (type == 'CA')? "selected='selected'" : '' %>>CA</option>
                </select>
                <input id="prefix" type="text" name="prefix" value="<%= (prefix)? prefix : '' %>" placeholder="Nos" style="width: 10%;" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="remarks">Remarks :</label>
            <div class="controls">
                <textarea name="remarks" id="remarks"><%= (remarks)? remarks : '' %></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="date_issued">Date Issued :</label>
            <div class="controls">
                <input class="ddate" type="text" name="date_issued" value="<%= (di)? di : '' %>"  />
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Loan <small>&raquo; Setup</small></h3>
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