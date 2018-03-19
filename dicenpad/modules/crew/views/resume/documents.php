<div class="accordion-group row-section">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#documents-info">
        <div class="row-title">DOCUMENTS</div> 
    </a>
    <div id="documents-info" class="accordion-body collapse">
    	<div class="row-details" style="padding-top: 20px;">                            
            <div class="pull-right" id="docspagination"></div> 

            <div class="clearfix" style="margin-bottom: 20px;"></div>

            <table class="responsive-table" id="options-table-docs">
                <thead>
                	<tr>
    					<th width="31%"><center>Document</center></th>
                        <th width="10%"><center>Number</center></th>                                
                        <th width="10%"><center>Date Issued</center></th>
                        <th width="10%"><center>Date Expired</center></th>
                        <th width="13%"><center>Panama Endorsement</center></th>                     
                        <th width="13%"><center>Remarks / Regulation</center></th>
                        <th width="13%"><center>Capacity</center></th>
    		        </tr>
                </thead>
                <tbody></tbody>                            
            </table>
        </div>
        
        <!-- backbonejs view template -->
        <script id="docs-list-item" type="text/template">          
            <td>
                <% if (file_docs) { %><a rel='tooltip' title='View Documents' target='_blank'
                    href='<?php echo site_url();?>uploads/files/<%= file_docs %>'>
					
                <% } %>
                    <%= (document)? document : '' %>
                <% if (file_docs) { %>  <i class="icon-search"></i> </a> <% } %>
                <br/>
                <small style="font-size: 9px;">
                    <em>
                        <strong>Encoding: </strong> <%= (encoding_modified)? encoding_modified : ' Not Updated ' %> - 
                        <strong>Uploading: </strong> <%= (uploading_modified)? uploading_modified : ' Not Updated ' %>
                    <em>
                </small>
            </td> 
            <td><center><%= (docs_nos)? docs_nos : '' %></center></td>
            <td><center><%= (date_issued != '1970-01-01')? date_issued : '' %></center></td>
            <td><center><%= (date_expired != '1970-01-01')? date_expired : '' %></center></td>
            <td><%= (endorsement)? endorsement : '' %></td>
            <td><%= (remarks)? remarks : '' %></td>
            <td><%= (capacity)? capacity : '' %></td>
        </script>
        
        <!-- backbonejs view template -->
        <?php $this->load->view('template/pagination');?>

        <!-- Script for autoloading on mobile device -->
        <script type="text/javascript">
            $(document).ready(function() {

                var docsItems = new DocsCollection();
                <?php if(isset($crew_id)): ?>
    	            docsItems.crew_id = <?php echo $crew_id; ?>;
    	        <?php endif; ?>
                var docsmasterView = new DocsMasterView({collection: docsItems});
                var docspagination = new DocsPaginatedView({collection: docsItems});           
            });
        </script>
    </div>
</div>

