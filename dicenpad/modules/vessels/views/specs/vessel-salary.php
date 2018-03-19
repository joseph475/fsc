<div id="education-info">
	<div class="row-title">VESSEL SALARY SCALE</div> 
	<div class="row-details" style="padding-top: 20px;">            
        <div id="myTabContent" class="tab-content">                    
            <div class="pull-right" id="pagination"></div> 

            <div class="clearfix" style="margin-bottom: 20px;"></div>

            <table class="responsive-table" id="options-table-salary">
                <thead>
                    <tr>
                        <th width="1%"><center>Nos</center></th>
                        <th class="sortcolumn" col="sort_order">Position</th>
                        <th class="sortcolumn" col="code"><center>Code</center></th>   
                        <th width="11%"><center>Basic Salary</center></th>                             
                        <th width="9%"><center>O.T (Fixed)</center></th>
                        <th width="9%"><center>O.T (Hourly)</center></th>
                        <th><center>Leave Pay</center></th>
                        <th width="8%"><center>Nos. Slots</center></th>
                        <th width="9%"><center>Nos. Hours</center></th>
                    </tr>
                </thead>
                <tbody></tbody>                            
            </table>
        </div>
    </div>
    
    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">  
        <td><center><%= (counter)? counter : '0.00' %></center></td>         
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
        <td><center><%= (code)? code : '0.00' %></center></td> 
        <td><center><%= (basic_salary)? basic_salary : '0.00' %></center></td> 
        <td><center><%= (ot_fixed)? ot_fixed : '0.00' %></center></td> 
        <td><center><%= (ot_hourly)? ot_hourly : '0.00' %></center></td> 
        <td><center><%= (leave_pay)? leave_pay : '' %></center></td> 
        <td><center><%= (nos_slot)? nos_slot : '0' %></center></td> 
        <td><center><%= (nos_hours)? nos_hours : '0' %></center></td> 
    </script>
    
    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var paginatedItems = new SalaryCollection();
            <?php if(isset($id)): ?>
	            paginatedItems.vessel_id = <?php echo $id; ?>;
	        <?php endif; ?>
            var salarymasterView = new SalaryMasterView({collection: paginatedItems});
            var pagination = new PaginatedView({collection: paginatedItems});           
        });
    </script>

</div>

