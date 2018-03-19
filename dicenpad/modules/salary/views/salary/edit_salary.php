<script id="option-edit-template" type="text/template">
    <div class="control-group popover-title">
        <h3><%= (position)? position : '' %> </h3>
        <h5>Effective Year <span class="pull-right"><%= (effective_year)? effective_year : '' %></span></h5>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputbasic_salary">Basic Salary :</label>
        <div class="controls">
            <input type="hidden" name="position_id" class="ab" value="<%= (position_id)? position_id : '0' %>" />
            <input type="text" name="basic_salary" class="ab" placeholder="USD 0.00" value="<%= (basic_salary)? basic_salary : '0.00' %>" id="inputbasic_salary" />
        </div>
    </div>

    <div class="span-extended2">
        <div class="control-group">
            <label class="control-label" for="inputot_fixed">O.T (Fixed) :</label>
            <div class="controls">
                <input type="text" name="ot_fixed" class="ab" placeholder="USD 0.00" value="<%= (ot_fixed)? ot_fixed : 'USD 0.00' %>" style="width: 70px;" id="inputot_fixed" />
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label" for="inputot_hourly">O.T (Hourly) :</label>
            <div class="controls">
                <input type="text" name="ot_hourly" class="ab" placeholder="USD 0.00" value="<%= (ot_hourly)? ot_hourly : 'USD 0.00' %>" style="width: 70px;" id="inputot_hourly" />
            </div>
        </div>
    </div>
    <div class="span-extended2">
        <div class="control-group">
            <label class="control-label" for="inputt_allowance">T. Allowance :</label>
            <div class="controls">
                <input type="text" name="t_allowance" class="ab" placeholder="USD 0.00" value="<%= (t_allowance)? t_allowance : 'USD 0.00' %>" style="width: 70px" id="inputt_allowance" />
             </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputs_allowance">S. Allowance :</label>
            <div class="controls">
                <input type="text" name="s_allowance" class="ab" placeholder="USD 0.00" value="<%= (s_allowance)? s_allowance : 'USD 0.00' %>" style="width: 70px" id="inputs_allowance" />
            </div>
        </div>
    </div>

    <div class="span-extended2">
        <div class="control-group">
            <label class="control-label" for="inputrtmt_fee">RTMT Fee :</label>
            <div class="controls">
                <input type="text" name="rtmt_fee" class="ab" placeholder="USD 0.00" value="<%= (rtmt_fee)? rtmt_fee : 'USD 0.00' %>" style="width: 70px" id="inputrtmt_fee" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputother_benefits">Other Benefits :</label>
            <div class="controls">
                <input type="text" name="other_benefits" class="ab" placeholder="USD 0.00" value="<%= (other_benefits)? other_benefits : 'USD 0.00' %>" style="width: 70px" id="inputother_benefits" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputleave_pay">Leave Pay :</label>
            <div class="controls">
                <input type="text" name="leave_pay" class="ab" placeholder="USD 0.00" style="width: 70px" value="<%= (leave_pay)? leave_pay : 'USD 0.00' %>" id="inputleave_pay" />
            </div>
        </div>
    </div>
    <div class="span-extended2">
        <div class="control-group">
            <label class="control-label" for="inputnos_slot">Nos. Slots :</label>
            <div class="controls">
                <input type="text" name="nos_slot" class="ab" value="<%= (nos_slot)? nos_slot : '0' %>" style="width: 70px" id="inputnos_slot" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputnos_hours">Nos. Hours :</label>
            <div class="controls">
                <input type="text" name="nos_hours" class="ab" value="<%= (nos_hours)? nos_hours : '0' %>" style="width: 70px" id="inputnos_hours" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputleave_day">Leave per Mos :</label>
            <div class="controls">
                <input type="text" name="leave_day" class="ab" value="<%= (leave_day)? leave_day : '0' %>" style="width: 70px" id="inputleave_day" placeholder="0" />
            </div>
        </div>
    </div>
</script>

<!-- Modal Edit -->          
<div class="modal hide fade" id="editData">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Salary <small>&raquo; Setup</small></h3>
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