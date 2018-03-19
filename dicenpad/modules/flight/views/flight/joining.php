<div class="row-section">
    <div class="row-title">JOINING CREW</div> 

    <div id="joining-info">
    	<div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="joinpagination"></div> 

                <span id="loader-j-container"></span>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alert-join-div"></div> 
                
                <table class="responsive-table table-attr-center" id="options-table-join" style="margin-bottom: 15px;">
                    <thead>
                        <tr>
                            <th width="2%">Nos</th>
                            <th width="9%">Rank</th>                                
                            <th width="40%">Name</th>
                            <th width="6%">Medical Issued</th>
                            <th width="6%">SIRB Expiry</th>
                            <th width="6%">PASSPORT Expiry</th>
                            <th width="6%">COC Expiry</th>
                            <th width="9%">Contract Duration</th>
                            <th width="16%">Remarks</th>
                        </tr>
                    </thead>
                    <tbody></tbody>                           
                </table>

                <table class="responsive-table table-attr-center inoptsinfo" style="margin-bottom: 15px;">
                    <tr>    
                        <td style="width: 15%; text-align: right;"><h5>On-Signers</h5></td>
                        <td style="width: 10%;"><input type="text" name="on_signers" value="<?php echo isset($on_signers)? $on_signers : '0'; ?>" style="width: 90%;" /></td>
                        <td style="width: 15%; text-align: right;"><h5>Leave Manila</h5></td>
                        <td style="width: 15%;"><input type="text" class="jrdate" style="width: 93%;" placeholder="mm/dd/yyy" name="onleave" value="<?php echo isset($j_date)? date('m/d/Y', strtotime('-1 day', strtotime($j_date)))  : ''; ?>"></td>
                        <td style="width: 20%; text-align: right;"><h5>Airfare (Per Crew)</h5></td>
                        <td style="width: 25%;"><input type="text" style="width: 95%;" value="<?php echo isset($airfare1)? $airfare1 : ''; ?>" name="airfare1"/></td>
                    </tr>                          
                </table>

                <!-- backbonejs view template -->
                <script id="join-list-item" type="text/template">
                    <td><center><%= (counter)? counter : ''  %></center></td>
                    <td><center><%= (code)? code : ''  %></center></td>
                    <td>
                      <a href="<?php echo site_url();?>resume/<%= (hash)? hash : '' %>" target="_blank" >
                        <%= (fullname)? fullname : ''  %>
                      </a>
                    </td>
                    <td class="fs11px"><center><%= (medical_issued)? medical_issued : ''  %></center></td>
                    <td class="fs11px"><center><%= (sirb)? sirb : ''  %></center></td>
                    <td class="fs11px"><center><%= (passport_expired)? passport_expired : ''  %></center></td>
                    <td class="fs11px"><center><%= (coc_expired)? coc_expired : ''  %></center></td>
                    <td class="fs11px"><center><%= (duration)? duration : ''  %></center></td>
                    <td><%= (remarks)? remarks : ''  %></td>
                </script>

                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                    <a id="flight-join-add-btn" class="btn btn btn-info" data-toggle="modal">
                        <i class="icon-plus"></i> Add Flight
                    </a>
                <?php endif; ?>
                <div class="clearfix" style="margin-bottom: 15px;"></div>

                <table class="responsive-table table-attr-center" id="flight-join-table">
                    <thead>
                        <tr>
                            <th colspan="6" class="row-title">Flight Schedule</th>
                        </tr>
                        <tr>
                            <th width="11%">Date</th>    
                            <th width="15%">Flight No.</th>
                            <th width="15%">Origin/Destination</th>
                            <th width="15%">Time</th>
                            <th>Status</th>
                            <th width="2%">Actions</th>
                        </tr>
                    </thead>
                    <tbody> </tbody>                            
                </table>    

                <!-- backbonejs view template -->
                <script id="flight-join-list" type="text/template">
                    <td><center><%= (fd)? fd : ''  %></center></td>
                    <td><center><%= (flight_no)? flight_no : ''  %></center></td>
                    <td><center><%= (orides)? orides : '' %></center></td>
                    <td><center><%= (flight_time)? flight_time : ''  %></center></td>
                    <td><%= (remarks)? remarks : ''  %></td>
                    <td>
                        <div class="btn-group">
                            <center>
                                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                                <a class="flight-join-edit" rel="tooltip" title="Edit" 
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-edit"></i>
                                </a> 
                                <?php endif; ?>

                                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                                <a class="flight-join-delete" rel="tooltip" title="Remove" 
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-remove"></i>
                                </a> 
                                <?php endif; ?>
                            </center>      
                        </div>
                    </td>
                </script>    

                 <script id="flight-join-add-template" type="text/template">
                    <div class="inpt-add-join">
                        <div class="control-group">
                            <label class="control-label" for="inputflight_date">Date :</label>
                            <div class="controls">
                                <input type="text" name="flight_date" class="ddate" placeholder="mm/dd/yyy" value="<?php echo isset($j_date)? date('m/d/Y', strtotime('-1 day', strtotime($j_date)))  : ''; ?>" />
                                <input type="hidden" name="sched_id" value="<?php echo isset($id)? $id : 0; ?>"/>
                                <input type="hidden" name="type" value="join" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputflight_no">Flight No. :</label>
                            <div class="controls">
                                <input id="inputflight_no" type="text" name="flight_no" value=""  />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputorigin">Origin :</label>
                            <div class="controls">
                                <input id="inputorigin" type="text" name="origin" value=""  />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputdestination">Destination :</label>
                            <div class="controls">
                                <input id="inputdestination" type="text" name="destination" value=""  />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputflight_time">Time :</label>
                            <div class="controls">
                                <input id="inputflight_time" type="text" placeholder="0000/0000" name="flight_time" value=""  />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputremarks">Status :</label>
                            <div class="controls">
                                <input id="inputremarks" type="text" name="remarks" value=""  />
                            </div>
                        </div>
                    </div>
                </script>   

                <script id="flight-join-edit-template" type="text/template">
                    <div class="inpt-edit-join">
                        <div class="control-group">
                            <label class="control-label" for="inputflight_date">Date :</label>
                            <div class="controls">
                                <input type="text" name="flight_date" class="ddate" placeholder="mm/dd/yyy" value="<%= (flight_date)? flight_date : '' %>" />
                                <input type="hidden" name="sched_id" value="<?php echo isset($id)? $id : 0; ?>"/>
                                <input type="hidden" name="type" value="join" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputflight_no">Flight No. :</label>
                            <div class="controls">
                                <input id="inputflight_no" type="text" name="flight_no" value="<%= (flight_no)? flight_no : '' %>"  />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputorigin">Origin :</label>
                            <div class="controls">
                                <input id="inputorigin" type="text" name="origin" value="<%= (origin)? origin : '' %>"  />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputdestination">Destination :</label>
                            <div class="controls">
                                <input id="inputdestination" type="text" name="destination" value="<%= (destination)? destination : '' %>"  />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputflight_time">Time :</label>
                            <div class="controls">
                                <input id="inputflight_time" type="text" placeholder="0000/0000" name="flight_time" value="<%= (flight_time)? flight_time : '' %>"  />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputremarks">Status :</label>
                            <div class="controls">
                                <input id="inputremarks" type="text" name="remarks" value="<%= (remarks)? remarks : '' %>"  />
                            </div>
                        </div>
                    </div>
                </script>         

                <?php $this->load->view('template/pagination');?>

                <script type="text/javascript">
                    $(document).ready(function() {
                        var joinItems = new JoinCollection();
                        
                        <?php if($id): ?>
                            joinItems.sched_id = <?php echo $id; ?>;
                            joinItems.vessel_id = <?php echo $vessel_id; ?>;
                            joinItems.start_date = "<?php echo date('Y-m-d', strtotime($j_date)); ?>";
                            joinItems.end_date = "<?php echo date('Y-m-d', strtotime($r_date)); ?>";
                        <?php endif; ?>

                        var joinmasterView = new JoinMasterView({collection: joinItems});
                        var joinpagination = new JoinPaginatedView({collection: joinItems});  

                        var flightjoiningcollection = new FlightJoiningCollection();
                        <?php if($id): ?>
                            flightjoiningcollection.id = <?php echo $id; ?>;
                        <?php endif; ?>
                        var flightJoiningView = new FlightJoiningView({collection: flightjoiningcollection});   
                    });
                </script>

                <script type="text/template" id="alertJoinTemplate">
                    <div class="alert alert-<%= type %>">
                        <button class="close" data-dismiss="alert" type="button">×</button>
                        <%= message %>
                    </div>
                </script>
            </div>
        </div>

        <!-- Modal Flight --> 
        <div class="modal hide fade" id="deleteJoinFlight">
            <div class="modal-header">
              <a href="#" data-dismiss="modal" class="close">&times;</a>
              <h3>Delete Post</h3>
            </div>
            <div class="modal-body">
              <p>You are about to delete this record.</p>
              <p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
              <a href="#" data-dismiss="modal" class="btn btn-danger" id="flight-delete">Yes</a>
              <a href="#" data-dismiss="modal" class="btn secondary">No</a>
            </div>
        </div>
                
        <div class="modal hide fade" id="addJoinFlight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Add Flight Schedule <small>&raquo; Setup</small></h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div id="container-flight-join-add"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                <a href="#" data-dismiss="modal" class="btn btn-success" id="options-submit">Submit</a>
            </div>
        </div>
        <!-- End Flight -->

        <!-- Modal Edit -->          
        <div class="modal hide fade" id="editJoinFlight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Edit Flight <small>&raquo; Setup</small></h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div id="container-flight-join-edit"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                <a href="#" class="btn btn-primary" id="options-update">Submit Changes</a>
            </div>
        </div>
        <!-- End Edit -->    
    </div>
</div>

