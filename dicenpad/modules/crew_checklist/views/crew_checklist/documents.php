<div class="row-section">
    <div class="row-title">DOCUMENTS CHECKLIST</div> 
    <div id="documents-info">
        <div class="row-details" style="padding-top: 20px;">                            
            <div class="pull-right" id="docspagination"></div> 

            <form class="form-search" autocomplete="off">
                <div class="btn-group pull-left">
                    <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" placeholder="Search" />
                </div>
                <div class="btn-group pull-left">
                    <button type="submit" class="btn" id="submit-search">Search</button>
                </div>
                
                <div class="clearfix"></div>
            </form> 

            <div class="clearfix" style="margin-bottom: 20px;"></div>

            <table class="responsive-table" id="options-table-docs">
                <thead>
                    <tr>
                        <th width="31%" colspan="2" rowspan="2"><center>Document</center></th>
                        <th width="10%" colspan="2"><center>Officers</center></th>                                
                        <th width="10%" colspan="3"><center>Ratings</center></th>
                        <th width="10%" rowspan="2"><center>Issue Date</center></th>
                        <th width="10%" rowspan="2"><center>Expiry Date</center></th>
                        <th width="13%" rowspan="2"><center>Certificate No.</center></th>    
                        <th width="13%" rowspan="2"><center>Panama Endo. &amp; others</center></th>
                    </tr>
                    <tr>
                        <th>Deck</th>
                        <th>Eng</th>
                        <th>Deck</th>
                        <th>Eng</th>
                        <th>Stwd</th>
                    </tr>
                </thead>
                <tbody></tbody>                            
            </table>
        </div>
        
        <!-- backbonejs view template -->
        <script id="docs-list-item" type="text/template">     
            <td><%= (sort_order)? sort_order : ''  %></td>     
            <td>
                <%= (sub_order)? sub_order + '. ' : ''  %>
                <% if (file_docs) { %><a rel='tooltip' title='View Documents' target='_blank'
                    href='<?php echo site_url();?>uploads/files/<%= file_docs %>'>
                <% } %>
                    <%= (document)? document : '' %>
                <% if (file_docs == '') { %> </a> <% } %>
            </td> 
            <td><center><%= (officer_deck)? officer_deck : '' %></center></td>   
            <td><center><%= (officer_engr)? officer_engr : '' %></center></td>    
            <td><center><%= (rating_deck)? rating_deck : '' %></center></td>  
            <td><center><%= (rating_engr)? rating_stwd : '' %></center></td>   
            <td><center><%= (rating_stwd)? rating_stwd : '' %></center></td> 
            <td><center><%= (date_issued != '1970-01-01')? date_issued : '' %></center></td>
            <td><center><%= (date_expired)? date_expired : '' %></center></td>
            <td><center><%= (docs_nos)? docs_nos : '' %></center></td>   
            <td><center><%= (endorsement)? endorsement : '' %></center></td>   
        </script>

        <?php $this->load->view('crew_checklist/set_signatory')?>

        <!-- backbonejs view template -->
        <?php $this->load->view('template/pagination');?>

        <!-- Script for autoloading on mobile device -->
        <script type="text/javascript">
            $(document).ready(function() {

                var typeahead = new TypeAheadCollection();
                var docsItems = new DocsCollection();
                <?php if(isset($crew_id)): ?>
                    docsItems.crew_id = <?php echo $crew_id; ?>;
                    docsItems.vessel_id = <?php echo $vessel_id; ?>;
                    docsItems.date1 = '<?php echo $date; ?>';
                    docsItems.type_id =  <?php echo $type_id; ?>;
                <?php endif; ?>
                docsItems.user_id = <?php echo isset($user_id)? $user_id : ''; ?>; 
                var docsmasterView = new DocsMasterView({collection: docsItems});
                var docspagination = new DocsPaginatedView({collection: docsItems});           
            });
        </script>
    </div>
</div>

