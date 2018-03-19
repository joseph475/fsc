<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

    td:nth-of-type(1):before { content: "Name:"; }
    td:nth-of-type(2):before { content: "Position:"; }
    td:nth-of-type(3):before { content: "Birthdate:"; }
    td:nth-of-type(4):before { content: "Vessel:"; }
    td:nth-of-type(5):before { content: "Status:"; }
    td:nth-of-type(6):before { content: "Date Hired:"; }
    td:nth-of-type(7):before { content: "Crew ID:"; }
    td:nth-of-type(8):before { content: "Payroll ID:"; }
    td:nth-of-type(9):before { content: "Profit ID:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Crew <small>&raquo; Master File</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <li>
                        <a href="#status_id-1" 
                            data-toggle="tab" dep="1"
                            rel="tooltip" title="1">
                            On Board
                        </a>
                    </li>
                </ul>              
                <div id="myTabContent" class="tab-content">                 
                    <div class="pull-right" id="pagination"></div>
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                        <select name="position_id" id="position_id" style="width: 150px;">
                            <?php 
                            if($positions){
                                foreach ($positions as $v_value){ 
                                    echo "<option value='{$v_value->id}' >{$v_value->position}</option>";
                                } 
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <span id="loader-container"></span>
                        <div class="clearfix"></div> 
                        
                    </form>   

                    <div id="alert-div"></div> 

                    <div class="tab-pane fade in " id="status_id-1">

                        <table class="responsive-table" id="options-table-1">
                            <thead>
                                <tr>
                                    <th class="sortcolumn" col="jd_crew.fullname" width="25%">Name</th>  
                                    <th class="sortcolumn" col="jd_position.position">Position</th>
                                    <th class="sortcolumn" col="jd_crew.birthdate">Birthdate</th>
                                    <th class="sortcolumn" col="jd_vessels.vessel_name">Vessel</th>
                                    <th>Status</th>
                                    <th>Date Hired</th>
                                    <th class="sortcolumn" col="jd_crew.crew_id" style="width: 3%;">Crew ID</th>
                                    <th class="sortcolumn" col="jd_crew.payroll_id" style="width: 3%;">Payroll ID</th>
                                    <th class="sortcolumn" col="jd_crew.profit_id" style="width: 3%;">Profit ID</th>
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
        <td>
            <a href="<?php echo site_url();?>resume/<%= hash %>" data-original-title="<%= (fullname)? fullname : ''  %>">
                <%= (fullname)? fullname : ''  %>
            </a>
        </td> 
        <td><%= (position)? position : '' %></td> 
        <td><%= (birthdate)? birthdate : '' %></td>  
        <td><%= (vessel_name)? vessel_name : '' %></td> 
        <td>On Board</td>
        <td><%= (date_hired)? date_hired : '' %>&nbsp;</td>
        <td><%= (crew_id)? crew_id : '' %>&nbsp;</td>
        <td><%= (payroll_id)? payroll_id : '' %>&nbsp;</td>
        <td><%= (profit_id)? profit_id : '' %>&nbsp;</td>
    </script> 

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var typeahead = new TypeAheadCollection();
            var paginatedItems = new PaginatedCollection();
            paginatedItems.date1 = "<?php echo date('Y-m-d'); ?>";
            <?php if($principal_id) { ?>
            paginatedItems.principal_id = <?php echo $principal_id; ?>;
            <?php } ?>
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

</div>
