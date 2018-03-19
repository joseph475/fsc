<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Name:"; }
  td:nth-of-type(2):before { content: "Code:"; }
  td:nth-of-type(3):before { content: "Inactive:"; }
  td:nth-of-type(4):before { content: "Sort:"; }
  td:nth-of-type(5):before { content: "Actions:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Options <small>&raquo; Setup File</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <?php foreach ($options_record as $index => $options_value):?>
                    <?php if ($index < 5):?>
                        <li>
                            <a href="#status_id-<?php echo strtolower($options_value->option_group)?>" 
                                data-toggle="tab" dep="<?php echo strtolower($options_value->option_group)?>"
                                rel="tooltip" title="<?php echo strtolower($options_value->option_group); ?>">
                                <?php echo (strlen($options_value->option_group) > 20) ? substr($options_value->option_group,0,20) . '&hellip;' : ucwords(strtoupper($options_value->option_group));?>
                            </a>
                        </li>
                    <?php ;else:?>
                        <li <?php if ($index == 5): ?> class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                MORE
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                            <?php ;else:?>
                            ><!-- end <li> -->
                            <?php endif;?>
                            <a href="#status_id-<?php echo strtolower($options_value->option_group)?>" 
                                data-toggle="tab" dep="<?php echo strtolower($options_value->option_group)?>"
                                rel="tooltip" title="<?php echo strtolower($options_value->option_group);?>"
                                >
                                <?php echo ucwords(strtoupper($options_value->option_group));?>
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
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <?php if(is_allowed('ADMIN_OPTIONS_INSERT')): ?>
                            <a class="btn record-add" rel="tooltip" title="Add" 
                            href="javascript:void(0);" data-toggle="modal">
                                <i class="icon-plus"></i>
                            </a> 
                        <?php endif;?>
                        <span id="loader-container"></span>
                    </form>   

                    <div id="alert-div"></div>

                    <?php foreach ($options_record as $options_value):?>
                    <div class="tab-pane fade in" id="status_id-<?php echo strtolower($options_value->option_group);?>">
                        <table class="responsive-table" id="options-table-<?php echo strtolower($options_value->option_group);?>">
                            <thead>
                              <tr>
                                <th class="sortcolumn" col="name">Name</th>
                                <th class="sortcolumn" col="code">Code</th>                                
                                <th class="sortcolumn" col="inactive">Inactive</th>
                                <th>Sort</th>
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
                    <?php endforeach;?>
                </div>
            </div>
        </div><!--/span-->
    </div><!--/row-->
    
    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">          
        <td><%= (option)? option : '' %></td>
        <td><%= (option_code)? option_code : '' %>&nbsp;</td>        
        <td><%= (inactive == 1)? 'Yes' : 'No' %>&nbsp;</td>
        <td><%= sort_order %>&nbsp;</td>
        <td>
            <div class="btn-group">
                <?php if(is_allowed('ADMIN_OPTIONS_UPDATE')): ?>
                <a class="btn record-edit" rel="tooltip" title="Edit" 
                    href="javascript:void(0);" data-toggle="modal">
                    <i class="icon-edit"></i>
                </a>
                <?php endif; ?>

                <?php if(is_allowed('ADMIN_OPTIONS_DELETE')): ?>
                <a class="btn record-delete" rel="tooltip" title="Remove" 
                    href="javascript:void(0);" data-toggle="modal">
                    <i class="icon-remove"></i>
                </a>   
                <?php endif; ?>             
            </div>
        </td>
    </script>

    <?php $this->load->view('admin_options/add_options')?>
    <?php $this->load->view('admin_options/edit_options')?>

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
