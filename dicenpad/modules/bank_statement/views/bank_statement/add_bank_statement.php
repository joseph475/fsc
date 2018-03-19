<script id="option-add-template" type="text/template">
    <div class="inopts">
        <div class="control-group">
            <label class="control-label" for="crew_id">Crew :</label>
            <div class="controls">
                <input id="crew_id" type="text" placeholder="Crew ID" name="crew_id" value=""  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="amount">Amount :</label>
            <div class="controls">
                <input id="amount" type="text" name="amount" value=""  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="type">Type :</label>
            <div class="controls">
                <select id="type" name="type" style="width: 170px;">
                    <option value="AUB">AUB</option>
                    <option value="CA">CA</option>
                </select>
                <input id="prefix" type="text" name="prefix" value="" placeholder="Nos" style="width: 10%;" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="remarks">Remarks :</label>
            <div class="controls">
                <textarea name="remarks" id="remarks"></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="date_issued">Date Issued :</label>
            <div class="controls">
                <input id="date_issued" class="ddate" type="text" name="date_issued" value=""  />
            </div>
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="addData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Add Loan <small>&raquo; Setup</small></h3>
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