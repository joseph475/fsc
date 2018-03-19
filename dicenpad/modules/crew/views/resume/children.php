<div class="accordion-group row-section">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#children-info">
        <div class="row-title">CHILDREN</div> 
    </a>
    <div id="children-info" class="accordion-body collapse"> 
    	<div class="row-details" style="padding-top: 20px;">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="childpagination"></div> 

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <table class="responsive-table" id="options-table-child">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Birthdate</th>                                
                        <th>Address</th>
                        <th>Relationship</th>
                        <th>Contact Nos.</th>
                      </tr>
                    </thead>
                    <tbody></tbody>                            
                </table>
            </div>
        </div>
        
        <!-- backbonejs view template -->
        <script id="child-list-item" type="text/template">          
            <td><%= (child_name)? child_name : '' %></td> 
            <td><%= (child_birthdate)? child_birthdate : '' %></td>
            <td><%= (child_address)? child_address : '' %></td>
            <td><%= (relationship)? relationship : '' %></td>
            <td><%= (child_telephone)? child_telephone : '' %></td>
        </script>
        
        <!-- backbonejs view template -->
        <?php $this->load->view('template/pagination');?>

        <!-- Script for autoloading on mobile device -->
        <script type="text/javascript">
            $(document).ready(function() {

                var paginatedchildItems = new ChildCollection();
                <?php if(isset($crew_id)): ?>
                    paginatedchildItems.crew_id = <?php echo $crew_id; ?>;
                <?php endif; ?>
                var childmasterView = new ChildMasterView({collection: paginatedchildItems});
                var childpagination = new ChildPaginatedView({collection: paginatedchildItems});           
            });
        </script>
    </div>
</div>

