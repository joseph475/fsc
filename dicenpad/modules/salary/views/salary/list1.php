<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Position:"; }
  td:nth-of-type(2):before { content: "Code:"; }
  td:nth-of-type(3):before { content: "Basic Salary:"; }
  td:nth-of-type(4):before { content: "O.T (Fixed):"; }
  td:nth-of-type(5):before { content: "O.T (Hourly):"; }
  td:nth-of-type(6):before { content: "Leave Pay:"; }
  td:nth-of-type(7):before { content: "Nos. Slots:"; }
  td:nth-of-type(8):before { content: "Nos. Hours:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Salary <small>&raquo; Breakdown</small></h2>
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
                        <select name="vessel_id" id="vessel_id" >
                            <?php 
                            foreach ($vessels as $v_value){ 
                                echo "<option value='{$v_value->id}' >{$v_value->vessel_name}</option>";
                            } 
                            ?>
                        </select>

                        <select name="effective_year" id="effective_year" style="width: 90px;">
                            <?php 
                                for ($x = date('Y'); $x <= date('Y', strtotime('+4 years')); $x++) {
                                    echo "<option value='{$x}' >{$x}</option>";
                                }
                            ?>
                        </select>
                        <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                            <a class="btn record-add" rel="tooltip" title="Add" 
                            href="javascript:void(0);" data-toggle="modal">
                                <i class="icon-plus"></i>
                            </a> 
                        <?php endif; ?>
                        <span id="loader-container"></span>
                    </form>  
                    
                    <div id="alert-div"></div> 

                    <div class="tab-pane fade in" id="status_id-1">
                        <table class="responsive-table" id="options-table-1">
                            <thead>
                              <tr>
                                <th class="sortcolumn" col="sort_order">Position</th>
                                <th class="sortcolumn" col="code">Code</th>
                                <th>Basic Salary</th>                                
                                <th>O.T (Fixed)</th>
                                <th>O.T (Hourly)</th>
                                <th>Leave Pay</th>
                                <th>Nos. Slots</th>
                                <th>Nos. Hours</th>
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
    
    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">    
        <% 
        if (position == 'No Record') {
        %>
        <td colspan="8"><%= position %></td>
        <%
        } else { 
        %>      
        <td>
          <a data-content="
            <div class='row page-border'></div>
            <p><b>T. Allowance: </b> <%= (t_allowance)? t_allowance : '0' %></p>
            <p><b>S. Allowance: </b> <%= (s_allowance)? s_allowance : '0' %></p>
            <p><b>RTMT Fee: </b> <%= (rtmt_fee)? rtmt_fee : '0' %></p>
            <p><b>Other Benefits: </b> <%= (other_benefits)? other_benefits : '0' %></p>
            " 
            href="javascript:void(0);"
            rel="clickover" data-original-title="<%= position %>">
            <%= position  %>
          </a>
        </td>
        <td><%= (code)? code : '0.00' %>&nbsp;</td> 
        <td><%= (basic_salary)? basic_salary : '0.00' %>&nbsp;</td> 
        <td><%= (ot_fixed)? ot_fixed : '0.00' %>&nbsp;</td> 
        <td><%= (ot_hourly)? ot_hourly : '0.00' %>&nbsp;</td> 
        <td><%= (leave_pay)? leave_pay : '' %>&nbsp;</td> 
        <td><%= (nos_slot)? nos_slot : '0' %>&nbsp;</td> 
        <td><%= (nos_hours)? nos_hours : '0' %>&nbsp;</td> 
        <td>
            <div class="btn-group">
                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                <a class="btn record-edit" rel="tooltip" title="Edit" 
                    href="javascript:void(0);" data-toggle="modal">
                    <i class="icon-edit"></i>
                </a>
                <?php endif; ?>

                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                <a class="btn record-delete" rel="tooltip" title="Remove" 
                    href="javascript:void(0);" data-toggle="modal">
                    <i class="icon-remove"></i>
                </a>   
                <?php endif; ?>              
            </div>
        </td>
        <% } %>
    </script>

   <?php $this->load->view('salary/add_salary')?>
   <?php $this->load->view('salary/edit_salary')?>

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

    <script type="text/javascript">
        function numberWithCommas(x) {
            var parts = x.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return parseFloat(parts.join("."), 10).toFixed(2);
        }
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