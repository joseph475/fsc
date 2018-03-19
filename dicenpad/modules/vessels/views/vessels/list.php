<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Name:"; }
  td:nth-of-type(2):before { content: "Principal:"; }
  td:nth-of-type(3):before { content: "Type:"; }
  td:nth-of-type(4):before { content: "Engine:"; }
  td:nth-of-type(5):before { content: "Year:"; }
  td:nth-of-type(6):before { content: "Flag:"; }
  td:nth-of-type(7):before { content: "Status:"; }
  td:nth-of-type(8):before { content: "Actions:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Vessels <small>&raquo; Master File</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <?php foreach ($options_record as $options_value): ?>
                    <li>
                        <a href="#status_id-<?php echo strtolower($options_value['status']);?>" 
                            data-toggle="tab" dep="<?php echo strtolower($options_value['status']);?>"
                            rel="tooltip" title="<?php echo strtolower($options_value['status']);?>">
                            <?php echo strtoupper($options_value['status']);?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>           
                <div id="myTabContent" class="tab-content">                    
                    <div class="pull-right" id="pagination"></div>
                
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                            <a class="btn record-add" rel="tooltip" title="Add" 
                            href="<?php echo site_url() . 'vessel-entry'; ?>">
                                <i class="icon-plus"></i>
                            </a> 
                        <?php endif;?>
                        <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                            <a class="btn vessel-list-print" rel="tooltip" title="Export" target="_blank"
                                href="<?php echo site_url("report/vessels-list"); ?>" >
                                <i class="icon-pdf"></i>
                            </a> 
                        <?php endif; ?>
                        <span id="loader-container"></span>
                    </form>

                    <div class="clearfix"></div>

                    <?php foreach ($options_record as $options_value): ?>
                    <div class="tab-pane fade in" id="status_id-<?php echo strtolower($options_value['status']);?>">
                        <table class="responsive-table" style="font-size: 12px;" id="options-table-<?php echo strtolower($options_value['status']);?>">
                            <thead>
                              <tr>
                                <th class="sortcolumn" col="vessel_name" width="20%">Name</th>
                                <th class="sortcolumn" col="principal_id" width="25%">Principal</th>   
                                <th class="sortcolumn" col="jd_vessels.type_id" width="15%">Type</th> 
                                <th>Engine</th>
                                <th class="sortcolumn" col="e_year">Year</th>
                                <th class="sortcolumn" col="flag_id">Flag</th>
                                <th class="sortcolumn" col="status">Status</th>
                                <th class="sortcolumn" col="control_nos">Control Nos</th>
                                <th width="7%">Actions</th>
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
                    <?php endforeach;?>
                </div>
            </div>
        </div><!--/span-->
    </div><!--/row-->
    
    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">        
        <td>
            <a href="<?php echo site_url();?>vessel-specification/<%= (id)? id : 0 %>"
                data-original-title="<%= (vessel_name)? vessel_name : '' %>">
                <%= (vessel_name)? vessel_name : '' %>
            </a>
            <br>
            <%= (ex_vessel_name)? '<small style="font-size: 9px;">( ' + ex_vessel_name + ' )</small>' : '' %> 
        </td>
        <td><%= (principal)? principal : '' %>&nbsp;</td>
        <td><%= (vessel_sub_type)? vessel_sub_type : '' %>&nbsp;</td>
        <td><%= (engine)? engine : '' %>&nbsp;</td>
        <td><%= (e_year)? e_year : '' %>&nbsp;</td>
        <td><%= (flag)? flag : '' %>&nbsp;</td>
        <td><%= (status)? status : '' %>&nbsp;</td>
        <td><%= (control_nos)? control_nos : '' %>&nbsp;</td>
        <td>
            <div class="btn-group">
                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                <a class="btn" rel="tooltip" title="Edit" 
                    href='<?php echo site_url();?>vessel-entry/<%= id %>'>
                    <i class="icon-edit"></i>
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

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var typeahead = new TypeAheadCollection();
            var paginatedItems = new PaginatedCollection();
            var directoryView = new DirectoryView({collection: paginatedItems});
            var pagination = new PaginatedView({collection: paginatedItems});

            <?php if($principal_id) { ?>
            paginatedItems.principal_id = <?php echo $principal_id; ?>;
            <?php } ?>
            
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
