<script id="option-add-template" type="text/template">
    <div class="inopts">
        <div class="control-group inopts">
            <label class="control-label" for="title">Form :</label>
            <div class="controls">
                <input id="title" type="text" name="title" value="" />
            </div>
        </div>
        <div class="control-group inopts">
            <label class="control-label" for="control_nos">FSC Control Nos. :</label>
            <div class="controls">
                <input id="control_nos" type="text" name="control_nos" value=""  />
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label" for="remarks">FSC Remarks :</label>
            <div class="controls">
                <input id="remarks" type="text" name="remarks" value=""  />
            </div>
        </div>
        <div class="control-group inopts">
            <label class="control-label" for="control_nos2">CSI Control Nos. :</label>
            <div class="controls">
                <input id="control_nos2" type="text" name="control_nos2" value=""  />
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label" for="remarks2">CSI Remarks :</label>
            <div class="controls">
                <input id="remarks2" type="text" name="remarks2" value=""  />
            </div>
        </div>
        <div class="control-group inopts">
            <label class="control-label" for="published">Published :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="published" checked="checked" id="published" /> Yes
                <input type="radio" value="0" name="published" id="published" /> No
            </div>
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="addData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Add Form <small>&raquo; Setup</small></h3>
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