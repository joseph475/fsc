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
                <label class="control-label" for="inputSent" style="width: 80px;">Date Sent :</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="date_sent" id="inputSent" class="ddate" value="<?= date('m/d/y'); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputSentThru" style="width: 80px;">Sent Thru:</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="sent_thru" id="inputSentThru" value="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputAwb_no" style="width: 80px;">AWB Nos:</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="awb_no" id="inputAwb_no" value="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputSend_by" style="width: 80px;">Sent By:</label>
                <div class="controls" style="margin-left: 100px;">
                    <input type="text" name="send_by" id="inputSend_by" value="" />
                </div>
            </div>
        </div>
    </div>
</script>

 <!-- Modal Add -->          
<div class="modal hide fade" id="addData" style="width: 800px; margin: -250px 0 0 -390px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Add Send Docs <small>&raquo; Setup</small></h3>
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
