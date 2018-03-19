<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Name:"; }
  td:nth-of-type(2):before { content: "Position:"; }
  td:nth-of-type(3):before { content: "Department:"; }
  td:nth-of-type(4):before { content: "Gender:"; }
  td:nth-of-type(5):before { content: "Status:"; }
  td:nth-of-type(6):before { content: "Actions:"; }
  td:nth-of-type(7):before { content: "Crew ID:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Crew (No Position) <small>&raquo; Master File</small></h2>
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

                    <div id="alert-div"></div> 

                    <div class="tab-pane fade in" id="status_id-1">
                        <table class="responsive-table" id="options-table-1">
                            <thead>
                                <tr>
                                    <th class="sortcolumn" col="fullname">Name</th>
                                    <th class="sortcolumn" col="position_id">Position</th>                                
                                    <th class="sortcolumn" col="birthdate">Birthdate</th>
                                    <th class="sortcolumn" col="vessel_id">Last Vessels</th>
                                    <th>Status</th>
                                    <th>Date Hired</th>
                                    <th class="sortcolumn" col="crew_id" style="width: 3%;">Crew ID</th>
                                    <th class="sortcolumn" col="payroll_id" style="width: 3%;">Payroll ID</th>
                                    <th class="sortcolumn" col="profit_id" style="width: 3%;">Profit ID</th>
                                    <th style="width: 7%;"><center>Actions</center></th>
                                </tr>
                            </thead>
                            <tbody></tbody>   
                            <tfoot>
                                <tr>
                                    <th colspan="10" style="text-align: right" id="test">
                                        Total Records: <span id="total_records"></span>
                                    </th>
                                </tr>
                            </tfoot>                        
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
            <a href="<?php echo site_url();?>resume/<%= hash %>" data-original-title="<%= (fullname)? fullname : ''  %>">
                <%= (fullname)? fullname : ''  %>
            </a>
        </td>
        <td><%= (position)? position : '' %>&nbsp;</td>
        <td><%= (birthdate)? birthdate : '' %>&nbsp;</td>
        <td>
            <% if(vessel_name) { %>
                <% if(status_id == 3) { %>

                <?php echo form_open('crew-list', 'class="form1D" '); ?>
                
                <input type="hidden" name="vessel_id" id="vessel_id" value="<%= (vessel_id)? vessel_id : '' %>">
                <input type="hidden" name="month" id="month" value="<?php echo date('n'); ?>">
                <input type="hidden" name="day" id="day" value="<?php echo date('j'); ?>">
                <input type="hidden" name="year" id="year" value="<?php echo date('Y'); ?>">
                <button type="submit" id="minifest"><%= (vessel_name)? vessel_name : 'No Record' %></button>
                <% } else { %>
                <%= (vessel_name)? vessel_name : '' %>
                <% } %>
            <?php echo form_close(); ?>
            <% } else { %>
            No Record
            <% } %>
        </td>
        <td><%= (status)? status : '' %>&nbsp;</td>
        <td><%= (date_hired)? date_hired : '' %>&nbsp;</td>
        <td><%= (crew_id)? crew_id : '' %>&nbsp;</td>
        <td><%= (payroll_id)? payroll_id : '' %>&nbsp;</td>
        <td><%= (profit_id)? profit_id : '' %>&nbsp;</td>
        <td>
            <div class="btn-group">
                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                <a class="btn record-edit" rel="tooltip" title="Edit" 
                    href="<?php echo site_url('crew-applicant'); ?>/<%= (hash)? hash : '' %>">
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
</div>
