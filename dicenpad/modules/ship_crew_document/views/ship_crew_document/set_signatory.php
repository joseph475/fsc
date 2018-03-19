<script id="option-set-template" type="text/template">
    <div class="inopts">
        <div class="control-group">
            <label class="control-label" for="poea1">Signatory :</label>
            <div class="controls">
                <select style="width:70%;" name="poea1" id="poea1">
                <?php 
                if($signatorys){
                    foreach ($signatorys as $value) {
                        if($value->admin_position_id != 'Liaison Officer'){
                            echo "<option value='{$value->propername}' >{$value->propername}</option>";
                        }
                    }  
                }
                ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="poea2">Liaison Officer :</label>
            <div class="controls">
                <select style="width:70%;" name="poea2" id="poea2">
                <?php 
                if($signatorys){
                    foreach ($signatorys as $value) {
                        if($value->admin_position_id == 'Liaison Officer'){
                            echo "<option value='{$value->propername}' >{$value->propername}</option>";
                        }
                    }  
                }
                ?>
                </select>
            </div>
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="setData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Set Signatory <small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div id="container-option-set"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-success" id="options-submit">Submit</a>
    </div>
</div>
<!-- End Add -->