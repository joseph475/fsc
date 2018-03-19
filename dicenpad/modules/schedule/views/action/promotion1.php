<div class="row-section">
    <div class="row-title">FOR PROMOTION/ TRANSFER POSITION</div> 

    <div id="promotion-info">
        <div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="promotionpagination"></div> 
                
                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a id="promotion_add-btn" class="btn btn-info" data-toggle="modal">
                    <i class="icon-plus"></i> Add
                </a> 
                <?php endif; ?>

                <span id="loader-p-container"></span>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alertpe7-div"></div> 
                
                <table class="responsive-table table-attr-center" id="options-table-promotion">
                    <thead>
                        <tr>
                            <th width="2%"><center>Nos</center></th>
                            <th width="6%"><center>Prev Rank</center></th> 
                            <th width="6%"><center>New Rank</center></th>                                
                            <th width="32%">Name</th>
                            <th width="6%"><center>Medical Issued</center></th>
                            <th width="6%"><center>SIRB Expiry</center></th>
                            <th width="6%"><center>PASSPORT Expiry</center></th>
                            <th width="6%"><center>COC Expiry</center></th>
                            <th width="8%"><center>Contract Extension</center></th>
                            <th width="14%"><center>Remarks</center></th>
                            <th width="2%"><center>Actions</center></th>
                            <th width="2%"><center>Onboard</center></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>                            
                </table>

                <!-- backbonejs view template -->
                <script id="promotion-list-item" type="text/template">
                    <td><center><%= (counter)? counter : ''  %></center></td>
                    <td><center><%= (old_pos)? old_pos : ''  %></center></td>
                    <td><center><%= (new_pos)? new_pos : ''  %></center></td>
                    <td>
                      <a href="<?php echo site_url();?>resume/<%= (hash)? hash : '' %>" target="_blank" >
                        <%= (fullname)? fullname : ''  %>
                      </a>
                    </td>
                    <td class="fs11px"><center><%= (medical_issued)? medical_issued : ''  %></center></td>
                    <td class="fs11px"><center><%= (sirb)? sirb : ''  %></td>
                    <td class="fs11px"><center><%= (passport_expired)? passport_expired : ''  %></center></td>
                    <td class="fs11px"><center><%= (coc_expired)? coc_expired : ''  %></center></td>
                    <td class="fs11px"><center><%= (extension)? extension : ''  %></center></td>
                    <td><%= (remarks)? remarks : ''  %></td>
                    <td>
                        <div class="btn-group">
                            <center>
                            <% if(ispromoted == 0){  %>
                                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                                <a class="promote-embark" rel="tooltip" title="Embarked"
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-embarked"></i>
                                </a>   
                                <?php endif; ?>

                                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                                <a class="promotion-delete" rel="tooltip" title="Remove" 
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-remove"></i>
                                </a>
                                <?php endif; ?>                                 
                            <% } else {  %>   
                                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                                <a class="edit-promote" rel="tooltip" title="Edit Promotion"
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-edit"></i>
                                </a>   
                                <?php endif; ?>

                                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                                <a class="final-delete3" rel="tooltip" title="Remove" 
                                    href="javascript:void(0);" data-toggle="modal">
                                    <i class="icon-remove"></i>
                                </a> 
                                <?php endif; ?> 
                            <% }  %>
                            </center>      
                        </div>
                    </td>
                    <td class="<%= (ispromoted)? ((ispromoted == 1)? 'tdc1' : 'tdc2') : ''  %>"><center><%= (ispromoted)? ((ispromoted == 1)? 'Yes' : 'No' ) : ''  %></center></td>
                </script>

                <script id="option-promote-template" type="text/template">
                    <div class="inopt">
                        <div class="control-group popover-title">
                            <h3><%= (fullname)? fullname : '' %> <span class="pull-right"><%= (crew_id)? crew_id : '' %></span></h3>
                            <h5>New Position: <%= (new_position)? new_position : '' %> </h5>
                            <input type="hidden" value="<%= (id)? id : 0 %>" name="promotion_id" />
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
                                <input type="text" style="width: 70%" value="<%= (joining_port)? joining_port : '' %>" name="joining_port"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputpdos_date">PDOS No. :</label>
                            <div class="controls">
                                <input type="text" style="width: 35%" value="<%= (pdos_nos)? pdos_nos : '' %>" name="pdos_nos"/>
                                <input type="text" class="defaultdate" style="width: 33%" placeholder="PDOS Date" value="<%= (pdos_date)? pdos_date : '' %>" name="pdos_date"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputoec_nos">OEC No :</label>
                            <div class="controls">
                                <input type="text" style="width: 45%" value="<%= (oec_nos)? oec_nos : '' %>" name="oec_nos"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="start_date">Date of Promotion/Transfer:</label>
                            <div class="controls">
                                <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="extension_date" style="width: 25%;" value="<%= (extension_date)? extension_date : '' %>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="extension_date">Extension Date:</label>
                            <div class="controls">
                                <input type="text" placeholder="mm/dd/yyyy" name="end_date" style="width: 25%;" value="<%= (end_date)? end_date : '' %>" <%= (duration_month == 0)? 'readonly' : ' class="defaultdate"' %>/>
                                &nbsp; <small>Applicable for Extension Only</small>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="remarks">Remarks:</label>
                            <div class="controls">
                                <input type="text" name="remarks"  value="<%= (remarks)? remarks : '' %>" />
                            </div>
                        </div>
                    </div>
                </script>

                <script id="edit-promote-template" type="text/template">
                    <div class="inopt">
                        <div class="control-group popover-title">
                            <h3><%= (fullname)? fullname : '' %> <span class="pull-right"><%= (crew_id)? crew_id : '' %></span></h3>
                            <h5>New Position: <%= (new_position)? new_position : '' %> </h5>
                            <input type="hidden" value="<%= (id)? id : 0 %>" name="promotion_id" />
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
                                <input type="text" style="width: 70%" value="<%= (joining_port2)? joining_port2 : '' %>" name="joining_port"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputpdos_date">PDOS No. :</label>
                            <div class="controls">
                                <input type="text" style="width: 35%" value="<%= (pdos_nos)? pdos_nos : '' %>" name="pdos_nos"/>
                                <input type="text" class="defaultdate" style="width: 33%" placeholder="PDOS Date" value="<%= (pdos_date)? pdos_date : '' %>" name="pdos_date"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputoec_nos">OEC No :</label>
                            <div class="controls">
                                <input type="text" style="width: 45%" value="<%= (oec_nos)? oec_nos : '' %>" name="oec_nos"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="duration">Duration:</label>
                            <div class="controls">
                                <select name="duration_month" style="width: 150px; margin-bottom: 0;">
                                    <option value="0" <%= (duration_month == 0)? 'selected="selected"' : ''  %> >Promotion/Transfer Only</option>
                                    <option value="1" <%= (duration_month == 1)? 'selected="selected"' : ''  %> >1 mo</option>
                                    <?php 
                                    for($i=2; $i <= 15; $i++){
                                        echo "<option value='{$i}' ";
                                    ?>
                                        <%= (duration_month == <?= $i?>)? 'selected="selected"' : ''  %>
                                    <?php
                                        echo ">{$i} mos</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="start_date">Date of Promotion/Transfer:</label>
                            <div class="controls">
                                <input type="text" class="defaultdate" placeholder="mm/dd/yyyy" name="extension_date" style="width: 25%;" value="<%= (extension_date)? extension_date : '' %>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="start_date">Extension Date:</label>
                            <div class="controls">
                                <input type="text" placeholder="mm/dd/yyyy" name="end_date" style="width: 25%;" value="<%= (end_date)? end_date : '' %>" <%= (duration_month == 0)? 'readonly' : ' class="defaultdate"' %>/>
                                &nbsp; <small>Applicable for Extension Only</small>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="remarks">Remarks:</label>
                            <div class="controls">
                                <input type="text" name="remarks"  value="<%= (remarks)? remarks : '' %>" />
                            </div>
                        </div>
                    </div>
                </script>

                <?php $this->load->view('template/pagination');?>

                <script type="text/javascript">
                    $(document).ready(function() {
                        var promotionItems = new PromotionCollection();

                        <?php if($id): ?>
                            promotionItems.sched_id = <?php echo $id; ?>;
                            promotionItems.vessel_id = <?php echo $vessel_id; ?>;
                            promotionItems.end_date = "<?php echo date('Y-m', strtotime($repat_date)); ?>";
                        <?php endif; ?>
                   
                        var promotionmasterView = new PromotionMasterView({collection: promotionItems});
                        var promotionpagination = new PromotionPaginatedView({collection: promotionItems});           
                    });
                </script>

                <script type="text/template" id="alertpe7Template">
                    <div class="alert alert-<%= type %>">
                        <button class="close" data-dismiss="alert" type="button">×</button>
                        <%= message %>
                    </div>
                </script>
            </div>
        </div>

        <!-- Modal Embark -->          
        <div class="modal hide fade" id="promoteData" style="width: 800px; margin: -250px 0 0 -400px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3>Promotion/Transfer <small>&raquo; Setup</small></h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div id="container-option-promote"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-primary" id="options-update">Update</a>
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            </div>
        </div>

        <div class="modal hide fade" id="editPromote">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3>Promotion/Transfer <small>&raquo; Setup</small></h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div id="container-option-editPromote"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-primary" id="options-update">Update</a>
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            </div>
        </div>
        <!-- End Edit -->

        <!-- Modal Delete --> 
        <div class="modal hide fade" id="deletePromotion">
            <div class="modal-header">
              <a href="#" data-dismiss="modal" class="close">&times;</a>
              <h3>Delete Post</h3>
            </div>
            <div class="modal-body">
              <p>You are about to delete this record.</p>
              <p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
              <a href="#" data-dismiss="modal" class="btn btn-danger" id="promotion-delete">Yes</a>
              <a href="#" data-dismiss="modal" class="btn secondary">No</a>
            </div>
        </div>
        
        <div class="modal hide fade" id="finalDelete3">
            <div class="modal-header">
              <a href="#" data-dismiss="modal" class="close">&times;</a>
              <h3>Cancel Promotion/Transfer</h3>
            </div>
            <div class="modal-body">
              <p>You are about to cancel this promotion.</p>
              <p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
              <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
              <a href="#" data-dismiss="modal" class="btn secondary">No</a>
            </div>
        </div>
        <!-- Modal Delete --> 

        <!-- Modal Add -->   
        <div id="endorse-list-view">       
            <div class="modal hide fade" id="addPromotion" style="width: 800px; margin: -250px 0 0 -400px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Crew Onboard <small>&raquo; Master List</small></h3>
                </div>
                <div class="modal-body">
                    <div class="pull-right" id="endorsepagination"></div>
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="esearch" autocomplete="off" />
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <span id="loader-e-container"></span>
                    </form>   

                    <div class="clearfix" style="margin-bottom: 20px;"></div>

                    <table class="responsive-table" id="options-table-endorse">
                        <thead>
                          <tr>
                            <th width="2%" class="sortcolumn" col="crew_id">ID</th>
                            <th width="5%" class="sortcolumn" col="position_id">Rank</th>
                            <th width="10%">New Position</th>
                            <th width="35%" class="sortcolumn" col="name">Name</th>
                            <th width="20%">Extension</th>
                            <th width="25%">Remarks</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>                            
                    </table>
                    <!-- backbonejs view template -->
                    <script id="endorse-list-item" type="text/template">   
                        <td><input type='checkbox' name='ischeck' id="ischeck" value='0' style='margin-bottom: 0;' />
                            <input type='hidden' name='onboard_id' value='<%= (onboard_id)? onboard_id : 0 %>' />
                        </td>
                        <td><%= (code)? code : '' %></td>
                        <td>
                            <?php 
                                if($positions){
                                    echo "<select name='salary_id' style='width: 80px; margin-bottom: 0;'>";
                                    foreach ($positions as $value) {
                                        echo "<option value='{$value->salary_id}'>{$value->code}</option>";
                                    }
                                    echo "</select>";
                                }
                            ?>
                        </td>
                        <td><a href="<?php echo site_url();?>resume/<%= (hash)? hash : '' %>" data-original-title="<%= (fullname)? fullname : ''  %>" target="_blank">
                                <%= (fullname)? fullname : ''  %>
                            </a>
                        </td>
                        <td>
                            <select name="duration_month" style="width: 80px; margin-bottom: 0;">
                                <option value="0">Promotion/Transfer Only</option>
                                <option value="1">1 mo</option>
                                <?php for($i=2; $i <= 15; $i++){
                                    echo "<option value='{$i}'>{$i} mos</option>";
                                } ?>
                            </select>
                        </td> 
                        <td><input type="text" name="premarks" id="inputremarks" value="" style="width: 91%; margin-bottom: 0;" />&nbsp;</td>
                        
                    </script>

                    <?php $this->load->view('template/pagination');?>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                    <a href="#" data-dismiss="modal" class="btn btn-success" id="endorse-submit">Submit</a>
                </div>
            </div>
        </div>
        <!-- End Add -->
    </div>
</div>





