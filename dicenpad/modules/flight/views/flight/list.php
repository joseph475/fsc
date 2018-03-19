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
                <h2>Scheduling <small>&raquo; For Flight Assignment</small></h2>
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
    <script id="emp-list-item" type="text/template"> 
        <td>
            <a href="<?php echo site_url('vessel-specification');?>/<%= (vessel_id)? vessel_id : 0 %>"
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
                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a class="btn record-edit" rel="tooltip" title="Edit" 
                    href="<?php echo site_url();?>flight-schedule/<%= (control_nos)? control_nos : 0 %>">
                    <i class="icon-edit"></i> Flight Assignment
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
