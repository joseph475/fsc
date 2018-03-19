<div class="accordion-group row-section">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#works-info">
        <div class="row-title">EMPLOYMENT RECORD</div> 
    </a>
    <div id="works-info" class="accordion-body collapse"> 
    	<div class="row-details" style="padding-top: 20px;">           
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="workpagination"></div> 

                <div class="clearfix" style="margin-bottom: 20px;"></div>
                
                <table class="responsive-table" id="options-table-works" style="font-size: 11px;">
                    <thead>
    					<tr>
    						<th width="12%"><center>Company</center></th>
    						<th width="20%"><center>Vessel</center></th>
    						<th width="5%"><center>Rank</center></th> 
    						<th width="5%"><center>GRT</center></th>  
    						<th width="10%"><center>Kind</center></th>
    						<th width="15%"><center>Engine</center></th>
    						<th width="10%"><center>Trade</center></th>                             
    						<th width="7%"><center>Embarked</center></th>
    						<th width="7%"><center>Disembarked</center></th>
    						<th width="9%"><center>Remarks</center></th>
    					</tr>
                    </thead>
                    <tbody></tbody>                            
                </table>
            </div>
        </div>
        
        <!-- backbonejs view template -->
        <script id="works-list-item" type="text/template">          
            <td><%= (company)? company : '' %></td> 
            <td>
                <% if(isdone == 0) { %>
                   <% if(vessel) { %>
                    <?php echo form_open('crew-list', 'class="form1D" '); ?>
                    
                    <input type="hidden" name="vessel_id" id="vessel_id" value="<%= (vessel_id)? vessel_id : '' %>">
                    <input type="hidden" name="month" id="month" value="<?php echo date('n'); ?>">
                    <input type="hidden" name="day" id="day" value="<?php echo date('j'); ?>">
                    <input type="hidden" name="year" id="year" value="<?php echo date('Y'); ?>">
                    <button type="submit" id="minifest"><%= vessel  %></button>
                    <small style="font-size: 9px;"><%= (ex_vessel)? '(' + ex_vessel + ')' : '' %></small>
                    <?php echo form_close(); ?>
                    <% } else { %>
                    No Record
                    <% } %>
                <% } else { %>
                <%= (vessel)? vessel : '' %> <br />
                <small style="font-size: 9px;"><%= (ex_vessel)? '(' + ex_vessel + ')' : '' %></small>
                <% } %>                
            </td>
            <td><center><%= (rank)? rank : '' %></center></td>
            <td><%= (grt)? grt : '' %></td>
            <td><%= (TYPE)? TYPE : '' %></td>
            <td><%= (ENGINE)? ENGINE : '' %></td>
            <td><%= (trade)? trade : '' %></td>
            <td><center><%= (embarked)? embarked : '' %></center></td>
            <td><center><%= (disembarked != '0000-00-00')? disembarked : '' %></center></td>
            <td><%= (remarks)? remarks : '' %></td>
        </script>

        <!-- backbonejs view template -->
        <?php $this->load->view('template/pagination');?>

        <!-- Script for autoloading on mobile device -->
        <script type="text/javascript">
            $(document).ready(function() {

                var worksItems = new WorksCollection();
                <?php if(isset($crew_id)): ?>
    	            worksItems.crew_id = <?php echo $crew_id; ?>;
    	        <?php endif; ?>
                var worksmasterView = new WorksMasterView({collection: worksItems});
                var workspagination = new WorksPaginatedView({collection: worksItems});           
            });
        </script>
    </div>
</div>

