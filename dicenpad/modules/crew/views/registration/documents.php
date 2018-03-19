<div class="accordion-group row-section">
		
	<?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#documents-info"><?php endif; ?>
		<div class="row-title">DOCUMENTS</div> 
	<?php if($crew_id): ?></a><?php endif; ?>

	<div id="documents-info" class="accordion-body collapse">
		<div class="row-details"> 
            
            <div id="alert2-div"></div>

            <div class="pull-right" id="docspagination"></div>
            <form class="form-search" autocomplete="off">
                <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off"/>
                
                <button type="submit" class="btn" id="submit-search">Search</button>
                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                <a id="doc_generate-btn" class="btn btn-success" >Update Documents</a>
                <?php endif; ?>

                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a id="doc_save-btn" class="btn btn-primary" >Save</a>
                <?php endif; ?>
            </form> 

            <div class="clearfix" style="margin-bottom: 20px;"></div>

            <table class="responsive-table" id="options-table-docs">
                <thead>
                    <tr>
                        <th width="31%"><center>Document</center></th>
                        <th width="12%"><center>Number</center></th>                                
                        <th width="10%"><center>Date Issued</center></th>
                        <th width="10%"><center>Date Expired</center></th>   
                        <th width="11%"><center>Panama Endorsement</center></th>                     
                        <th width="11%"><center>Remarks / Regulation</center></th>
                        <th width="11%"><center>Capacity</center></th>
                        <th width="1%">Include in Memo list</th>
                        <th width="3%"><center>Actions</center></th>
                    </tr>
                </thead>
                <tbody></tbody>                            
            </table>
        </div>

         <!--               -->

        <!-- backbonejs view template -->
        <script id="docs-list-item" type="text/template">   
            <td>
                <% if (file_docs) { %><a rel='tooltip' title='View Documents' target='_blank'
                    href='<?php echo site_url();?>uploads/files/<%= file_docs %>'>
                <% } %>
                    <%= (document)? document : '' %>
                <% if (file_docs) { %> <i class="icon-search"></i> </a> <% } %>
                <br/>
                <small style="font-size: 9px;">
                    <em>
                        <strong>Encoding: </strong> <%= (encoding_modified)? encoding_modified : ' Not Updated ' %> - 
                        <strong>Uploading: </strong> <%= (uploading_modified)? uploading_modified : ' Not Updated ' %>
                    <em>
                </small>
            </td> 
            <td class="tdpadd2px"><center><input type="text" name="docs_nos" id="inputdocs_nos" value="<%= (docs_nos)? docs_nos : '' %>"/></center></td> 
            <td class="tdpadd2px"><center><input type="text" name="date_issued" class="ddate" placeholder="mm/dd/yyy" value="<%= (date_issued)? date_issued : '' %>"/></center></td> 
            <td class="tdpadd2px"><center><input type="text" name="date_expired" class="ddate" placeholder="mm/dd/yyy" value="<%= (date_expired)? date_expired : '' %>"/></center></td> 
            <td class="tdpadd2px"><center><input type="text" name="endorsement" id="inputendorsement" value="<%= (endorsement)? endorsement : '' %>"/></center></td>
            <td class="tdpadd2px"><center><input type="text" name="remarks" id="inputremarks" value="<%= (remarks)? remarks : '' %>"/></center></td>
            <td class="tdpadd2px"><center><input type="text" name="capacity" id="inputcapacity" value="<%= (capacity)? capacity : '' %>"/></center></td>
            <td><center><input type="checkbox" value="0" <% (published == 1)?  "checked='checked'" : '' %> name="published"   id="published" /></center></td>
            <td><center>
                <div class="btn-group">
                    <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                    <a class="record-upload" rel="tooltip" title="Upload" 
                        href="javascript:void(0)" data-toggle="modal">
                        <i class="icon-upload"></i>
                    </a>
                    <?php endif; ?>

                    <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                    <a class="record-delete" rel="tooltip" title="Remove" 
                        href="javascript:void(0);" data-toggle="modal">
                        <i class="icon-remove"></i>
                    </a>     
                    <?php endif; ?>        
                </div>
                </center>
            </td>
        </script>
        
        <!-- backbonejs view template -->
        <?php $this->load->view('template/pagination');?>

        <!-- Script for autoloading on mobile device -->
        <script type="text/javascript">
            $(document).ready(function() {

                var typeahead = new TypeAheadCollection();
                var docsItems = new DocsCollection();
                <?php if($crew_id): ?>
                    docsItems.crew_id = <?php echo $crew_id; ?>;
                    docsItems.hashid = "<?php echo $hash; ?>";
                    docsItems.totalRec = <?php echo count($docs); ?>;
                <?php endif; ?>
                var docsmasterView = new DocsMasterView({collection: docsItems});
                var docspagination = new DocsPaginatedView({collection: docsItems}); 
                
            });
        </script>

        <script type="text/template" id="alert2Template">
            <div class="alert alert-<%= type %>">
                <button class="close" data-dismiss="alert" type="button">×</button>
                <%= message %>
            </div>
        </script>

        <!-- Modal Add -->          
        <div class="modal hide fade" id="generateData">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Documents <small>&raquo; Data in Progress.... </small> <span id="loader-container"></span></h3>
            </div>
        </div>
        <!-- End Add -->

         <!-- Modal Delete --> 
        <div class="modal hide fade" id="deleteDocs">
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

       <div class="modal hide fade" id="uploadData">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Upload <small>&raquo; document</small></h3>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="upload_file" class="form-horizontal">
                    <p style="padding-bottom:20px">
                        <small>The file needs to be at least 2MB size and must be in PDF and DOC format only .</small>
                    </p>
                    <div class="row">   
                        <div class="span2" style="vertical-align:top">
                            <span class="btn fileinput-button">
                                <i class="icon-plus icon-black"></i>
                                <span>Select file...</span>
                                <input type="file" name="userfile" id="userfile">
                            </span>
                            <span id="filename"></span>
                        </div>                     
                        <div class="span2">
                            <div id="file-message"></div>
                        </div>
                    </div>                    
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
                <a href="#" class="btn btn-success">Submit</a>
            </div>
        </div> 
	</div>
</div>
