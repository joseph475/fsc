<script id="option-add-template" type="text/template">
    <div class="inopts">
        <div class="control-group">
            <label class="control-label" for="position">Position :</label>
            <div class="controls">
                <input id="inputposition" type="text" name="position" value="" id="position" />
                <input type="hidden" name="department_id" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="code">Code :</label>
            <div class="controls">
                <input id="code" type="text" name="code" value=""  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="alternate">Alternate :</label>
            <div class="controls">
                <input id="alternate" type="text" name="alternate" value=""  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="division_id">Division :</label>
            <div class="controls">
                <select style="width:30%;" name="division_id" id="selectdivision">
                <?php foreach ($division_record as $key => $value) {
                    echo "<option value='{$value->id}' >{$value->option}</option>";
                } ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="sort_order">Sort Order :</label>
            <div class="controls">
                <input id="code" type="text" name="sort_order" value=""  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputInactive">Published :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="inactive" checked="checked" id="inactive" /> Yes
                <input type="radio" value="0" name="inactive" id="inactive" /> No
            </div>
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="addData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Add Options <small>&raquo; Setup</small></h3>
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