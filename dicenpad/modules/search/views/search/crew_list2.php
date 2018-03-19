<div style="margin-bottom: 50px"></div>
<div class="container-narrow" id="about-tab">

    <div class="row-section ">  
        <!-- CREW PERSONAL INFORMATION -->
        <div class="section-one">
            <div id="personal-info">
                <div class="row-title">VESSEL INFORMATION</div> 
                <div class="row-details" style="padding-top: 20px;">
                   
                    <div id="profile-header">    
                        <div class="pull-right">
                            <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                                <div class="btn-group pull-left"  style="margin-right: 5px;">
                                    <a id="edit-profile-btn" href="#" class="btn"> Crew list </a>
                                    <a href="#" data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <?php echo form_open('crew-list-report', 'class="form1D" target="_blank"'); ?>     
                                            <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo _p($about, 'id'); ?>">
                                            <input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
                                            <button type="submit" id="minifest"><i class="icon-pdf"></i> Original</button> 
                                            <?php echo form_close(); ?>  
                                        </li>
                                        <li>
                                            <?php echo form_open('drop-crew-list-report', 'class="form1D" target="_blank"'); ?>     
                                            <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo _p($about, 'id'); ?>">
                                            <input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
                                            <button type="submit" id="minifest"><i class="icon-pdf"></i> Draft</button> 
                                            <?php echo form_close(); ?>   
                                        </li>
                                    </ul>            
                                </div>   

                                <!-- 
                                <div class="btn-group pull-left" style="margin-right: 5px;">
                                    <a id="edit-profile-btn" href="#" class="btn"> Memo list </a>
                                    <a href="#" data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <?php //echo form_open('memo-list-report', 'class="form1D" target="_blank"'); ?>     
                                            <input type="hidden" name="vessel_id" id="vessel_id" value="<?php //echo _p($about, 'id'); ?>">
                                            <input type="hidden" name="date" id="date" value="<?php //echo $date; ?>">
                                            <button type="submit" id="minifest"><i class="icon-pdf"></i> Original</button> 
                                            <?php //echo form_close(); ?>  
                                        </li>
                                        <li>
                                            <?php //echo form_open('drop-memo-list-report', 'class="form1D" target="_blank"'); ?>     
                                            <input type="hidden" name="vessel_id" id="vessel_id" value="<?php //echo _p($about, 'id'); ?>">
                                            <input type="hidden" name="date" id="date" value="<?php //echo $date; ?>">
                                            <button type="submit" id="minifest"><i class="icon-pdf"></i> Draft</button> 
                                            <?php //echo form_close(); ?>   
                                        </li>
                                    </ul>            
                                </div> -->   
                            <?php endif; ?>         
                       
                            <div class="pull-right" style="margin-right: 3px;">
                                <a class="btn" href="<?php echo site_url("search-by-vessel"); ?>">Back to Search</a>
                            </div>      
                        </div>

                        <!-- Profile Header -->
                        <img src="<?php echo $thumb_url; ?>" width="106" id="user-photo">

                <?php if($principal_id): ?>
                    <h2><?php echo _p($about, 'vessel_name'); ?></h2>
                <?php endif; ?>  

                 <?php if(!$principal_id): ?>

                        <a href="<?php echo site_url("vessel-specification/"  . _p($about, 'id')); ?>"><h2><?php echo _p($about, 'vessel_name'); ?></h2></a>
                <?php endif; ?> 

                        <h5><span>PRINCIPAL:</span> <?php echo _p($about, 'principal'); ?></h5>
                        <h5><span>FLAG:</span> <?php echo _p($about, 'flag'); ?></h5>

                        
                        <div class="pull-right"><h5>Date: <?php echo date('F d, Y', strtotime($date)); ?></h5></div>
                        <div class="clearfix"></div>
                    </div>
              

                    <div style="margin-bottom: 20px"></div>
                            
                    <table class="responsive-table" id="options-table-1">
                        <tbody>
                            <tr>
                                <td width="15%"><h5>Manning Agent</h5></td>
                                <td width="20%"><?= (_p($about, 'company_id') == 1)? 'FAIR SHIPPING CORPORATION' : 'CORDIAL SHIPPING INC.' ?></td>
                                <td width="15%"><h5>Vessel Type</h5></td>
                                <td width="20%"><?php echo _p($about, 'vessel_sub_type'); ?></td>
                            </tr>
                            <tr>
                                <td><h5>GRT</h5></td>
                                <td><?php echo _p($about, 'gross'); ?></td>   
                                <td><h5>HP</h5></td>
                                <td><?php echo _p($about, 'hp'); ?></td> 
                            </tr>
                            <tr>
                                <td><h5>Year Built</h5></td>
                                <td><?php echo _p($about, 'e_year'); ?></td>   
                                <td><h5>IMO Nos.</h5></td>
                                <td><?php echo _p($about, 'imo_nos'); ?></td> 
                            </tr>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                </div>
            </div>

        </div>

        <!-- EDUCATIONAL ATTAINMENT -->
        <div class="section-two">
            <div class="row-title">CREW LIST</div> 
            <div id="crewlist-info"> 
                <div class="row-details" style="padding-top: 20px;">            
                    <div id="myTabContent" class="tab-content"> 
                        <div class="pull-right" id="childpagination"></div>                                  

                        <div class="clearfix" style="margin-bottom: 20px;"></div>

                        <table class="responsive-table" id="options-table-crewlist">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name of Crew</th>  
                                    <th>Rank</th>                              
                                    <th><center>Date of Birth</center></th>
                                    <th><center>Seaman's Book No.</center></th>
                                    <th><center>Onboard Date</center></th>
                                    <th><center>Joining Port</center></th>
                                    <th><center>Duration</center></th>
                                    <th><center>Signed Contract</center></th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody></tbody>                            
                        </table>
                    </div>
                </div>
                <!-- 
                 <% if (file_docs) { %><a rel='tooltip' title='View Documents' target='_blank'
                    href='<?php //echo site_url();?>uploads/files/<%= file_docs %>'>
                    <% } %>
                    <%= (seaman_nos)? seaman_nos : '' %>
                    <% if (file_docs) { %>  </a> <% } %>
                    </center></td>
                -->
                
                <!-- backbonejs view template -->
                <script id="crew-list-item" type="text/template">      
                    <td><%= (counter)? counter : 0 %>&nbsp;</td>  
                    <td>
                      <a href="<?php echo site_url();?>resume/<%= hash %>" data-original-title="<%= (fullname)? fullname : ''  %>">
                        <%= (fullname)? fullname : ''  %>
                      </a>
                    </td>   
                    <td><%= (code)? code : '' %>&nbsp;</td> 
                    <td><center><%= (birthdate)? birthdate : '' %></center></td>
                    <td><center><%= (seaman_nos)? seaman_nos : '' %></center></td>
                    <td><center><%= (original_date)? original_date : '' %></center></td>
                    <td><%= (joining_port)? joining_port : '' %></td>
                    <td><center><%= (duration)? duration : '' %></center></td>
                    <td><center><%= (signedcontract)? signedcontract + ' mos' : '' %></center></td>
                    <td>
                    <?php echo form_open('crew-checklist', 'class="form1D" target="_blank"'); ?>                    
                    <input type="hidden" name="crew_id" id="crew_id" value="<%= (crew_id)? crew_id : '' %>">
                    <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo _p($about, 'id'); ?>">
                    <input type="hidden" name="date" id="date" value="<?php echo $date; ?>">
                    <button type="submit" id="submit" class="btn">Checklist</button> 
                    <?php echo form_close(); ?>
                    </td>
                </script>
                <!-- backbonejs view template -->
                <?php $this->load->view('template/pagination');?>

                <!-- Script for autoloading on mobile device -->
                <script type="text/javascript">
                    $(document).ready(function() {

                        var paginatedCrewListItems = new CrewListCollection();
                        <?php if(isset($vessel_id)): ?>
                            paginatedCrewListItems.vessel_id = <?php echo $vessel_id; ?>;
                            paginatedCrewListItems.date1 = "<?php echo date('Y-m-d', strtotime($date)); ?>"; 
                        <?php endif; ?>
                        var CrewListmasterView = new CrewListMasterView({collection: paginatedCrewListItems});
                        var CrewListpagination = new CrewListPaginatedView({collection: paginatedCrewListItems});           
                    });
                </script>

            </div>
        </div>  
    </div>

</div>