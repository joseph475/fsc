<div id="education-info">
	<div class="row-title">PRINCIPAL VESSELS</div> 
	<div class="row-details" style="padding-top: 20px;">            
        <div id="myTabContent" class="tab-content">                    
            <div class="pull-right" id="pagination"></div> 

            <div class="clearfix" style="margin-bottom: 20px;"></div>

            <table class="responsive-table" id="options-table-vessel">
                <thead>
                  <tr>
                    <th class="sortcolumn" col="vessel_name">Name</th>
                    <th class="sortcolumn" col="principal">Principal</th>                                
                    <th>Builder</th>
                    <th>Built in</th>
                    <th>Engine</th>
                    <th class="sortcolumn"  col="e_year">Year</th>
                  </tr>
                </thead>
                <tbody></tbody>                            
            </table>
        </div>
    </div>
    
    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">  
        <td>
            <a href="<?php echo site_url();?>vessel-specification/<%= id %>" data-original-title="<%= (vessel_name)? vessel_name : ''  %>">
                <%= (vessel_name)? vessel_name : '' %>
            </a>
        </td>
        <td><%= (principal)? principal : '' %>&nbsp;</td>
        <td><%= (builder)? builder : '' %>&nbsp;</td>        
        <td><%= (builtin)? builtin : '' %>&nbsp;</td>
        <td><%= (engine)? engine : '' %>&nbsp;</td>
        <td><%= (e_year)? e_year : '' %>&nbsp;</td>
    </script>
    
    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var paginatedItems = new VesselCollection();
            <?php if(isset($id)): ?>
	            paginatedItems.principal_id = <?php echo $id; ?>;
	        <?php endif; ?>
            var vesselmasterView = new VesselMasterView({collection: paginatedItems});
            var pagination = new PaginatedView({collection: paginatedItems});           
        });
    </script>

</div>

