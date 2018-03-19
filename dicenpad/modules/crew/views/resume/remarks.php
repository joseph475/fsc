<div class="accordion-group row-section">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#remarks-info">
        <div class="row-title">MANAGER REMARKS</div> 
    </a>
    <div id="remarks-info" class="accordion-body collapse"> 
    	<div class="row-details" style="padding-top: 20px;">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="remarkspagination"></div> 

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <table class="responsive-table" id="options-table-remarks">
                    <thead>
                      <tr>
                        <th>Comment</th>
                        <th>Comment By</th>                                
                        <th>Date Commented</th>
                      </tr>
                    </thead>
                    <tbody></tbody>                            
                </table>
            </div>
        </div>
        
        <!-- backbonejs view template -->
        <script id="remarks-list-item" type="text/template">          
            <td><%= (remarks)? remarks : '' %>&nbsp;</td> 
            <td><%= (remarks_by)? remarks_by : '' %>&nbsp;</td>
            <td><%= (remarks_date)? remarks_date : '' %>&nbsp;</td>
        </script>
        
        <!-- backbonejs view template -->
        <?php $this->load->view('template/pagination');?>

        <!-- Script for autoloading on mobile device -->
        <script type="text/javascript">
            $(document).ready(function() {

                var paginatedremarksItems = new RemarksCollection();
                <?php if(isset($crew_id)): ?>
                    paginatedremarksItems.crew_id = <?php echo $crew_id; ?>;
                <?php endif; ?>
                var remarksmasterView = new RemarksMasterView({collection: paginatedremarksItems});
                var remarkspagination = new RemarksPaginatedView({collection: paginatedremarksItems});           
            });
        </script>
    </div>
</div>

