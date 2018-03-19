<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Onboard Date:"; }
  td:nth-of-type(2):before { content: "Previous Position:"; }
  td:nth-of-type(3):before { content: "Class:"; }
  td:nth-of-type(4):before { content: "New Position:"; }
  td:nth-of-type(5):before { content: "Promotion Date:"; }
  td:nth-of-type(6):before { content: "Actions:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Promotion History<small>&raquo; Setup</small></h2>
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
                        <div class="addbutton-section">
                            <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                            <input type="text" id="month" name="month" class="monthPicker" style="width: 120px;" placeholder="Search Month" />
                            <button type="submit" class="btn" id="submit-search">Search</button>
                            
                            <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                                <a class="btn report-print" rel="tooltip" title="Export" target="_blank"
                                    href="<?php echo site_url("report/promotion-list") ; ?>" >
                                    <i class="icon-pdf"></i>
                                </a> 
                            <?php endif; ?>
                            <span id="loader-container"></span>
                        </div>
                    </form>   

                    <div class="tab-pane fade in" id="status_id-1">
                        <table class="responsive-table" id="options-table-1">
                            <thead>
                              <tr>
                                <th class="sortcolumn" col="jd_crew.lastname">Fullname</th>
                                <th>Previous Position</th>  
                                <th>Promoted To</th>  
                                <th>Vessel</th>        
                                <th class="sortcolumn" col="promotion_date">Promotion Date</th>
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
          <a data-content="
            <center>
                <image src='<%= (photo)? "<?php echo $path; ?>" + photo : "<?php echo $url; ?>"   %>' width='106' style='margin-bottom: 15px;' />
            </center>
            <div class='row page-border'> </div>
            <center>            
                <a class='btn' rel='tooltip' title='View Profile' 
                    href='<?php echo site_url();?>resume/<%= hash %>'>
                    View Profile
                </a>
            </center>
            " 
            href="javascript:void(0);"
            rel="clickover" data-original-title="<%= (fullname)? fullname : ''  %>">
            <%= (fullname)? fullname : ''  %>
          </a>
        </td>
        <td><%= (prev_position)? prev_position : '' %>&nbsp;</td>
        <td><%= (new_position)? new_position : '' %>&nbsp;</td>
        <td><%= (vessel_name)? vessel_name : '' %>&nbsp;</td>
        <td><%= (promotion_date)? promotion_date : '' %>&nbsp;</td>
        <td>
            <div class="btn-group">
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