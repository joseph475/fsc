<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Name:"; }
  td:nth-of-type(2):before { content: "Rank:"; }
  td:nth-of-type(3):before { content: "Vessel:"; }
  td:nth-of-type(4):before { content: "Date Onboard:"; }
  td:nth-of-type(5):before { content: "Document:"; }
  td:nth-of-type(6):before { content: "Doc Nos.:"; }
  td:nth-of-type(7):before { content: "Expiry Date:"; }
  td:nth-of-type(8):before { content: "Remarks:"; }
}
</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Expired <small>&raquo; Documents</small></h2>
                <p>For onboard crew only</p>
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
                            <option value="0">&nbsp;</option>
                            <?php 
                            if($vessels){
                                foreach ($vessels as $value){ 
                                    echo "<option value='{$value->id}' >{$value->vessel_name}</option>";
                                }                                 
                            }
                            ?>
                        </select>
                        <select name="document_id" id="document_id" >
                            <option value="0">&nbsp;</option>
                            <?php 
                            if($documents){
                                foreach ($documents as $v_value){ 
                                    echo "<option value='{$v_value->id}' >{$v_value->document}</option>";
                                } 
                            }
                            ?>
                        </select>
                        <input type="text" class="ddate" placeholder="yyyy-mm-dd" id="from" name="start_date" value="<?php echo date('Y-m-d'); ?>" style="width: 120px;" />
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        
                        <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                            <a class="btn report-print" rel="tooltip" title="Export" target="_blank"
                                href="<?php echo site_url("expired-docs-report") ; ?>" >
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
                                <th class="sortcolumn" col="lastname">Name</th>
                                <th class="sortcolumn" col="jd_crew.position_id">Rank</th>
                                <th class="sortcolumn" col="jd_onboard.vessel_id">Vessel</th> 
                                <th>Date on Board</th>
                                <th>Document</th>                             
                                <th>Doc Nos.</th>
                                <th class="sortcolumn" col="jd_crew_docs.date_expired">Expiry Date</th>
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
        <td><a href="<?php echo site_url();?>resume/<%= hash %>"
            data-original-title="<%= (fullname)? fullname : ''  %>">
            <%= (fullname)? fullname : ''  %>
            </a>
        </td>
        <td><%= (code)? code : '' %>&nbsp;</td> 
        <td><%= (vessel_name)? vessel_name : '' %>&nbsp;</td> 
        <td><%= (start_date)? start_date : '' %>&nbsp;</td> 
        <td>
                <% if (file_docs) { %><a rel='tooltip' title='View Documents' target='_blank'
                    href='<?php echo site_url();?>uploads/files/<%= file_docs %>'>
                <% } %>
                    <%= (document)? document : '' %>
                <% if (file_docs == '') { %> </a> <% } %>
            </td>
        <td><%= (docs_nos)? docs_nos : '' %>&nbsp;</td> 
        <td><%= (date_expired)? date_expired : '' %>&nbsp;</td> 
        <td><%= (remarks)? remarks : '' %>&nbsp;</td> 
    </script>

    <?php $this->load->view('expired_doc/set_signatory')?>

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
