<div class="row-section">
    <div class="row-title">JOINING CREW</div> 

    <div id="joining-info">
    	<div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="joinpagination"></div> 
                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a id="join_add-btn" class="btn btn-info" data-toggle="modal">
                    <i class="icon-plus"></i> Add
                </a> 
                <?php endif; ?>

                <span id="loader-j-container"></span>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alert2-div"></div> 
                
                <table class="responsive-table table-attr-center" id="options-table-join" style="margin-bottom: 15px;">
                    <thead>
                        <tr>
                            <th width="2%"><center>Nos</center></th>
                            <th width="8%"><center>Rank</center></th>                                
                            <th width="39%">Name</th>
                            <th width="6%"><center>Medical Issued</center></th>
                            <th width="6%"><center>SIRB Expiry</center></th>
                            <th width="6%"><center>PASSPORT Expiry</center></th>
                            <th width="6%"><center>COC Expiry</center></th>
                            <th width="9%"><center>Contract Duration</center></th>
                            <th width="14%"><center>Remarks</center></th>
                            <th width="2%"><center>Actions</center></th>
                            <th width="2%"><center>Onboard</center></th>
                        </tr>
                    </thead>
                    <tbody></tbody>                           
                </table>

                <table class="responsive-table table-attr-center inoptsinfo" style="margin-bottom: 15px;">
                    <tr>    
                        <td style="width: 15%; text-align: right;"><h5>On-Signers</h5></td>
                        <td style="width: 10%;"><?php echo isset($on_signers)? $on_signers : '0'; ?><input type="hidden" name="on_signers" value="<?php echo isset($onsigners)? $onsigners : '0'; ?>" /></td>
                        <td style="width: 15%; text-align: right;"><h5>Leave Manila</h5></td>
                        <td style="width: 15%;"><?php echo isset($j_date)? date('m/d/Y', strtotime('-1 day', strtotime($j_date)))  : ''; ?><input type="hidden" name="onleave" value="<?php echo isset($j_date)? date('m/d/Y', strtotime('-1 day', strtotime($j_date)))  : ''; ?>"></td>
                        <td style="width: 20%; text-align: right;"><h5>Airfare (Per Crew)</h5></td>
                        <td style="width: 25%;"><?php echo isset($airfare1)? $airfare1 : ''; ?><input type="hidden" value="<?php echo isset($airfare1)? $airfare1 : ''; ?>" name="airfare1"/></td>
                    </tr>                          
                </table>

                <div class="row-title">JOINING FLIGHT DETAILS</div> 
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
                    if($join_flight):
                        $counter = 0;
                        foreach ($join_flight as $value):
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
                            <td><?php echo _p($about, 'afre1'); ?></td>
                        </tr>
                    <?php
                    else:
                        echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                    endif;
                    ?>

                    </tbody>
                </table>   

                <!-- backbonejs view template -->
                <script id="join-list-item" type="text/template">
                    <td><center><%= (counter)? counter : ''  %></center></td>
                    <td><center><%= (code)? code : ''  %></center></td>
                    <td>
                      <a href="<?php echo site_url();?>resume/<%= (hash)? hash : '' %>" target="_blank" >
                        <%= (fullname)? fullname : ''  %>
                      </a><br/>
                      <a href="<?= site_url('schedule-replacement') ?>/<%= (control_nos2)? control_nos2 : 0 %>" target="_blank" ><small style="font-size: 10px; color: #333"><%= (control_nos2)? 'Already Repat on Ref Nos. ' + control_nos2 : ''  %></small></a>
                    </td>
                    <td class="fs11px"><center><%= (medical_issued)? medical_issued : '-'  %></center></td>
                    <td class="fs11px"><center><%= (sirb)? sirb : '-'  %></center></td>
                    <td class="fs11px"><center><%= (passport_expired)? passport_expired : '-'  %></center></td>
                    <td class="fs11px"><center><%= (coc_expired)? coc_expired : '-'  %></center></td>
                    <td class="fs11px"><center><%= (duration)? duration : ''  %></center></td>
                    <td><%= (remarks)? remarks : ''  %></td>
                    <td>
                        <% if(isembark){  %>
                        <div class="btn-group">
                            <center>
                            <% if(isembark == 0){  %>
                                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                                <a class="join-embark" rel="tooltip" title="Embarked"
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-embarked"></i>
                                </a>   
                                <?php endif; ?>

                                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                                <a class="join-delete" rel="tooltip" title="Remove" 
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-remove"></i>
                                </a> 
                                <?php endif; ?> 
                            <% } else {  %>   
                                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                                <a class="edit-embark" rel="tooltip" title="Edit Embarkation"
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-edit"></i>
                                </a>   
                                <?php endif; ?>
                                <%if (!control_nos2){ %>
                                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                                <a class="final-delete" rel="tooltip" title="Cancel Embarkation" 
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-remove"></i>
                                </a> 
                                <?php endif; ?> 
                                <% }  %> 
                            <% }  %>  
                            </center>  
                        </div>
                        <% }  %>  
                    </td>
                    <td class="<%= (isembark)? ((isembark == 1)? 'tdc1' : 'tdc2') : ''  %>"><center><%= (isembark)? ((isembark == 1)? 'Yes' : 'No' ) : ''  %></center></td>
                </script>

                <script id="option-embark-template" type="text/template">
                    <div class="inopt">
                        <div class="control-group popover-title">
                            <h3><%= (fullname)? fullname : '' %> <span class="pull-right"><%= (crew_id)? crew_id : '' %></span></h3>
                            <h5><%= (position)? position : '' %> </h5>
                            <input type="hidden" value="<%= (id)? id : 0 %>" name="joining_id" />
                        </div>
                    
                        <div class="control-group">
                            <label class="control-label" for="inputVessel">Vessel :</label>
                            <div class="controls">
                                <input type="text" style="width: 70%" readonly="readonly" value="<?php echo isset($vessel_name)? $vessel_name : ''; ?>" name="vessel_name"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputjoining_port">Joining Port :</label>
                            <div class="controls">
                                <input type="text" style="width: 70%" value="<?php echo isset($joining_port)? $joining_port : ''; ?>" name="joining_port"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputpdos_date">PDOS No. :</label>
                            <div class="controls">
                                <input type="text" style="width: 35%" value="" name="pdos_nos"/>
                                <input type="text" class="defaultdate" style="width: 33%" placeholder="PDOS Date" value="" name="pdos_date"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputoec_nos">OEC No :</label>
                            <div class="controls">
                                <input type="text" style="width: 45%" value="" name="oec_nos"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputJoining">Embarkation Date :</label>
                            <div class="controls">
                                <input type="text" class="defaultdate" placeholder="Embarkation Date" id="from" name="start_date" value="<%= (est_start_date)? est_start_date : '' %>" style="width: 30%;" />
                                <input type="text" style="width: 15%" value="<%= (duration_month)? duration_month : 0 %> Months" readonly="readonly" name="duration_month"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputJoining">Point of Hire :</label>
                            <div class="controls">
                                <input type="text" style="width: 70%" value="Manila, Philippines" name="point_of_hire"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputRoute">Trade Route :</label>
                            <div class="controls">
                                <input type="text" style="width: 70%" value="" name="trade"/>
                            </div>
                        </div>
                    </div>
                </script>   

                <script id="option-edit-template" type="text/template">
                    <div class="inopt">
                        <div class="control-group popover-title">
                            <h3><%= (fullname)? fullname : '' %> <span class="pull-right"><%= (crew_id)? crew_id : '' %></span></h3>
                            <h5>Position: <%= (position)? position : '' %> </h5>
                            <h5>Vessel:<?php echo isset($vessel_name)? $vessel_name : ''; ?> </h5>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputpdos_date">PDOS No. :</label>
                            <div class="controls">
                                <input type="text" style="width: 35%" value="<%= (pdos_nos)? pdos_nos : 0 %>" name="pdos_nos"/>
                                <input type="text" class="defaultdate" style="width: 33%" placeholder="PDOS Date" value="<%= (pdos_date)? pdos_date : 0 %>" name="pdos_date"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputoec_nos">OEC No :</label>
                            <div class="controls">
                                <input type="text" style="width: 45%" value="<%= (oec_nos)? oec_nos : 0 %>" name="oec_nos"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputJoining">Embarkation Date :</label>
                            <div class="controls">
                                <input type="text" class="defaultdate" placeholder="Embarkation Date" id="from" name="start_date" value="<%= (est_start_date)? est_start_date : '' %>" style="width: 30%;" />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputJoining">Point of Hire :</label>
                            <div class="controls">
                                <input type="text" style="width: 70%" value="<%= (point_of_hire)? point_of_hire : 0 %>" name="point_of_hire"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputRoute">Trade Route :</label>
                            <div class="controls">
                                <input type="text" style="width: 70%" value="<%= (trade)? trade : 0 %>" value="Manila, Philippines" name="trade"/>
                            </div>
                        </div>
                    </div>
                </script>   

                <?php $this->load->view('template/pagination');?>

                <script type="text/javascript">
                    $(document).ready(function() {
                        var joinItems = new JoinCollection();
                        
                        <?php if(isset($id)): ?>
                            joinItems.sched_id = <?= $id; ?>;
                            joinItems.vessel_id = <?= $vessel_id; ?>;
                            joinItems.start_date = "<?= date('Y-m-d', strtotime($j_date)); ?>";
                            joinItems.end_date = "<?= date('Y-m-d', strtotime($r_date)); ?>";
                        <?php endif; ?>

                        var joinmasterView = new JoinMasterView({collection: joinItems});
                        var joinpagination = new JoinPaginatedView({collection: joinItems});    
                    });
                </script>

                <script type="text/template" id="alert2Template">
                    <div class="alert alert-<%= type %>">
                        <button class="close" data-dismiss="alert" type="button">×</button>
                        <%= message %>
                    </div>
                </script>
            </div>
        </div>

        <!-- Modal Embark -->          
        <div class="modal hide fade" id="embarkData" style="width: 800px; margin: -250px 0 0 -400px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Embarkation <small>&raquo; Setup</small></h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div id="container-option-embark"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-primary" id="options-update">Update</a>
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            </div>
        </div>

        <div class="modal hide fade" id="editData">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Embarkation <small>&raquo; Setup</small></h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div id="container-option-edit"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-primary" id="options-update">Update</a>
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            </div>
        </div>
        <!-- End Edit -->

        <!-- Modal Delete --> 
        <div class="modal hide fade" id="deleteJoin">
            <div class="modal-header">
              <a href="#" data-dismiss="modal" class="close">&times;</a>
              <h3>Delete Post</h3>
            </div>
            <div class="modal-body">
              <p>You are about to delete this record.</p>
              <p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
              <a href="#" data-dismiss="modal" class="btn btn-danger" id="join-delete">Yes</a>
              <a href="#" data-dismiss="modal" class="btn secondary">No</a>
            </div>
        </div>

        <div class="modal hide fade" id="finalDelete">
            <div class="modal-header">
              <a href="#" data-dismiss="modal" class="close">&times;</a>
              <h3>Cancel Embarkation</h3>
            </div>
            <div class="modal-body">
              <p>You are about to cancel this embarkation.</p>
              <p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
              <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
              <a href="#" data-dismiss="modal" class="btn secondary">No</a>
            </div>
        </div>
        <!-- Modal Delete --> 

        <!-- Modal Add -->   
        <div id="crews-list-view">       
            <div class="modal hide fade" id="addJoin" style="width: 800px; margin: -250px 0 0 -400px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Candidate <small>&raquo; Master List</small></h3>
                </div>
                <div class="modal-body">
                    <div class="pull-right" id="CandidatePagination"></div>
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                        <select name="position_id" id="position_id" style="width: 150px;">
                            <?php 
                            if($positions){
                               foreach ($positions as $value) {
                                    echo "<option value='{$value->position_id}'>{$value->position}</option>";
                                }  
                            }
                            ?>
                            <option value='0'>All</option>
                        </select>
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <span id="loader-c-container"></span>
                    </form>   

                    <div class="clearfix" style="margin-bottom: 20px;"></div>

                    <div id="alert3-div"></div> 

                    <table class="responsive-table" id="options-table-crews">
                        <thead>
                          <tr>
                            <th width="2%" class="sortcolumn" col="crew_id">ID</th>
                            <th width="5%" class="sortcolumn" col="position_id">Rank</th>
                            <th width="40%" class="sortcolumn" col="lastname">Name</th>
                            <th width="28%">Contract Duration</th>
                            <th width="25%">Remarks</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>                            
                    </table>
                    <!-- backbonejs view template -->
                    <script id="crews-list-item" type="text/template">   
                        <td><input type='checkbox' name='ischeck' id="ischeck" value='0' style='margin-bottom: 0;' />
                            <input type='hidden' name='crew_id' value='<%= (crew_id)? crew_id : '' %>' />
                            <input type='hidden' name='salary_id' value='<%= (salary_id)? salary_id : '' %>' />
                            <input type='hidden' name='position_id' value='<%= (position_id)? position_id : '' %>' />
                        </td>
                        <td><%= (code)? code : '' %></td>
                        <td><a href="<?php echo site_url();?>resume/<%= hash %>" data-original-title="<%= (fullname)? fullname : ''  %>" target="_blank">
                                <%= (fullname)? fullname : ''  %>
                            </a>
                        </td>
                        <td>
                            <select name="duration_month" style="width: 90px; margin-bottom: 0;">
                                <option value="1">1 mo</option>
                                <?php for($i=2; $i <= 15; $i++){
                                    echo "<option value='{$i}'>{$i} mos</option>";
                                } ?>
                            </select>
                        </td> 
                        <td><input type="text" name="remarks" id="inputremarks" value="" style="width: 91%; margin-bottom: 0;" />&nbsp;</td>
                    </script>

                    <?php $this->load->view('template/pagination');?>

                    <script type="text/template" id="alert3Template">
                        <div class="alert alert-<%= type %>">
                            <button class="close" data-dismiss="alert" type="button">×</button>
                            <%= message %>
                        </div>
                    </script>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                    <a href="#" data-dismiss="modal" class="btn btn-success" id="crews-submit">Submit</a>
                </div>
            </div>
        </div>
        <!-- End Add -->
    </div>
</div>
