<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Name:"; }
  td:nth-of-type(2):before { content: "Position:"; }
  td:nth-of-type(3):before { content: "Department:"; }
  td:nth-of-type(4):before { content: "Gender:"; }
  td:nth-of-type(5):before { content: "Remarks:"; }
  td:nth-of-type(6):before { content: "Crew ID:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Crew <small>&raquo; Search </small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="">
                        <a title="stand by" rel="tooltip" dep="2" data-toggle="tab" href="#status_id-2"> STAND BY </a>
                    </li>
                    <li class="">
                        <a title="on board" rel="tooltip" dep="3" data-toggle="tab" href="#status_id-3"> ON BOARD </a>
                    </li>
                    <li class="active">
                        <a title="all" rel="tooltip" dep="0" data-toggle="tab" href="#status_id-0"> ALL </a>
                    </li> 
                </ul>          
                <div id="myTabContent" class="tab-content">                    
                    <div class="pull-right" id="pagination"></div>
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                        <select name="position_id" id="position_id" style="width: 150px;">
                            <option value='0'>All Position</option>
                            <?php 
                                if($positions){
                                    foreach ($positions as $value) {
                                        echo "<option value='{$value->id}'>{$value->position}</option>";
                                    }
                                }
                            ?>
                        </select>
                        <select name="principal_id" id="principal_id" style="width: 230px;">
                            <option value=''>All Principal</option>
                            <?php 
                                if($principals){
                                    foreach ($principals as $value) {
                                        echo "<option value='{$value->id}'>{$value->fullname}</option>";
                                    }
                                }
                            ?>
                        </select>
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <a class="btn report-print" rel="tooltip" title="Export" target="_blank"
                            href="<?php echo site_url("crew-principal/"); ?>" >
                            <i class="icon-excel"></i>
                        </a> 
                        <span id="loader-container"></span>
                    </form>   

                    <div id="alert-div"></div> 

                    <?php foreach ($options_record as $options_value):?>
                    <div class="tab-pane fade in" id="status_id-<?php echo $options_value->option_id;?>">
                        <table class="responsive-table" id="options-table-<?php echo $options_value->option_id;?>">
                            <thead>
                                <tr>
                                    <th class="sortcolumn" col="fullname">Name</th>
                                    <th class="sortcolumn" col="position_id">Position</th>                                   
                                    <th class="sortcolumn" col="birthdate">Birthdate</th>
                                    <th class="sortcolumn" col="vessel_id">Last Vessels</th>           
                                    <th class="sortcolumn" col="principal_id">Principal</th> 
                                    <th style="width: 25%;">Manager's Remarks</th>
                                    <th style="width: 5%;">Crew ID</th>
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
          <a href="<?php echo site_url();?>resume/<%= hash %>" data-original-title="<%= (fullname)? fullname : ''  %>">
            <%= (fullname)? fullname : ''  %>
          </a>
        </td>
        <td><%= (position)? position : '' %>&nbsp;</td>
        <td><%= (birthdate)? birthdate : '' %>&nbsp;</td>
        <td>
            <% if(status_id == 2) { %>
                <%= (vessel_name)? vessel_name : '' %> <br/> <small style="font-size: 80%">(Stand by)</small>
            <% } else { %>
                <% if(vessel_name) { %>
                <?php echo form_open('crew-list', 'class="form1D" '); ?>
                
                <input type="hidden" name="vessel_id" id="vessel_id" value="<%= (vessel_id)? vessel_id : '' %>">
                <input type="hidden" name="month" id="month" value="<?php echo date('n'); ?>">
                <input type="hidden" name="day" id="day" value="<?php echo date('j'); ?>">
                <input type="hidden" name="year" id="year" value="<?php echo date('Y'); ?>">
                <button type="submit" id="minifest" style="text-align: left"><%= (vessel_name)? vessel_name : 'No Record' %></button>
                <?php echo form_close(); ?>
                <% } else { %>
                No Record
            <% } %>
            <% } %>
        </td>
        <td><%= (principal)? principal : '' %>&nbsp;</td>
        <td><%= (manager_comment)? manager_comment : '' %>&nbsp;</td>
        <td><%= (crew_id)? crew_id : '' %>&nbsp;</td>
    </script>

    <?php $this->load->view('crew/promote_crew')?>

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
