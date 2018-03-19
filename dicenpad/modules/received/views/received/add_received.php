<script id="option-add-template" type="text/template">
    <div class="inopts row">
        <div class="span4">
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
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="crew_id">Crew :</label>
                <div class="controls">
                    <input type="hidden" id="datetoday" value="<?= date('Y-m-d'); ?>">
                    <select name="crew_id" class="ab" id="dicen"></select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="document">Document :</label>
                <div class="controls">
                    <textarea name="document" id="document"></textarea>
                    <div class="clearfix"></div>
                    <p class="help-inline"><small>Document must be separated by comma (,)</small></p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="remarks">Remarks :</label>
                <div class="controls">
                    <textarea name="remarks" id="remarks"></textarea>
                </div>
            </div>
        </div>
        <div class="span4" >
            <div class="control-group">
                <label class="control-label" for="inputReceived" style="width: 80px;">Date Received :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="date_received" id="inputReceived" class="ddate" value="<?php echo date('m/d/y'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputChecked" style="width: 80px;">Date Checked :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="date_check" id="inputChecked" class="ddate" value="<?php echo date('m/d/y'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputExpired" style="width: 80px;">Date Expired :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="date_expired" id="inputExpired" class="ddate" value="<?php echo date('m/d/y'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputFrom" style="width: 80px;">From:</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="receivedfrom" id="inputFrom" value="<?= $first_name . ' ' . $last_name; ?>" />
                </div>
            </div>
        </div>
    </div>
</script>
<!-- 
<label class="control-label" for="send_by_others" style="width: 80px;">Documents:</label>
<div class="controls" style="margin-left: 100px;">
    <div class="multiselect" id="jomdic"></div>
</div>
 -->
<script id="jpd" type="text/template"> 
    <input type="checkbox" name="docs_id" value="<%= docs_id %>"/> <%= (document)? document : '' %>
</script>

 <!-- Modal Add -->          
<div class="modal hide fade" id="addData" style="width: 800px; margin: -250px 0 0 -390px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Add Received Docs <small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div id="container-option-add"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0)" class="btn" data-dismiss="modal">Cancel</a>
        <a href="javascript:void(0)" class="btn btn-success" id="options-submit" >Submit</a>
    </div>
</div>
<!-- End Add -->
