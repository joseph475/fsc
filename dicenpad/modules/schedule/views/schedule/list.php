<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Vessel Name:"; }
  td:nth-of-type(2):before { content: "Reference #:"; }
  td:nth-of-type(3):before { content: "Joining Date:"; }
  td:nth-of-type(4):before { content: "Repat Date:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Scheduling <small>&raquo; List</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <li>
                        <a href="#status_id-1" 
                            data-toggle="tab" dep="1"
                            rel="tooltip" title="1">
                            Master List
                        </a>
                    </li>
                </ul>  
                <div id="myTabContent" class="tab-content">                    
                    <div class="pull-right" id="pagination"></div>
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        
                        <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                            <a class="btn record-add" rel="tooltip" title="Add" 
                            href="<?php echo site_url();?>schedule-replacement">
                                <i class="icon-plus"></i>
                            </a> 
                        <?php endif; ?>
                        <span id="loader-container"></span>
                    </form>   
                    
                    <div class="clearfix"></div> 

                    <div id="alert-div"></div> 

                    <div class="tab-pane fade in" id="status_id-1">
                        <table class="responsive-table" id="options-table-1">
                            <thead>
                                <tr>
                                    <th class="sortcolumn" col="vessel_id">Vessel Name</th>
                                    <th class="sortcolumn" col="control_nos">Reference #</th>
                                    <th>Principal</th>
                                    <th class="sortcolumn" col="joining_date">Joining Date</th>                         
                                    <th class="sortcolumn" col="repat_date">Repat Date</th>                       
                                    <th class="sortcolumn" col="joining_port">Joining Port</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>                            
                        </table>
                        <div id="load-more-container" class="visible-phone">
                            <p>
                                <div class="progress progress-striped active">
                                    <div class="bar" style="width:100%;background-color:#eee"></div>
                                </div>
                                <div style="text-align:center">
                                    <a href="javascript:void(0);" id="loadmore-options">Load more</a>
                                </div>  
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/span-->
    </div><!--/row-->

    <!-- backbonejs view template -->
    <?php if($principal_id == 39){ ?>

        <script id="emp-list-item" type="text/template"> 
          <% if (principal == "SANTOKU SENPAKU CO., LTD.") { %>
            <td>
                <a href="<?php echo site_url();?>vessel-specification/<%= (vessel_id)? vessel_id : 0 %>"
                    data-original-title="<%= (vessel_name)? vessel_name : '' %>">
                    <%= (vessel_name)? vessel_name : '' %>
                </a>
            </td>
            <td><%= (control_nos)? control_nos : '' %>&nbsp;</td> 
            <td><%= (principal)? principal : '' %>&nbsp;</td>
            <td><%= (j_date1)? j_date1 : '' %>&nbsp;</td>       
            <td><%= (r_date1)? r_date1 : '' %>&nbsp;</td>
            <td><%= (joining_port)? joining_port : '' %>&nbsp;</td>
            <td>
                <div class="btn-group">
                    <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                    <a class="btn record-export" rel="tooltip" title="Export" target="_blank"
                        href="<?= site_url('schedule-for-crew-replacement');?>/<%= (control_nos)? control_nos : 0 %>">
                        <i class="icon-pdf"></i> 
                    </a>
                    <?php endif; ?>

                    <?php if(is_allowed(getclass($clssnme, FALSE, 1))): ?>
                    <a class="btn record-edit" rel="tooltip" title="Edit" 
                        href="<?php echo site_url();?>schedule-replacement/<%= (control_nos)? control_nos : 0 %>">
                        <i class="icon-search"></i>
                    </a>
                    <?php endif; ?>  

                    <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                    <a class="btn record-delete" rel="tooltip" title="Remove" 
                        href="javascript:void(0);" data-toggle="modal">
                        <i class="icon-remove"></i>
                    </a>     
                    <?php endif; ?>     
     
                </div>
            </td>

          <% } %>
        </script>
     <?php } else {?>

       <script id="emp-list-item" type="text/template"> 
        <td>
            <a href="<?php echo site_url();?>vessel-specification/<%= (vessel_id)? vessel_id : 0 %>"
                data-original-title="<%= (vessel_name)? vessel_name : '' %>">
                <%= (vessel_name)? vessel_name : '' %>
            </a>
        </td>
        <td><%= (control_nos)? control_nos : '' %>&nbsp;</td> 
        <td><%= (principal)? principal : '' %>&nbsp;</td>
        <td><%= (j_date1)? j_date1 : '' %>&nbsp;</td>       
        <td><%= (r_date1)? r_date1 : '' %>&nbsp;</td>
        <td><%= (joining_port)? joining_port : '' %>&nbsp;</td>
        <td>
            <div class="btn-group">

                <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                <a class="btn record-export" rel="tooltip" title="Export" target="_blank"
						href="<?= site_url('schedule-for-crew-replacement');?>/<%= (control_nos)? control_nos : 0 %>">					
                    <i class="icon-pdf"></i> 
                </a>
                <?php endif; ?>

                <?php if(is_allowed(getclass($clssnme, FALSE, 1))): ?>
                <a class="btn record-edit" rel="tooltip" title="Edit" 
                    href="<?php echo site_url();?>schedule-replacement/<%= (control_nos)? control_nos : 0 %>">
                    <i class="icon-search"></i>
                </a>
                <?php endif; ?>  

                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                <a class="btn record-delete" rel="tooltip" title="Remove" 
                    href="javascript:void(0);" data-toggle="modal">
                    <i class="icon-remove"></i>
                </a>     
                <?php endif; ?>     
 
            </div>
        </td>
    </script>



    <?php }?>
    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var typeahead = new TypeAheadCollection();
            var paginatedItems = new PaginatedCollection();
            var directoryView = new DirectoryView({collection: paginatedItems});
            var pagination = new PaginatedView({collection: paginatedItems});

            //var form = new OptionsForm({typeahead: directoryView});

            $(window).scroll(function() {
                 if (!directoryView.collection.isLoading && $('#load-more-container').is(':visible')
                    && $(window).scrollTop() + $(window).height() > getDocHeight() - 100 ) {
                    $('#loadmore-employee').trigger('click');
                }
            });
            var app_router = new EmployeeListRouter;

            Backbone.history.start();  
                   
        });
    </script>

    <script type="text/template" id="alertTemplate">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>

    <!-- Modal Delete --> 
    <div class="modal hide fade" id="deleteData">
        <div class="modal-header">
          <a href="#" data-dismiss="modal" class="close">&times;</a>
          <h3>Delete Post</h3>
        </div>
        <div class="modal-body">
          <p>You are about to delete this record.</p>
          <p>Do you want to proceed?</p>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn btn-danger">Yes</a>
          <a href="#" data-dismiss="modal" class="btn secondary">No</a>
        </div>
    </div>
    <!-- Modal Delete --> 
