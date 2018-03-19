<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "No:"; }
  td:nth-of-type(2):before { content: "Name:"; }
  td:nth-of-type(3):before { content: "Rank:"; }
  td:nth-of-type(4):before { content: "Date of Birth:"; }
  td:nth-of-type(5):before { content: "Seaman's Book Nos.:"; }
  td:nth-of-type(6):before { content: "ONBOARD Date:"; }
  td:nth-of-type(7):before { content: "Remarks:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Crew <small>&raquo; List</small></h2>
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
                        <select name="vessel_id" id="vessel_id" >
                            <?php 
                            foreach ($vessels as $v_value){ 
                                echo "<option value='{$v_value->id}' >{$v_value->vessel_name}</option>";
                            } 
                            ?>
                        </select>
                        <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                            <a class="btn report-print" rel="tooltip" title="Export" target="_blank"
                                href="<?php echo site_url("crew-list-report"); ?>" >
                                <i class="icon-pdf"></i>
                            </a> 
                        <?php endif; ?>    
                        <span id="loader-container"></span>
                    </form>   

                    <div id="alert-div"></div> 

                    <div class="tab-pane fade in" id="status_id-1">
                        <table class="responsive-table" id="options-table-1">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th class="sortcolumn" col="lastname">Name</th>   
                                <th>Rank</th>                             
                                <th>Date of Birth</th>
                                <th>Seaman's Book Nos.</th>
                                <th>ONBOARD Date</th>
                                <th>Remarks</th>
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
        <td><%= (counter)? counter : '' %></td>        
        <td>
          <a href="<?php echo site_url();?>resume/<%= hash %>"
            data-original-title="<%= (fullname)? fullname : ''  %>">
            <%= (fullname)? fullname : ''  %>
          </a>
        </td>
        <td><%= (code)? code : '' %></td>        
        <td><%= (birthdate)? birthdate : '' %></td>
        <td><%= (seaman_nos)? seaman_nos : '' %></td>
        <td><%= (start_date)? start_date : '' %></td>
        <td><%= (remarks)? remarks : '' %></td>
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