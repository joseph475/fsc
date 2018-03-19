<script id="option-add-template" type="text/template">
    <div class="inopts row">
        <div class="control-group">
            <label class="control-label" for="crew_id">Vessel :</label>
            <div class="controls">
               <select name="vessel_id" id="vessel_id" >
                    <?php 
                    foreach ($vessels as $v_value){ 
                        echo "<option value='{$v_value->id}' >{$v_value->vessel_name}</option>";
                    } 
                    ?>
                </select>
                <input type="hidden" value="0" name="start_date" />
                <input type="hidden" value="0" name="end_date" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="crew_id">Crew :</label>
            <div class="controls">
               <select name="crew_id" class="ab" id="dicen">
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="remarks">Remarks :</label>
            <div class="controls">
                <textarea name="remarks" id="remarks"></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="published">Inactive :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="published" checked="checked" id="published" /> Yes
                <input type="radio" value="0" name="published" id="published" /> No
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="remark">File :</label>
            <div class="controls">
                <span class="btn fileinput-button">
                    <i class="icon-plus icon-black"></i>
                    <span>Select file...</span>
                    <input type="file" name="userfile" id="userfile">
                </span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="date_receive">File Date :</label>
            <div class="controls">
                <input class="ddate" type="text" placeholder="00/00/0000" name="date_receive" value="<?php echo date('m/d/y'); ?>" />
            </div>
        </div>
    </div>

</script>

 <!-- Modal Add -->          
<div class="modal hide fade" id="addData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Add Conduct <small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form method="post" action="" id="upload_file" class="form-horizontal">
            <div id="container-option-add"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-success" id="options-submit" >Submit</a>
    </div>
</div>
<!-- End Add -->