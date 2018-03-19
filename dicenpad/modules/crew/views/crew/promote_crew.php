<script id="option-promote-template" type="text/template">
    <div class="inopts">
         <div class="control-group popover-title">
            <h3><%= fullname %> <span class="pull-right"><%= crew_id %></span></h3>
            <h5><%= position %> </h5>
            <input type="hidden" value="<%= (crew_id)? crew_id : 0 %>" name="crew_id" />
            <input type="hidden" value="<?php echo isset($vessel_id)? $vessel_id : 0; ?>" name="vessel_id" />
            <input type="hidden" value="<%= (position_id)? position_id : 0 %>" name="prev_pos_id" />
        </div>
        <div class="control-group">
            <label class="control-label" for="new_pos_id">New Position :</label>
            <div class="controls">
                <select name="new_pos_id" id="new_pos_id">
                    <?php 
                    if($positions){
                        foreach ($positions as $value){ 
                            echo "<option value='{$value->id}'>{$value->position}</option>";
                        } 
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="remarks">Remarks :</label>
            <div class="controls">
                <textarea name="remarks" id="remarks"></textarea>
            </div>
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="promoteData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Crew Promotion <small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div id="container-option-promote"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-success" id="options-submit" data-dismiss="modal">Submit</a>
    </div>
</div>
<!-- End Add -->