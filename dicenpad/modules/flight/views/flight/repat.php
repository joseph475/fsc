
<div class="row-section">
    <div class="row-title">REPAT CREW</div> 

    <div id="repat-info">
        <div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="repatpagination"></div> 

                <span id="loader-r-container"></span>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alert-repat-div"></div>
                
                <table class="responsive-table table-attr-center" id="options-table-repat" style="margin-bottom: 15px;">
                    <thead>
                        <tr>
                            <th width="2%">Nos</th>
                            <th width="9%">Rank</th>                                
                            <th width="40%">Name</th>
                            <th width="11%">Contract Duration</th>
                            <th width="38%">Remarks</th>
                        </tr>
                    </thead>
                    <tbody></tbody>                            
                </table>

                <table class="responsive-table table-attr-center inoptsinfo" style="margin-bottom: 15px;">
                    <tr>    
                        <td style="width: 15%; text-align: right;"><h5>Off-Signers</h5></td>
                        <td style="width: 10%;"><input type="text" name="off_signers" value="<?php echo isset($off_signers)? $off_signers : '0'; ?>" style="width: 90%;" /></td>
                        <td style="width: 15%; text-align: right;"><h5>Arrival</h5></td>
                        <td style="width: 15%;"><input type="text" class="jrdate" style="width: 93%;" placeholder="mm/dd/yyy" name="arrival" value="<?php echo isset($j_date)? date('m/d/Y', strtotime('+1 day', strtotime($j_date)))  : ''; ?>"></td>
                        <td style="width: 20%; text-align: right;"><h5>Airfare (Per Crew)</h5></td>
                        <td style="width: 25%;"><input type="text" style="width: 95%;" value="<?php echo isset($airfare2)? $airfare2 : ''; ?>" name="airfare2"/></td>
                    </tr>                          
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
                    <td><center><%= (duration)? duration : '' %></center></td>
                    <td><%= (remarks)? remarks : '' %></td>
                </script>

                 <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                    <a id="flight-repat-add-btn" class="btn btn btn-info" 
                        href="javascript:void(0);" data-toggle="modal">
                        <i class="icon-plus"></i> Add Flight
                    </a>
                <?php endif; ?>
                <div class="clearfix" style="margin-bottom: 15px;"></div>

                <table class="responsive-table table-attr-center" id="flight-repat-table">
                    <thead>
                        <tr>
                            <th colspan="6" class="row-title">Flight Schedule </th>
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
                    <tbody>
                    </tbody>                            
                </table>  

                <!-- backbonejs view template -->
                <script id="flight-repat-list" type="text/template">
                    <td><center><%= (fd)? fd : ''  %></center></td>
                    <td><center><%= (flight_no)? flight_no : ''  %></center></td>
                    <td><center><%= (orides)? orides : '' %></center></td>
                    <td><center><%= (flight_time)? flight_time : ''  %></center></td>
                    <td><%= (remarks)? remarks : ''  %></td>
                    <td>
                        <div class="btn-group">
                            <center>
                                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                                <a class="flight-repat-edit" rel="tooltip" title="Edit" 
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-edit"></i>
                                </a> 
                                <?php endif; ?>

                                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                                <a class="flight-repat-delete" rel="tooltip" title="Remove" 
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-remove"></i>
                                </a> 
                                <?php endif; ?>
                            </center>      
                        </div>
                    </td>
                </script>   

                <script id="flight-repat-add-template" type="text/template">
                    <div class="inpt-add-repat">
                        <div class="control-group">
                            <label class="control-label" for="inputflight_date">Date :</label>
                            <div class="controls">
                                <input type="text" name="flight_date" class="ddate" placeholder="mm/dd/yyy" value="<?php echo isset($r_date)? date('m/d/Y', strtotime('+1 day', strtotime($r_date)))  : ''; ?>" />
                                <input type="hidden" name="sched_id" value="<?php echo isset($id)? $id : 0; ?>"/>
                                <input type="hidden" name="type" value="repat" />
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

                <script id="flight-repat-edit-template" type="text/template">
                    <div class="inpt-edit-repat">
                        <div class="control-group">
                            <label class="control-label" for="inputflight_date">Date :</label>
                            <div class="controls">
                                <input type="text" name="flight_date" class="ddate" placeholder="mm/dd/yyy" value="<%= (flight_date)? flight_date : '' %>" />
                                <input type="hidden" name="type" value="repat" />
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
                        var repatItems = new RepatCollection();

                        <?php if($id): ?>
                            repatItems.sched_id = <?php echo $id; ?>;
                            repatItems.vessel_id = <?php echo $vessel_id; ?>;
                            repatItems.end_date = "<?php echo date('Y-m', strtotime($repat_date)); ?>";
                        <?php endif; ?>
                   
                        var repatmasterView = new RepatMasterView({collection: repatItems});
                        var repatpagination = new RepatPaginatedView({collection: repatItems});    

                        var flightRepatcollection = new FlightRepatCollection();
                        <?php if($id): ?>
                            flightRepatcollection.id = <?php echo $id; ?>;
                        <?php endif; ?>
                        var flighRepatJoinView = new FlightRepatView({collection: flightRepatcollection});        
                    });
                </script>

                <script type="text/template" id="alertRepatTemplate">
                    <div class="alert alert-<%= type %>">
                        <button class="close" data-dismiss="alert" type="button">×</button>
                        <%= message %>
                    </div>
                </script>
            </div>
        </div>

        <!-- Modal Flight --> 
        <div class="modal hide fade" id="deleteRepatFlight">
            <div class="modal-header">
              <a href="#" data-dismiss="modal" class="close">&times;</a>
              <h3>Delete Post</h3>
            </div>
            <div class="modal-body">
              <p>You are about to delete this record.</p>
              <p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
              <a href="#" data-dismiss="modal" class="btn btn-danger" id="flight2-delete">Yes</a>
              <a href="#" data-dismiss="modal" class="btn secondary">No</a>
            </div>
        </div>

        <div class="modal hide fade" id="addRepatFlight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Add Flight Schedule <small>&raquo; Setup</small></h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div id="container-flight-repat-add"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                <a href="#" data-dismiss="modal" class="btn btn-success" id="options-submit">Submit</a>
            </div>
        </div>
        <!-- End Modal -->

        <!-- Modal Edit -->          
        <div class="modal hide fade" id="editRepatFlight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Edit Flight <small>&raquo; Setup</small></h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div id="container-flight-repat-edit"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                <a href="javascript:void(0);" class="btn btn-primary" id="options-update">Submit Changes</a>
            </div>
        </div>
        <!-- End Edit -->  
    </div>
</div>



