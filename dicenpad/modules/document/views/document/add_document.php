<script id="option-add-template" type="text/template">
    <div class="inopts">
        <div class="control-group">
            <label class="control-label" for="inputOption">Description :</label>
            <div class="controls">
                <input id="inputOption" type="text" name="document" value="" id="document" />
                <input type="hidden" name="classify_id" value="" />
                <input type="hidden" class="ab" name="hasflag" value="0" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="code">Code :</label>
            <div class="controls">
                <input id="code" type="text" name="code" value=""  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="sort_order">Sort Order :</label>
            <div class="controls">
                <input id="sort_order" type="text" name="sort_order" value="" placeholder="0" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="flag_id">Flag :</label>
            <div class="controls">
                <select name="flag_id">
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
                <select name="division_id">
                    <option value='0'>Both</option>
                    <option value='1'>Officers</option>
                    <option value='2'>Ratings</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="department_id">Department :</label>
            <div class="controls">
                <input type="checkbox" value="1" name="isdeck_off" class="isdeck_off" /> Deck Officer<br/>
                <input type="checkbox" value="1" name="isdeck_rat" class="isdeck_rat" /> Deck Ratings<br/>
                <input type="checkbox" value="1" name="isengine_rat" class="isengine_rat" /> Engine Officer<br/>
                <input type="checkbox" value="1" name="isengine_off" class="isengine_off" /> Engine Ratings<br/>
                <input type="checkbox" value="1" name="iscatering" class="iscatering" /> Catering 
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="inputInactive">Published :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="published" checked="checked" id="published" /> Yes
                <input type="radio" value="0" name="published" id="published" /> No
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputDefault">Default :</label>
            <div class="controls" style="padding-top: 5px;">
                <input type="radio" value="1" name="defaults" checked="checked" id="defaults" /> Yes
                <input type="radio" value="0" name="defaults" id="defaults" /> No
            </div>
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="addData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Add Documents <small>&raquo; Setup</small></h3>
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