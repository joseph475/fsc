<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

    td:nth-of-type(1):before { content: "No:"; }
    td:nth-of-type(2):before { content: "Rank:"; }
    td:nth-of-type(3):before { content: "Name:"; }
    td:nth-of-type(4):before { content: "Onboard Date:"; }
    td:nth-of-type(5):before { content: "Sea Expiry:"; }
    td:nth-of-type(6):before { content: "Seaman's Book Nos./Expiry:"; }
    td:nth-of-type(7):before { content: "Seaman's Book Expiry:"; }
    td:nth-of-type(8):before { content: "Passport Nos.:"; }
    td:nth-of-type(9):before { content: "Passport Expiry:"; }  
    td:nth-of-type(10):before { content: "Philipines License/Booklet Nos.:"; }
    td:nth-of-type(11):before { content: "Philipines License/Booklet Expiry:"; }
    td:nth-of-type(12):before { content: "GMDSS Nos.:"; }
    td:nth-of-type(13):before { content: "GMDSS Expiry:"; }
    td:nth-of-type(14):before { content: "PRC/TESDA G.O.G Nos.:"; }
    td:nth-of-type(15):before { content: "PRC/TESDA G.O.G Expiry:"; }
    td:nth-of-type(16):before { content: "U.S Visa Expiry:"; }
    td:nth-of-type(17):before { content: "Yellow Fever Expiry:"; }
    td:nth-of-type(18):before { content: "Medical Result:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Various <small>&raquo; List <i style="font-size: 12px;">(as of <?php echo date('F d, Y'); ?>)</i></small></h2>
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
                    <div class="pull-right" style="margin-right: 5px;">
                        <a class="btn record-set" rel="tooltip" title="Additional Column" 
                            href="javascript:void(0);" data-toggle="modal">
                            <i class="icon-cog"></i>
                        </a> 
                    </div>
                    <form class="form-search" autocomplete="off">
                        <select name="vessel_id" id="vessel_id" >
                            <option value="0">&nbsp;</option>
                            <?php 
                            if($vessels){
                                foreach ($vessels as $v_value){ 
                                    echo "<option value='{$v_value->id}' >{$v_value->vessel_name}</option>";
                                } 
                            }
                            ?>
                        </select>
                         <!-- <input id="asofdate" class="monthPicker" placeholder="mm/dd/yyyy" type="text" name="asofdate" value="<?php // date('m/d/Y') ?>"  />
                        <input type="text" id="month" name="month" class="monthPicker" value="<?php //echo date('m/d/Y'); ?>" style="width: 120px;" />
                        <button type="submit" class="btn" id="submit-search">Search</button> -->
                        <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                        <a class="btn report-print" rel="tooltip" title="Export" target="_blank"
                            href="<?php echo site_url("various-list-report-pdf"); ?>" >
                            <i class="icon-pdf"></i>
                        </a> 
                        <?php endif; ?>
                        <span id="loader-container"></span>
                        <div class="clearfix"></div> 
                        
                    </form>   

                    <div id="alert-div"></div> 

                    <div class="tab-pane fade in " id="status_id-1">
                        <div class="row-details">
                            <table class="responsive-table" id="vessel_details">
                                <tbody>
                                    <tr>
                                        <td width="10%"><h5>Vessel Name</h5></td>
                                        <td width="25%" id="vessel"></td>
                                        <td width="10%"><h5>Flag</h5></td>
                                        <td width="15%" id="flag"></td>
                                        <td width="10%"><h5>Type</h5></td>
                                        <td width="10%" id="type"></td>
                                        <td width="10%"><h5>Year Built</h5></td>
                                        <td width="10%" id="e_year"></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Principal</h5></td>
                                        <td id="principal"></td>
                                        <td><h5>GRT</h5></td>
                                        <td id="gross"></td>
                                        <td><h5>HP</h5></td>
                                        <td id="hps"></td>
                                        <td><h5>IMO Nos</h5></td>
                                        <td id="imo"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <table class="responsive-table" id="options-table-1" style="font-size: 10px;">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th class="sortcolumn" col="name" width="25%">Name</th>   
                                    <th><center>On-Board Date</center></th>
                                    <th><center>Sea Expiry</center></th>
                                    <th><center>Seaman's Book Nos./<br/>Book Expiry</center></th>

                                    <th><center>Passport Nos./<br/>Expiry</center></th>
                                    <th width="8%"><center id="flag_lic_nos">License Booklet Nos./<br/>Expiry</center></th>
                                    <th id="f2" width="8%"><center id="flag_gmdss_nos">GMDSS Nos./<br/>Expiry</center></th>
                                    <th><center>PRC/TESDA C.O.C Nos./<br/>Expiry</center></th>
                                    <th><center>U.S Visa Expiry</center></th>
                                    <th><center>Yellow Fever Expiry/Issued</center></th>
                                    <th><center>Medical Result Issuance</center></th>
                                    <th><center>Maritime Crew Visa</center></th>
                                    <th id="f4" width="8%"><center id="column1">Other <br/> Document 1</center></th>
                                    <th id="f5" width="8%"><center id="column2">Other <br/> Document 2</center></th>
                                    <th id="f6" width="8%"><center id="column3">Other <br/> Document 3</center></th>
                                </tr>
                            </thead>
                            <tbody></tbody>  
                            <tfoot>
                                <tr>
                                    <th colspan="15" style="text-align: right" id="test">
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
        <td><%= (code)? code : '' %></td>         
        <td>
            <a href="<?php echo site_url();?>resume/<%= hash %>" data-original-title="<%= (fullname)? fullname : ''  %>">
                <%= (fullname)? fullname : ''  %>
            </a>
        </td> 
        <td><center><%= (onboard_date)? onboard_date : '-' %></td> 
        <td><center><%= (sea_expiry)? sea_expiry : '-' %></td>    
        <td><center><%= (seaman_nos)? seaman_nos : '-' %><br/><%= (seaman_expiry)? seaman_expiry : '-' %></center></td>
        <td><center><%= (passport_nos)? passport_nos : '-' %><br/>
        <%= (passport_expiry)? passport_expiry : '-' %></center></td>\

        <% if (booklet_license != '-' && booklet_license_expiry != '-') { %> -->
        <td><center><%= (booklet_license)? booklet_license : '-' %><br/><%= (booklet_license_expiry)? booklet_license_expiry : '-' %></center></td>
        <% }  %> 
         <% if (gmdss_nos != '-' && gmdss_expiry != '-') { %> -->
        <td><center><%= (gmdss_nos)? gmdss_nos : '-' %><br/>
        <%= (gmdss_expiry)? gmdss_expiry : '-' %></center> </td>
         <% }  %> 


          <% if (booklet_license == '-' && booklet_license_expiry == '-') { %> -->
        <td><center><%= (booklet_license)? booklet_license : '-' %><br/><%= (booklet_license_expiry)? booklet_license_expiry : '-' %></center></td>
        <% }  %> 
         <% if (gmdss_nos == '-' && gmdss_expiry == '-') { %> -->
        <td><center><%= (gmdss_nos)? gmdss_nos : '-' %><br/>
        <%= (gmdss_expiry)? gmdss_expiry : '-' %></center> </td>
         <% }  %> 


        <td><center><%= (coc_nos)? coc_nos : '-' %><br/><%= (coc_expiry)? coc_expiry : '' %></center></td>
        <td><center><%= (us_expiry)? us_expiry : '-' %></center></td>
        <td><center><%= (yellow_issued)? yellow_issued : '-' %><br><%= (yellow_expiry)? yellow_expiry : 'Lifetime' %></center></td>
        <td><center><%= (medical_issued)? medical_issued : '-' %></center></td>
        <td><center><%= (mvc_nos)? mvc_nos : '' %><br/><%= (mcv_expiry)? mcv_expiry : '-' %></center></td>
        <td><center><%= (column1_nos)? column1_nos : '-' %></center></td>
        <td><center><%= (column2_nos)? column2_nos : '-' %></center></td>
        <td><center><%= (column3_nos)? column3_nos : '-' %></center></td>
    </script> 

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var typeahead = new TypeAheadCollection();
            var paginatedItems = new PaginatedCollection();
            paginatedItems.date1 = "<?php echo date('Y-m-d'); ?>";
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

    <!-- Modal Add -->          
    <div class="modal hide fade" id="setDocs">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Additional Document <small>&raquo; Setup</small></h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div id="container-option-add">
                    <div class="inopts">
                    <div class="control-group">
                        <label class="control-label" for="inputOption">Document 1 :</label>
                        <div class="controls">
                            <select name="docs_id" id="docs_id"  >
                                <option value="0">&nbsp;</option>
                                <?php 
                                    if($documents){
                                        foreach ($documents as $v_value){ 
                                           echo "<option value='{$v_value->id}' " . (($v_value->id == $column1)? 'selected="selected"' : '') . ">{$v_value->document}</option>";
                                        } 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputOptioncode">Document 2 :</label>
                        <div class="controls">
                            <select name="docs_id" id="docs_id"  >
                                <option value="0">&nbsp;</option>
                                <?php 
                                    if($documents){
                                        foreach ($documents as $v_value){ 
                                           echo "<option value='{$v_value->id}' " . (($v_value->id == $column2)? 'selected="selected"' : '') . ">{$v_value->document}</option>";
                                        } 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputInactive">Document 3 :</label>
                        <div class="controls" style="padding-top: 5px;">
                            <select name="docs_id" id="docs_id">
                                <option value="0">&nbsp;</option>
                            <?php 
                                if($documents){
                                    foreach ($documents as $v_value){ 
                                       echo "<option value='{$v_value->id}' " . (($v_value->id == $column3)? 'selected="selected"' : '') . ">{$v_value->document}</option>";
                                    } 
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                    
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <a href="#" class="btn btn-success" data-dismiss="modal" id="options-submit">Submit</a>
        </div>
    </div>
    <!-- End Add -->
</div>
