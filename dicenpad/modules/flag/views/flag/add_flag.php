<script id="option-add-template" type="text/template">
    <div class="inopts">
        <div class="control-group ">
            <label class="control-label" for="inputflag">Option :</label>
            <div class="controls">
                <input id="inputflag" type="text" name="flag" value=""/>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label" for="inputcode">Option Code :</label>
            <div class="controls">
                <input id="inputcode" type="text" name="code" value=""  />
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label" for="inputInactive">Published :</label>
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
        <h3>Add Flag <small>&raquo; Setup</small></h3>
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