<script id="option-add-template" type="text/template">
    <div class="inopts">
        <div class="control-group">
            <label class="control-label" for="department">Department :</label>
            <div class="controls">
                <input id="department" type="text" name="department" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="department_code">Department Code :</label>
            <div class="controls">
                <input id="department_code" type="text" name="department_code" value=""  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputInactive">Published :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="0" name="inactive" checked="checked" id="inactive" /> Yes
                <input type="radio" value="1" name="inactive" id="inactive" /> No
            </div>
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="addData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Add Department <small>&raquo; Setup</small></h3>
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