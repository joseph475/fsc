<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Name:"; }
  td:nth-of-type(2):before { content: "Position:"; }
  td:nth-of-type(3):before { content: "Gender:"; }
  td:nth-of-type(4):before { content: "SRC No.:"; }
  td:nth-of-type(5):before { content: "SIRB No.:"; }
  td:nth-of-type(6):before { content: "Salary:"; }
  td:nth-of-type(7):before { content: "Duration:"; }
  td:nth-of-type(8):before { content: "Remarks:"; }
  td:nth-of-type(9):before { content: "Export:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>POEA AND RPS<small>&raquo; Report Module</small></h2>
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
                    <div class="pull-right" style="margin-right: 3px;">
                        <a class="btn record-set" rel="tooltip" title="Set" 
                        href="javascript:void(0);" data-toggle="modal">
                            <i class="icon-plus"></i>Signatory
                        </a>
                    </div>
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

                    <div class="tab-pane fade in" id="status_id-1">
                        <table class="responsive-table" id="options-table-1">
                            <thead>
                                <tr>
                                    <th class="sortcolumn" col="name">Name</th>
                                    <th class="sortcolumn" col="position_id">Position</th>  
                                    <th class="sortcolumn" col="gender">Gender</th>                              
                                    <th>SRC No.</th>
                                    <th>SIRB No.</th>
                                    <th>Salary</th>
                                    <th>Duration</th>
                                    <th style="font-size: 11px; width: 15%;">ENGAGED SEAFARER/S/RE-ENGAGED/CADET/PRV</th>
                                    <th>Export</th>
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
              <a data-content="
                <div class='row page-border'> </div>
                " 
                href="javascript:void(0);"
                rel="clickover" data-original-title="<%= (fullname)? fullname : '' %>">
                <%= (fullname)? fullname : '' %>
              </a>
        </td>
        <td><%= (position)? position : '' %>&nbsp;</td>
        <td><%= (gender)? gender : '' %>&nbsp;</td>
        <td><%= (src_nos)? src_nos : '' %>&nbsp;</td>
        <td><%= (seaman_nos)? seaman_nos : '' %>&nbsp;</td>
        <td><%= (basic_salary)? basic_salary : '' %>&nbsp;</td>
        <td><%= (duration)? duration : '' %>&nbsp;</td>
        <td><%= (remarks)? remarks : '' %>&nbsp;</td>
        <td>
            <div class="btn-group">
                <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                <a class="report-print2" rel="tooltip" title="Seafarer's Employment Contract" target="_blank"
                    href="<?php echo site_url('report/seafarer-employment-contract'); ?>/<%= (onboard_id)? onboard_id : '0' %>" >
                    <i class="icon-pdf"></i>
                </a> 
                <a class="report-print" rel="tooltip" title="POEA Contract" target="_blank"
                    href="<?php echo site_url('poea-contract'); ?>/<%= (onboard_id)? onboard_id : '0' %>" >
                    <i class="icon-pdf"></i>
                </a>
                <a class="report-print2" rel="tooltip" title="POEA Information Sheet" target="_blank"
                    href="<?php echo site_url('poea-info-sheet'); ?>/<%= (onboard_id)? onboard_id : '0' %>" >
                    <i class="icon-pdf"></i>
                </a>
                <a class="report-print" rel="tooltip" title="RPS Regular" target="_blank"
                    href="<?php echo site_url('rps-regular'); ?>/<%= (onboard_id)? onboard_id : '0' %>" >
                    <i class="icon-pdf"></i>
                </a>
                <a class="report-print2" rel="tooltip" title="RPS Verification" target="_blank"
                    href="<?php echo site_url('rps-verification'); ?>/<%= (onboard_id)? onboard_id : '0' %>" >
                    <i class="icon-pdf"></i>
                </a>  
                <a class="report-print2" rel="tooltip" title="Crew Certification" target="_blank"
                    href="<?php echo site_url('crew-certification'); ?>/<%= (onboard_id)? onboard_id : '0' %>" >
                    <i class="icon-pdf"></i>
                </a> 
                <?php endif; ?>   
            </div>
        </td>
    </script> 

    <?php $this->load->view('contract/set_signatory')?>

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var typeahead = new TypeAheadCollection();
            var paginatedItems = new PaginatedCollection();
            paginatedItems.user_id = <?php echo isset($user_id)? $user_id : ''; ?>;            
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