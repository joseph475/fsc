<script id="option-edit-template" type="text/template">
    <div class="inopt">
        <div class="control-group">
            <label class="control-label" for="inputPosition">Position :</label>
            <div class="controls">
                <input id="inputposition"type="text" name="position" value="<%= position %>" id="inputposition" />
                <input type="hidden" name="department_id" value="<%= department_id %>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="code">Code :</label>
            <div class="controls">
                <input type="text" name="code" value="<%= code %>" id="code"  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="alternate">Alternate :</label>
            <div class="controls">
                <input type="text" name="alternate" value="<%= alternate %>" id="alternate"  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputDivision">Division :</label>
            <div class="controls">
                <select style="width:30%;" name="division_id" id="selectdivision">
                <?php 
                if($division_record){
                    foreach ($division_record as $value) {
                        echo "<option value='{$value->id}' ";
                    ?>
                    <%= (division_id == "<?php echo $value->id ?>")? 'selected="selected"' : '' %>
                    <?php
                        echo ">{$value->option}</option>";
                    } 
                 }
                ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="sort_order">Sort Order :</label>
            <div class="controls">
                <input type="text" name="sort_order" value="<%= sort_order %>" id="sort_order"  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputInactive">Published :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="inactive" <%= (inactive == 1)? "checked='checked'" : '' %>  id="inactive" /> Yes
                <input type="radio" value="0" name="inactive" <%= (inactive == 0)? "checked='checked'" : '' %> id="inactive" /> No
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Options <small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div id="container-option-edit"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-primary" id="options-update">Submit Changes</a>
    </div>
</div>
<!-- End Edit -->