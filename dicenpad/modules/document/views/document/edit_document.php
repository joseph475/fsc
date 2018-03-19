<script id="option-edit-template" type="text/template">
    <div class="inopt">
        <div class="control-group">
            <label class="control-label" for="inputOption">Description :</label>
            <div class="controls">
                <input type="text" name="document" value="<%= document  %>" id="inputOption"  />
                <input type="hidden" name="classify_id" value="<%= classify_id %>" />
                <input type="hidden" name="hasflag" value="0" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="code">Code :</label>
            <div class="controls">
                <input type="text" name="code" value="<%= code  %>" id="code"  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="sort_order">Sort Order :</label>
            <div class="controls">
                <input id="sort_order" type="text" name="sort_order" value="<%= sort_order  %>" placeholder="0" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="flag_id">Flag :</label>
            <div class="controls">
                <select name="flag_id" id="flag_id">
                    <option value=''>&nbsp;</option>
                    <?php 
                    if($flags){
                        foreach ($flags as $value) {
                            echo "<option value='{$value->id}'>{$value->flag}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="division_id">Division :</label>
            <div class="controls">
                <select name="division_id" id="division_id">
                    <option value='0'>Both</option>
                    <option value='1'>Officers</option>
                    <option value='2'>Ratings</option>                    
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="department_id">Department :</label>
            <div class="controls">
                <input type="checkbox" value="1" name="isdeck_off" class="isdeck_off" <%= (isdeck_off== 1)? "checked='checked'" : '' %> /> Deck Officer<br/>
                <input type="checkbox" value="1" name="isdeck_rat" class="isdeck_rat" <%= (isdeck_rat == 1)? "checked='checked'" : '' %> /> Deck Ratings<br/>
                <input type="checkbox" value="1" name="isengine_off" class="isengine_off" <%= (isengine_off == 1)? "checked='checked'" : '' %>/> Engine Officer<br/>
                <input type="checkbox" value="1" name="isengine_rat" class="isengine_rat" <%= (isengine_rat == 1)? "checked='checked'" : '' %>/> Engine Ratings<br/>
                <input type="checkbox" value="1" name="iscatering" class="iscatering" <%= (iscatering == 1)? "checked='checked'" : '' %>/> Catering <br/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputInactive">Published :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="published" <%= (published == 1)? "checked='checked'" : '' %>  id="inputinactive" /> Yes
                <input type="radio" value="0" name="published" <%= (published == 0)? "checked='checked'" : '' %> id="inputinactive" /> No
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputDefault">Default :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="defaults" <%= (defaults == 1)? "checked='checked'" : '' %>  id="defaults" /> Yes
                <input type="radio" value="0" name="defaults" <%= (defaults == 0)? "checked='checked'" : '' %> id="defaults" /> No
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Documents <small>&raquo; Setup</small></h3>
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