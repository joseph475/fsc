<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Document:"; }
  td:nth-of-type(2):before { content: "Sort Order:"; }
  td:nth-of-type(3):before { content: "Sub Order:"; }
  td:nth-of-type(4):before { content: "Officers Deck:"; }
  td:nth-of-type(5):before { content: "Officers Engr:"; }
  td:nth-of-type(6):before { content: "Officers Stwd:"; }
  td:nth-of-type(7):before { content: "Ratings Deck:"; }
  td:nth-of-type(8):before { content: "Ratings Engr:"; }
  td:nth-of-type(9):before { content: "Ratings Stwd:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Crew Checklist <small>&raquo; Master File</small></h2>
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
                        <div class="btn-group pull-left">
                            <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" placeholder="Crew ID" />
                        </div>
                        <div class="btn-group pull-left">
                            <button type="submit" class="btn" id="submit-search">Search</button>
                        </div>
                        <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                            <div class="btn-group pull-left" style="margin-right: 5px;">
                                <a id="edit-profile-btn" href="#" class="btn"> Export Checklist </a>
                                <a href="#" data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a class="report-print1" rel="tooltip" title="Export"  href="<?php echo site_url("checklist/grid-type"); ?>" target="_blank">
                                            <i class="icon-pdf"></i> Grid Type
                                        </a> 
                                    </li>
                                    <li><a class="report-print2" rel="tooltip" title="Export"  href="<?php echo site_url("checklist/list-type"); ?>" target="_blank">
                                            <i class="icon-pdf"></i> List Type
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
                        <table class="responsive-table" id="crew_details" style="border: 1px solid #ccc;">
                            <tbody>
                                <tr>
                                    <td width="10%"><h5>Fullname</h5></td>
                                    <td width="25%" id="fullname"></td>
                                    <td width="10%"><h5>Vessel</h5></td>
                                    <td width="20%" id="vessel"></td>
                                    <td width="10%"><h5>Position</h5></td>
                                    <td width="15%" id="position"></td>
                                    <td width="5%"><h5>Crew ID</h5></td>
                                    <td width="10%" id="crew_id"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="responsive-table" id="options-table-1">
                            <thead>
                                <tr>
                                    <th style="width: 30%;" class="sortcolumn" col="document">Document</th>
                                    <th style="width: 8%;"><center>Officers Deck</center></th> 
                                    <th style="width: 7%;"><center>Officers Engr</center></th>  
                                    <th style="width: 8%;"><center>Officers Stwd</center></th>
                                    <th style="width: 7%;"><center>Ratings Deck</center></th> 
                                    <th style="width: 7%;"><center>Ratings Engr</center></th>  
                                    <th style="width: 7%;"><center>Ratings Stwd</center></th> 
                                    <th style="width: 7%;"><center>Date Issued</center></th> 
                                    <th style="width: 7%;"><center>Date Expiry</center></th> 
                                    <th style="width: 7%;"><center>Document No.</center></th> 
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
        <td><%= (document)? document : ''  %></td>
        <td><center><%= (officer_deck)? officer_deck : '' %></center></td>   
        <td><center><%= (officer_engr)? officer_engr : '' %></center></td>  
        <td><center><%= (officer_stwd)? officer_stwd : '' %></center></td>   
        <td><center><%= (rating_deck)? rating_deck : '' %></center></td>  
        <td><center><%= (rating_engr)? rating_stwd : '' %></center></td>   
        <td><center><%= (rating_stwd)? rating_stwd : '' %></center></td> 
        <td><center><%= (date_issued)? date_issued : '' %></center></td>
        <td><center><%= (date_expired)? date_expired : '' %></center></td>
        <td><center><%= (docs_nos)? docs_nos : '' %></center></td>   
    </script>

    <?php $this->load->view('crew_checklist/set_signatory')?>

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

    <script type="text/template" id="alertTemplate">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>
