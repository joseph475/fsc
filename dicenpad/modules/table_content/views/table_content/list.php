<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Name:"; }
  td:nth-of-type(2):before { content: "Position:"; }
  td:nth-of-type(3):before { content: "Department:"; }
  td:nth-of-type(4):before { content: "Gender:"; }
  td:nth-of-type(5):before { content: "Status:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Table of Contents <small>&raquo; Department Crew Document</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <?php foreach ($options_record as $index => $options_value):?>
                        <?php if ($index < 5):?>
                            <li>
                                <a href="#status_id-<?php echo strtolower($options_value->id)?>" 
                                    data-toggle="tab" dep="<?php echo strtolower($options_value->id)?>"
                                    rel="tooltip" title="<?php echo strtolower($options_value->option); ?>">
                                    <?php echo (strlen($options_value->option) > 20) ? substr($options_value->option,0,20) . '&hellip;' : ucwords(strtoupper($options_value->option));?>
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
                                <a href="#status_id-<?php echo strtolower($options_value->id)?>" 
                                    data-toggle="tab" dep="<?php echo strtolower($options_value->id)?>"
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
                        <select name="vessel_id" id="vessel_id" >
                           <?php 
                            foreach ($vessels as $value){ 
                                echo "<option value='{$value->id}' >{$value->vessel_name}</option>";
                            } 
                            ?>
                        </select>
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <span id="loader-container"></span>
                    </form>   

                    <div id="alert-div"></div> 

                    <?php foreach ($options_record as $options_value):?>
                    <div class="tab-pane fade in" id="status_id-<?php echo strtolower($options_value->id);?>">
                        <table class="responsive-table" id="options-table-<?php echo strtolower($options_value->id);?>">
                            <thead>
                                <tr>
                                    <th class="sortcolumn" col="name">Name</th>
                                    <th class="sortcolumn" col="position_id">Position</th>                                
                                    <th class="sortcolumn" col="department_id">Department</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <?php if(is_allowed('VIEW')): ?><th>Export</th><?php endif; ?>
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

    <?php 
        $ci =& get_instance();
        $ci->load->config('dir');
        $upload_path = $ci->config->item('upload_dir');

        $path = $upload_path . 'media/thumbnails/';
        $url = base_url() . BASE_IMG . 'user-photo.jpg';
    ?>
    
    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">       
        <td>
          <a href="<?php echo site_url();?>resume/<%= hash %>"
            data-original-title="<%= (fullname)? fullname : ''  %>">
            <%= (fullname)? fullname : ''  %>
          </a>
        </td>
        <td><%= (position)? position : '' %>&nbsp;</td>
        <td><%= (department)? department : '' %>&nbsp;</td>
        <td><%= (gender)? gender : '' %>&nbsp;</td>
        <td><%= (status)? status : '' %>&nbsp;</td>
        <?php if(is_allowed('VIEW')): ?>
        <td>
            <div class="btn-group">
                <a class="record-print" rel="tooltip" title="Export" target="_blank"
                    href="<?php echo site_url('table-content-document'); ?>/<%= (crew_id)? crew_id : '0' %>/<%= (department_id)? department_id : '0' %>">
                    <i class="icon-pdf"></i>
                </a>            
            </div>
        </td>
        <td><%= (crew_id)? crew_id : '' %>&nbsp;</td>
        <?php endif; ?>
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