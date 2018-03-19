<div class="accordion-group row-section">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#bank-info">
        <div class="row-title">BANK LOAN</div> 
    </a>
    <div id="bank-info" class="accordion-body collapse"> 
    	<div class="row-details" style="padding-top: 20px;">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="bankpagination"></div> 

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <table class="responsive-table" id="options-table-bank">
                    <thead>
                      <tr>
                        <th>Type</th>
                        <th>Amount</th>                                
                        <th>Remarks</th>
                        <th>Date Issued</th>
                      </tr>
                    </thead>
                    <tbody></tbody>                            
                </table>
            </div>
        </div>
        
        <!-- backbonejs view template -->
        <script id="bank-list-item" type="text/template">          
            <td><%= (type)? type + ' ' + type_nos : '' %></td> 
            <td><%= (amount)? amount : '' %>&nbsp;</td>
            <td><%= (remarks)? remarks : '' %>&nbsp;</td>
            <td><%= (date_issued)? date_issued : '' %>&nbsp;</td>
        </script>
        
        <!-- backbonejs view template -->
        <?php $this->load->view('template/pagination');?>

        <!-- Script for autoloading on mobile device -->
        <script type="text/javascript">
            $(document).ready(function() {

                var paginatedbankItems = new BankCollection();
                <?php if(isset($crew_id)): ?>
                    paginatedbankItems.crew_id = <?php echo $crew_id; ?>;
                <?php endif; ?>
                var bankmasterView = new BankMasterView({collection: paginatedbankItems});
                var bankpagination = new BankPaginatedView({collection: paginatedbankItems});           
            });
        </script>
    </div>
</div>

