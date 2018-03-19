
<div class="row-section">
    <div class="row-title">REPAT CREW</div> 

    <div id="repat-info">
        <div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="repatpagination"></div> 

                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a id="repat_add-btn" class="btn btn-info" data-toggle="modal">
                    <i class="icon-plus"></i> Add
                </a> 
                <?php endif; ?>

                <span id="loader-r-container"></span>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alert4-div"></div> 
                
                <table class="responsive-table table-attr-center" id="options-table-repat" style="margin-bottom: 15px;">
                    <thead>
                        <tr>
                            <th width="2%"><center>Nos</center></th>
                            <th width="9%"><center>Rank</center></th>                                
                            <th width="48%">Name</th>
                            <th width="6%"><center>Joining Date</center></th>
                            <th width="9%"><center>Contract Duration</center></th>
                            <th width="22%"><center>Remarks</center></th>
                            <th width="2%"><center>Actions</center></th>
                            <th width="2%"><center>Disembark</center></th>
                        </tr>
                    </thead>
                    <tbody></tbody>                            
                </table>

                <table class="responsive-table table-attr-center inoptsinfo" style="margin-bottom: 15px;">
                    <tr>    
                        <td style="width: 15%; text-align: right;"><h5>Off-Signers</h5></td>
                        <td style="width: 10%;"><?php echo isset($off_signers)? $off_signers : '0'; ?><input type="hidden" name="off_signers" value="<?php echo isset($offsigners)? $offsigners : '0'; ?>"  /></td>
                        <td style="width: 15%; text-align: right;"><h5>Arrival</h5></td>
                        <td style="width: 15%;"><?php echo isset($j_date)? date('m/d/Y', strtotime('+1 day', strtotime($j_date)))  : ''; ?><input type="hidden" name="arrival" value="<?php echo isset($j_date)? date('m/d/Y', strtotime('+1 day', strtotime($j_date)))  : ''; ?>"></td>
                        <td style="width: 20%; text-align: right;"><h5>Airfare (Per Crew)</h5></td>
                        <td style="width: 25%;"><?php echo isset($airfare2)? $airfare2 : ''; ?><input type="hidden" value="<?php echo isset($airfare2)? $airfare2 : ''; ?>" name="airfare2"/></td>
                    </tr>                          
                </table>

                <div class="row-title">REPAT FLIGHT DETAILS</div>     
                <table class="responsive-table table-attr-center">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Flight Schedule</th>
                            <th style="width: 10%;">Date</th>    
                            <th style="width: 19%;">Flight No.</th>
                            <th style="width: 19%;">Origin/Destination</th>
                            <th style="width: 10%;">Time</th>
                            <th style="width: 27%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if($repat_flight):
                        $counter = 0;
                        foreach ($repat_flight as $value):
                            $counter++;
                    ?>
                        <tr>
                            <td></td>
                            <td style="text-align: center;"><?php echo ($value->fd != '')? $value->fd : '&nbsp;'; ?></td>
                            <td style="text-align: center;"><?php echo ($value->flight_no != '')? $value->flight_no : '&nbsp;'; ?></td>
                            <td style="text-align: center;"><?php echo ($value->orides != '')? $value->orides : '&nbsp;'; ?></td>
                            <td style="text-align: center;"><?php echo ($value->flight_time != '')? $value->flight_time : '&nbsp;'; ?></td>
                            <td><?php echo ($value->remarks != '')? $value->remarks : '&nbsp;'; ?></td>
                        </tr>
                    <?php 
                        endforeach; 
                    ?>
                        <tr>
                            <td colspan="5">Airfare</td>
                            <td><?php echo _p($about, 'afre2'); ?></td>
                        </tr>
                    <?php
                    else:
                        echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                    endif;
                    ?>
                    </tbody>                 
                </table>      

                <!-- backbonejs view template -->
                <script id="repat-list-item" type="text/template">
                    <td><center><%= (counter)? counter : '' %></center></td>
                    <td><center><%= (code)? code : '' %></center></td>
                    <td>
                      <a href="<?php echo site_url();?>resume/<%= (hash)? hash : '' %>" target="_blank" >
                        <%= (fullname)? fullname : ''  %>
                      </a>
                    </td>
                    <td class="fs11px"><center><%= (joining_date)? joining_date : '' %></center></td>
                    <td class="fs11px"><center><%= (duration)? duration : '' %></center></td>
                    <td><%= (remarks)? remarks : '' %></td>
                    <td>
                        <div class="btn-group">
                            <center>
                            <% if(isdisembark == 0){  %>
                                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                                <a class="repat-disembark" rel="tooltip" title="Disembarked"
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-disembarked"></i>
                                </a>  
                                <?php endif; ?>

                                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                                <a class="repat-delete" rel="tooltip" title="Remove" 
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-remove"></i>
                                </a> 
                                <?php endif; ?> 
                            <% } else {  %>   
                                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                                <a class="edit-disembark" rel="tooltip" title="Edit Disembarkation"
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-edit"></i>
                                </a>   
                                <?php endif; ?>

                                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                                <a class="final-delete2" rel="tooltip" title="Remove" 
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-remove"></i>
                                </a> 
                                <?php endif; ?> 
                            <% }  %> 
                            </center>      
                        </div>
                    </td>
                    <td class="<%= (isdisembark)? ((isdisembark == 1)? 'tdc1' : 'tdc2') : ''  %>"><center><%= (isdisembark)? ((isdisembark == 1)? 'Yes' : 'No' ) : ''  %></center></td>
                </script>

                <script id="option-disembark-template" type="text/template">
                    <div class="inopt">
                        <div class="control-group popover-title">
                            <h3><%= (fullname)? fullname : ''  %> <span class="pull-right"><%= (crew_id)? crew_id : '' %></span></h3>
                            <h5><%= (position)? position : '' %> </h5>
                            <input type="hidden" value="<%= (id)? id : 0 %>" name="repat_id" />
                            <input type="hidden" value="<%= (crew_id)? crew_id : 0 %>" name="crew_id" />
                            <input type="hidden" value="<%= (onboard_id)? onboard_id : 0 %>" name="onboard_id" />
                        </div>
                        <div class="span4" style="margin-left: 0;">
                            <div class="control-group">
                                <label class="control-label" for="inputdisembarked">Disembarked Date :</label>
                                <div class="controls">
                                    <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="disembarked" style="width: 60%;" id="inputdisembarked" value="<?php echo isset($j_date)? date('m/d/Y', strtotime($j_date))  : ''; ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputReason">Reason :</label>
                                <div class="controls">  
                                    <?php 
                                    if(isset($reasons)){
                                        echo "<select name='reason'>";
                                        foreach ($reasons as $value) {
                                            echo "<option value='{$value->option}'>{$value->option}</option>";
                                        }
                                        echo "</select>";
                                    } ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputport">Port :</label>
                                <div class="controls">
                                    <input type="text" value="" name="port" id="inputport"/>
                                </div>
                            </div>
                        </div>
                        <div class="span4" style="margin-left: 10px;">
                            <div class="control-group">
                                <label class="control-label" for="inputarrival_date">Arrived Manila :</label>
                                <div class="controls">
                                    <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="arrival_date" style="width: 60%;" id="inputarrival_date" value="<?php echo isset($j_date)? date('m/d/Y', strtotime('+1 day', strtotime($j_date)))  : ''; ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputnext_joining">Next Joining :</label>
                                <div class="controls">
                                    <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="next_joining" style="width: 60%;" id="inputnext_joining" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputgrade">Performance Grade :</label>
                                <div class="controls">
                                    <input type="text" style="width: 40%" value="" name="performance_grade" id="inputgrade"/>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <ul id="myTab" class="nav nav-tabs">
                            <li class="active"><a href="#tab-a" data-toggle="tab">Finished Contract</a></li>
                            <li><a href="#tab-b" data-toggle="tab">Unfinished Contract</a></li>
                            <li><a href="#tab-c" id="tab-about" data-toggle="tab">P & I Cases</a></li>
                        </ul>

                        <div id="myTabContent" class="tab-content">

                            <div class="tab-pane fade in active" id="tab-a">
                                <div class="control-group">
                                    <label class="control-label" for="inputfinished_remarks">Remarks :</label>
                                    <div class="controls">
                                        <textarea style="height: 35px;" name="finished_remarks"><%= (remarks)? remarks : '' %></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputfinished_others">Others :</label>
                                    <div class="controls">
                                        <textarea style="height: 35px;" name="finished_others"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="tab-b">
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="inputunfinished_accounts1">Accounts : (1)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="unfinished_accounts1" id="unfinished_accounts1" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputunfinished_accounts2">(2)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="unfinished_accounts2" id="unfinished_accounts2" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputunfinished_accounts3">(3)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="unfinished_accounts3" id="unfinished_accounts3" style="width: 160px;"/>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="inputhearingdate">Hearing Dates : (1)</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="unfinished_hearing1" style="width: 160px;" id="inputhearing1" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputgrade">(2)</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="unfinished_hearing2" style="width: 160px;" id="inputhearing2" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputgrade">(3)</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="unfinished_hearing3" style="width: 160px;" id="inputhearing3" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputgrade">(4)</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="unfinished_hearing4" style="width: 160px;" id="inputhearing4" />
                                        </div>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="control-group">
                                        <label class="control-label" for="inputunfinished_remarks">Remarks :</label>
                                        <div class="controls">
                                            <textarea style="height: 35px;" name="unfinished_remarks"></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputcase">Case Nos :</label>
                                        <div class="controls">
                                            <input type="text" value="" name="unfinished_case" id="case" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputlegal">Legal Fees :</label>
                                        <div class="controls">
                                            <input type="text" value="" name="unfinished_legal" id="legal" placeholder="0.00"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputsurety">Surety Funds :</label>
                                        <div class="controls">
                                            <input type="text" value="" name="unfinished_surety" id="surety" placeholder="0.00"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputinsurance">Insurance :</label>
                                        <div class="controls">
                                            <input type="text" value="" name="unfinished_insurance" id="insurance" placeholder="0.00"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputsettlement">Settlement :</label>
                                        <div class="controls">
                                            <input type="text" value="" name="unfinished_settlement" id="settlement"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-c">
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_club">P & I Club :</label>
                                        <div class="controls">
                                            <input type="text" value="" name="pi_club" id="pi_club" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_hospital1">Hospital : (1)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="pi_hospital1" id="pi_hospital1" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_hospital2">(2)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="pi_hospital2" id="pi_hospital2" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_hospital3">(3)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="pi_hospital3" id="pi_hospital3" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_sick1">Sick/Injury : (1)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="pi_sick1" id="pi_sick1" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_sick2">(2)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="pi_sick2" id="pi_sick2" style="width: 160px;"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_progress1">Progress : (1)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="pi_progress1" id="pi_progress1" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_progress2">(2)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="pi_progress2" id="pi_progress2"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_progress3">(3)</label>
                                        <div class="controls">
                                            <input type="text" value="" name="pi_progress3" id="pi_progress3"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_fit">Fit for Duty :</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="pi_fit" style="width: 160px;" id="inputpi_fit" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputinsurance">Submission :</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="pi_submission" style="width: 160px;" id="inputpi_submission" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputinsurance">Approval :</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="pi_approval" style="width: 160px;" id="pi_approval" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_settlement">Settlement :</label>
                                        <div class="controls">
                                            <input type="text" value="" name="pi_settlement" id="pi_settlement"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </script>

                <script id="option-edit-repat-template" type="text/template">
                    <div class="inopt">
                        <div class="control-group popover-title">
                            <h3><%= (fullname)? fullname : ''  %> <span class="pull-right"><%= (crew_id)? crew_id : '' %></span></h3>
                            <h5><%= (position)? position : '' %> </h5>
                            <input type="hidden" value="<%= (id)? id : 0 %>" name="repat_id" />
                            <input type="hidden" value="<%= (crew_id)? crew_id : 0 %>" name="crew_id" />
                            <input type="hidden" value="<%= (onboard_id)? onboard_id : 0 %>" name="onboard_id" />
                        </div>
                        <div class="span4" style="margin-left: 0;">
                            <div class="control-group">
                                <label class="control-label" for="inputdisembarked">Disembarked Date :</label>
                                <div class="controls">
                                    <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="disembarked" style="width: 60%;" id="inputdisembarked" value="<%= (disembarked)? disembarked : '' %>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputReason">Reason :</label>
                                <div class="controls">  
                                    <?php 
                                    if(isset($reasons)){
                                        echo "<select name='reason'>";
                                        foreach ($reasons as $value) {
                                            echo "<option value='{$value->option}' ";
                                         ?>
                                        <%= (reason == "<?= _p($value, 'reason')?>")? 'selected="selected"' : ''  %>
                                        <?php
                                            echo ">{$value->option}</option>";
                                        }
                                        echo "</select>";
                                    } ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputport">Port :</label>
                                <div class="controls">
                                    <input type="text" value="<%= (port)? port : '' %>" name="port" id="inputport"/>
                                </div>
                            </div>
                        </div>
                        <div class="span4" style="margin-left: 10px;">
                            <div class="control-group">
                                <label class="control-label" for="inputarrival_date">Arrived Manila :</label>
                                <div class="controls">
                                    <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="arrival_date" style="width: 60%;" id="inputarrival_date" value="<%= (arrival_date)? arrival_date : '' %>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputnext_joining">Next Joining :</label>
                                <div class="controls">
                                    <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="next_joining" style="width: 60%;" id="inputnext_joining" value="<%= (next_joining)? next_joining : '' %>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputgrade">Performance Grade :</label>
                                <div class="controls">
                                    <input type="text" style="width: 40%" value="<%= (performance_grade)? performance_grade : '' %>" name="performance_grade" id="inputgrade"/>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <ul id="myTab" class="nav nav-tabs">
                            <li class="active"><a href="#tab-a" data-toggle="tab">Finished Contract</a></li>
                            <li><a href="#tab-b" data-toggle="tab">Unfinished Contract</a></li>
                            <li><a href="#tab-c" id="tab-about" data-toggle="tab">P & I Cases</a></li>
                        </ul>

                        <div id="myTabContent" class="tab-content">

                            <div class="tab-pane fade in active" id="tab-a">
                                <div class="control-group">
                                    <label class="control-label" for="inputfinished_remarks">Remarks :</label>
                                    <div class="controls">
                                        <textarea style="height: 35px;" name="finished_remarks"><%= (finished_remarks)? finished_remarks : '' %></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputfinished_others">Others :</label>
                                    <div class="controls">
                                        <textarea style="height: 35px;" name="finished_others"><%= (finished_others)? finished_others : '' %></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="tab-b">
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="inputunfinished_accounts1">Accounts : (1)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (unfinished_accounts1)? unfinished_accounts1 : '' %>" name="unfinished_accounts1" id="unfinished_accounts1" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputunfinished_accounts2">(2)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (unfinished_accounts2)? unfinished_accounts2 : '' %>" name="unfinished_accounts2" id="unfinished_accounts2" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputunfinished_accounts3">(3)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (unfinished_accounts3)? unfinished_accounts3 : '' %>" name="unfinished_accounts3" id="unfinished_accounts3" style="width: 160px;"/>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="inputhearingdate1">Hearing Dates : (1)</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" value="<%= (unfinished_hearing1)? unfinished_hearing1 : '' %>" placeholder="mm/dd/yyyy" name="unfinished_hearing1" style="width: 160px;" id="inputhearing1" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputhearingdate2">(2)</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" value="<%= (unfinished_hearing2)? unfinished_hearing2 : '' %>" placeholder="mm/dd/yyyy" name="unfinished_hearing2" style="width: 160px;" id="inputhearing2" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputhearingdate3">(3)</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" value="<%= (unfinished_hearing3)? unfinished_hearing3 : '' %>" placeholder="mm/dd/yyyy" name="unfinished_hearing3" style="width: 160px;" id="inputhearing3" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputhearingdate4">(4)</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" value="<%= (unfinished_hearing4)? unfinished_hearing4 : '' %>" placeholder="mm/dd/yyyy" name="unfinished_hearing4" style="width: 160px;" id="inputhearing4" />
                                        </div>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="control-group">
                                        <label class="control-label" for="inputunfinished_remarks">Remarks :</label>
                                        <div class="controls">
                                            <textarea style="height: 35px;" name="unfinished_remarks"><%= (unfinished_remarks)? unfinished_remarks : '' %></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputcase">Case Nos :</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (unfinished_case)? unfinished_case : '' %>" name="unfinished_case" id="case" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputlegal">Legal Fees :</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (unfinished_legal)? unfinished_legal : '' %>" name="unfinished_legal" id="legal" placeholder="0.00"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputsurety">Surety Funds :</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (unfinished_surety)? unfinished_surety : '' %>" name="unfinished_surety" id="surety" placeholder="0.00"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputinsurance">Insurance :</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (unfinished_insurance)? unfinished_insurance : '' %>" name="unfinished_insurance" id="insurance" placeholder="0.00"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputsettlement">Settlement :</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (unfinished_settlement)? unfinished_settlement : '' %>" name="unfinished_settlement" id="settlement"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-c">
                                <div class="span3">
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_club">P & I Club :</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (pi_club)? pi_club : '' %>" name="pi_club" id="pi_club" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_hospital1">Hospital : (1)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (pi_hospital1)? pi_hospital1 : '' %>" name="pi_hospital1" id="pi_hospital1" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_hospital2">(2)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (pi_hospital2)? pi_hospital2 : '' %>" name="pi_hospital2" id="pi_hospital2" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_hospital3">(3)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (pi_hospital3)? pi_hospital3 : '' %>" name="pi_hospital3" id="pi_hospital3" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_sick1">Sick/Injury : (1)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (pi_sick1)? pi_sick1 : '' %>" name="pi_sick1" id="pi_sick1" style="width: 160px;"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_sick2">(2)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (pi_sick2)? pi_sick2 : '' %>" name="pi_sick2" id="pi_sick2" style="width: 160px;"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_progress1">Progress : (1)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (pi_progress1)? pi_progress1 : '' %>" name="pi_progress1" id="pi_progress1" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_progress2">(2)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (pi_progress2)? pi_progress2 : '' %>" name="pi_progress2" id="pi_progress2"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_progress3">(3)</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (pi_progress3)? pi_progress3 : '' %>" name="pi_progress3" id="pi_progress3"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_fit">Fit for Duty :</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" value="<%= (pi_fit)? pi_fit : '' %>" placeholder="mm/dd/yyyy" name="pi_fit" style="width: 160px;" id="inputpi_fit" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputinsurance">Submission :</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" value="<%= (pi_submission)? pi_submission : '' %>" placeholder="mm/dd/yyyy" name="pi_submission" style="width: 160px;" id="inputpi_submission" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputinsurance">Approval :</label>
                                        <div class="controls">
                                            <input type="text" class="defaultdate" value="<%= (pi_approval)? pi_approval : '' %>" placeholder="mm/dd/yyyy" name="pi_approval" style="width: 160px;" id="pi_approval" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputpi_settlement">Settlement :</label>
                                        <div class="controls">
                                            <input type="text" value="<%= (pi_settlement)? pi_settlement : '' %>" name="pi_settlement" id="pi_settlement"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </script>   

                <?php $this->load->view('template/pagination');?>

                <script type="text/javascript">
                    $(document).ready(function() {
                        var repatItems = new RepatCollection();

                        <?php if(isset($id)): ?>
                            repatItems.sched_id = <?= $id; ?>;
                            repatItems.vessel_id = <?= $vessel_id; ?>;
                            repatItems.end_date = "<?php echo date('Y-m', strtotime($repat_date)); ?>";
                        <?php endif; ?>
                   
                        var repatmasterView = new RepatMasterView({collection: repatItems});
                        var repatpagination = new RepatPaginatedView({collection: repatItems});        
                    });
                </script>

                <script type="text/template" id="alert4Template">
                    <div class="alert alert-<%= type %>">
                        <button class="close" data-dismiss="alert" type="button">×</button>
                        <%= message %>
                    </div>
                </script>
            </div>
        </div>

        <!-- Modal Disembark Data -->          
        <div class="modal hide fade" id="disembarkData" style="width: 800px; margin: -250px 0 0 -400px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Disembarkation <small>&raquo; Setup</small></h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div id="container-option-disembark"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-primary" id="options-submit">Submit</a>
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            </div>
        </div>

        <div class="modal hide fade" id="editDisembarkData" style="width: 800px; margin: -250px 0 0 -400px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Disembarkation <small>&raquo; Setup</small></h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div id="container-option-edit-repat"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-primary" id="options-update">Update</a>
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            </div>
        </div>
        <!-- End Add -->

        <!-- Modal Delete --> 
        <div class="modal hide fade" id="deleteRepat">
            <div class="modal-header">
              <a href="#" data-dismiss="modal" class="close">&times;</a>
              <h3>Delete Post</h3>
            </div>
            <div class="modal-body">
              <p>You are about to delete this record.</p>
              <p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
              <a href="#" data-dismiss="modal" class="btn btn-danger" id="repat-delete">Yes</a>
              <a href="#" data-dismiss="modal" class="btn secondary">No</a>
            </div>
        </div>

        <div class="modal hide fade" id="finalDelete2">
            <div class="modal-header">
              <a href="#" data-dismiss="modal" class="close">&times;</a>
              <h3>Cancel Repatration</h3>
            </div>
            <div class="modal-body">
              <p>You are about to cancel this repatration.</p>
              <p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
              <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
              <a href="#" data-dismiss="modal" class="btn secondary">No</a>
            </div>
        </div>
        <!-- Modal Delete --> 

        <!-- Modal Add -->   
        <div id="finished-list-view">       
            <div class="modal hide fade" id="addRepat" style="width: 800px; margin: -250px 0 0 -400px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Finished Contract <small>&raquo; Master List</small></h3>
                </div>
                <div class="modal-body">
                    <div class="pull-right" id="finishedpagination"></div>
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="rsearch" autocomplete="off" />
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <span id="loader-f-container"></span>
                    </form>   

                    <div class="clearfix" style="margin-bottom: 20px;"></div>

                    <div id="alert5-div"></div> 

                    <table class="responsive-table" id="options-table-finished">
                        <thead>
                          <tr>
                            <th width="2%" class="sortcolumn" col="crew_id">ID</th>
                            <th width="5%" class="sortcolumn" col="position_id">Rank</th>
                            <th width="40%" class="sortcolumn" col="name">Name</th>
                            <th width="30%">Contract Duration</th>
                            <th width="25%">Remarks</th>
                          </tr>
                        </thead>
                        <tbody></tbody>                            
                    </table>
                    <!-- backbonejs view template -->
                    <script id="finished-list-item" type="text/template">   
                        <td><input type='checkbox' name='ischeck' id="ischeck" value='0' style='margin-bottom: 0;' />
                            <input type='hidden' name='crew_id' value='<%= (crew_id)? crew_id : '' %>' />
                            <input type='hidden' name='onboard_id' value='<%= (onboard_id)? onboard_id : '' %>' />
                            <input type='hidden' name='position_id' value='<%= (position_id)? position_id : '' %>' />
                        </td>
                        <td><%= (code)? code : '' %></td>
                        <td><%= (fullname)? fullname : ''  %></td>
                        <td><%= (duration)? duration : ''  %></td>
                        <td><input type="text" name="remarks" id="inputremarks" value="" style="width: 91%; margin-bottom: 0;" />&nbsp;</td>
                    </script>

                    <?php $this->load->view('template/pagination');?>

                    <script type="text/template" id="alert5Template">
                        <div class="alert alert-<%= type %>">
                            <button class="close" data-dismiss="alert" type="button">×</button>
                            <%= message %>
                        </div>
                    </script>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                    <a href="#" data-dismiss="modal" class="btn btn-success" id="finished-submit">Submit</a>
                </div>
            </div>
        </div>
        <!-- End Add -->

    </div>
</div>



