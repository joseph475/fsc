<script id="option-add-template" type="text/template">
    <div class="inopts">
        <div class="control-group ">
            <label class="control-label" for="inputyear">Effective Year :</label>
            <div class="controls">
                <select name="effective_year" style="width: 90px;">
                    <?php 
                        for ($x = date('Y'); $x <= date('Y', strtotime('+2 years')); $x++) {
                            echo "<option value='{$x}' >{$x}</option>";
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="position_id">Position :</label>
            <div class="controls">
                <select name="position_id" id="position_id">
                <?php foreach ($positions as $value) {
                    echo "<option value='{$value->id}' >{$value->department} - {$value->position}</option>";
                } ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="inputbasic_salary">Basic Salary :</label>
            <div class="controls">
                <input type="text" name="basic_salary" placeholder="USD 0.00" value="" id="inputbasic_salary" />
            </div>
        </div>

        <div class="span-extended2">
            <div class="control-group">
                <label class="control-label" for="inputot_fixed">O.T (Fixed) :</label>
                <div class="controls">
                    <input type="text" name="ot_fixed" placeholder="USD 0.00" value="" style="width: 70px;" id="inputot_fixed" />
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label" for="inputot_hourly">O.T (Hourly) :</label>
                <div class="controls">
                    <input type="text" name="ot_hourly" placeholder="USD 0.00" value="" style="width: 70px;" id="inputot_hourly" />
                </div>
            </div>
        </div>
        <div class="span-extended2">
            <div class="control-group">
                <label class="control-label" for="inputt_allowance">T. Allowance :</label>
                <div class="controls">
                    <input type="text" name="t_allowance" placeholder="USD 0.00" value="" style="width: 70px" id="inputt_allowance" />
                 </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputs_allowance">S. Allowance :</label>
                <div class="controls">
                    <input type="text" name="s_allowance" placeholder="USD 0.00" value="" style="width: 70px" id="inputs_allowance" />
                </div>
            </div>
        </div>

        <div class="span-extended2">
            <div class="control-group">
                <label class="control-label" for="inputrtmt_fee">RTMT Fee :</label>
                <div class="controls">
                    <input type="text" name="rtmt_fee" placeholder="USD 0.00" value="" style="width: 70px" id="inputrtmt_fee" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputother_benefits">Other Benefits :</label>
                <div class="controls">
                    <input type="text" name="other_benefits" placeholder="USD 0.00" value="" style="width: 70px" id="inputother_benefits" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputleave_pay">Leave Pay :</label>
                <div class="controls">
                    <input type="text" name="leave_pay" value="" id="inputleave_pay" style="width: 70px" placeholder="USD 0.00" />
                </div>
            </div>
        </div>

        <div class="span-extended2">
            <div class="control-group">
                <label class="control-label" for="inputnos_slot">Nos. Slots :</label>
                <div class="controls">
                    <input type="text" name="nos_slot" placeholder="0" value="" style="width: 70px" id="inputnos_slot" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputnos_hours">Nos. Hours :</label>
                <div class="controls">
                    <input type="text" name="nos_hours" placeholder="0" value="" style="width: 70px" id="inputnos_hours" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputleave_day">Leave per Mos :</label>
                <div class="controls">
                    <input type="text" name="leave_day" value="" id="inputleave_day" style="width: 70px" placeholder="0" />
                </div>
            </div>
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="addData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Add Salary <small>&raquo; Setup</small></h3>
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