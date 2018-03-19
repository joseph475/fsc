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
                <h2>Embarkation List <small>&raquo; Master File</small></h2>
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
                        <div class="btn-group pull-left">
                            <?php if($vessels): ?>
                            <select id="vessel_id" name="vessel_id">
                                <option value="0">&nbsp;</option>
                                <?php 
                                foreach ($vessels as $value) {
                                    echo "<option value='{$value->id}'>{$value->vessel_name}</option>";
                                }
                                ?>
                            </select>
                            <?php endif; ?>
                            <select id="option" name="option" style="width: 80px;">
                                <optgroup label="Filter By">
                                    <option value="0">Date</option>
                                    <option value="1">Month</option>
                                </optgroup>
                            </select>
                            <span class='bydate'>
                                <input type="text" class="ddate" placeholder="0000-00-00" id="date1" name="start_date" value="" style="width: 120px;" />
                                <input type="text" class="ddate" placeholder="0000-00-00" id="date2" name="end_date" value="" style="width: 120px;" />
                            </span>
                            <span>
                                <input type="text" id="month" name="month" class="monthPicker" style="width: 120px;" />
                            </span>
                        </div>
                        <div class="btn-group pull-left">
                            <button type="submit" class="btn" id="submit-search">Search</button>
                        </div>

                        <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                        <div class="btn-group pull-left" style="margin-right: 5px;">
                            <a id="edit-profile-btn" href="#" class="btn"> Export </a>
                            <a href="#" data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="report-print" rel="tooltip" title="Export"  href="<?php echo site_url("report/embarkation-list"); ?>" target="_blank">
                                        <i class="icon-pdf"></i> PDF
                                    </a> 
                                </li>
                            </ul>            
                        </div>   
                        <?php endif; ?>
                      
                        <span id="loader-container"></span>
                        <div class="clearfix"></div> 
                    </form>  

                    <div id="alert-div"></div>

                    <div class="tab-pane fade in" id="status_id-1">
                        <table class="responsive-table" id="options-table-1">
                            <thead>
                              <tr>
                                <th class="sortcolumn" col="last_name">Name</th>
                                <th class="sortcolumn" col="code">Rank</th>  
                                <th class="sortcolumn" col="department">Department</th>                               
                                <th>Vessel Name</th>                             
                                <th>Seaman's No.</th>
                                <th class="sortcolumn" col="embarked">Onboard Date</th>
                                <th>Duration</th>
                                <th>Manager's Remarks</th>
                                <th>Crew ID</th>
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
          <a href="<?php echo site_url();?>resume/<%= hash %>"
            data-original-title="<%= (fullname)? fullname : ''  %>">
            <%= (fullname)? fullname : ''  %>
          </a>
        </td> 
        <td><%= (code)? code : '' %></td>
        <td><%= (department)? department : '' %></td>
        <td><%= (vessel_name)? vessel_name : 'No Record' %></td>
        <td><%= (seaman_nos)? seaman_nos : 0 %></td>
        <td><%= (embarked)? embarked : '-' %></td>
        <td><%= (duration)? duration : 0 %></td>
        <td><%= (manager_comment)? manager_comment : '' %>&nbsp;</td>
        <td><%= (crew_id)? crew_id : 0 %></td>
    </script>


    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var typeahead = new TypeAheadCollection();
            var paginatedItems = new PaginatedCollection();

            paginatedItems.date1 = "<?php echo date('Y-m-01') ?>";
            paginatedItems.date2 = "<?php echo date('Y-m-t') ?>";

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