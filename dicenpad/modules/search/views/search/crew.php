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
                <h2>Crew <small>&raquo; Search</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <?php foreach ($options_record as $index => $options_value):?>
                        <?php if ($index < 8):?>
                            <li>
                                <a href="#status_id-<?php echo strtolower($options_value->option_id)?>" 
                                    data-toggle="tab" dep="<?php echo strtolower($options_value->option_id)?>"
                                    rel="tooltip" title="<?php echo strtolower($options_value->option); ?>">
                                    <?php echo (strlen($options_value->option) > 20) ? substr($options_value->option,0,20) . '&hellip;' : ucwords(strtoupper($options_value->option));?>
                                </a>
                            </li>
                        <?php ;else:?>
                            <li <?php if ($index == 8): ?> class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    MORE
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                <?php ;else:?>
                                ><!-- end <li> -->
                                <?php endif;?>
                                <a href="#status_id-<?php echo strtolower($options_value->option_id)?>" 
                                    data-toggle="tab" dep="<?php echo strtolower($options_value->option_id)?>"
                                    rel="tooltip" title="<?php echo strtolower($options_value->option);?>"
                                    >
                                    <?php echo ucwords(strtoupper($options_value->option));?>
                                </a>
                            </li>
                            <?php if ($index == (count($options_record) - 1)):?></ul><?php endif;?>
                        <?php endif;?>
                    <?php endforeach;?>  
                </ul>          
                <div id="myTabContent" class="tab-content">                    
                    <div class="pull-right" id="pagination"></div>
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                        <select name="position_id" id="position_id" style="width: 150px;">
                            <option value=''>&nbsp;</option>
                            <?php 
                                if($positions){
                                    foreach ($positions as $value) {
                                        echo "<option value='{$value->id}'>{$value->position}</option>";
                                    }
                                }
                            ?>
                        </select>
                        <button type="submit" class="btn" id="submit-search">Search</button>
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
                                    <th>Manager's Remarks</th>
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
            <% if(vessel_name) { %>
            <?php echo form_open('crew-list', 'class="form1D" '); ?>
            
            <input type="hidden" name="vessel_id" id="vessel_id" value="<%= (vessel_id)? vessel_id : '' %>">
            <input type="hidden" name="month" id="month" value="<?php echo date('n'); ?>">
            <input type="hidden" name="day" id="day" value="<?php echo date('j'); ?>">
            <input type="hidden" name="year" id="year" value="<?php echo date('Y'); ?>">
            <button type="submit" id="minifest"><%= (vessel_name)? vessel_name : 'No Record' %></button>
            <?php echo form_close(); ?>
            <% } else { %>
            No Record
            <% } %>
        </td>
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
