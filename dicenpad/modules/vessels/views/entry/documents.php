<div class="accordion-group row-section">
	
	<?php if(isset($about)): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#document-info"><?php endif; ?>
		<div class="row-title">SHIP'S DOCUMENT <i>(Intended for Memo List Report)</i></div> 
	<?php if(isset($about)): ?></a><?php endif; ?>

	<div id="document-info" class="accordion-body collapse">
		<div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="Documentpagination"></div> 
                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a id="document_add-btn" class="btn" data-toggle="modal">
                    <i class="icon-plus"></i> Add
                </a> 
                <?php endif; ?>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alertdocument-div"></div> 
                
                <table class="responsive-table" id="options-table-document">
                    <thead>
                      <tr>
                        <th>Document</th>
	                    <th>Remarks</th>    
                        <th>Published</th>        
                        <th width="3%">Actions</th>
                      </tr>
                    </thead>
                    <tbody></tbody>                            
                </table>
            </div>
        </div>
    
    <!-- backbonejs view template -->
    <script id="document-list-item" type="text/template">          
        <td><%= (documents)? documents : '' %>&nbsp;</td> 
        <td><%= (remarks)? remarks : '' %>&nbsp;</td>
        <td><%= (published)? published : '' %>&nbsp;</td>
        <td><center>
            <div class="btn-group">
                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                <a class="record-edit" rel="tooltip" title="Edit" 
                    href="javascript:void(0);" data-toggle="modal">
                    <i class="icon-edit"></i>
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

    <script id="option-add-document" type="text/template">
        <div class="inopts">
            <div class="control-group">
                <label class="control-label" for="inputdocuments">Document:</label>
                <div class="controls">
                    <input id="inputdocuments" type="text" name="documents" value=""/>
                    <input id="inputvessel_id" type="hidden" name="vessel_id" value="<?php echo isset($id)? $id : ''; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputremarks">Remarks:</label>
                <div class="controls">
                    <textarea id="inputremarks" name="remarks"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputpublished">Published :</label>
                <div class="controls" style="padding-top: 5px;">
                    <input type="radio" value="1" name="published" checked="checked" id="published" /> Yes
                    <input type="radio" value="0" name="published" id="published" /> No
                </div>
            </div>
        </div>
	</script>

	<script id="option-edit-document" type="text/template">
        <div class="inopts">
    	    <div class="control-group">
                <label class="control-label" for="inputdocuments">Document:</label>
                <div class="controls">
                    <input id="inputdocuments" type="text" name="documents" value="<%= (documents)? documents : '' %>"/>
                    <input id="inputvessel_id" type="hidden" name="vessel_id" value="<?php echo isset($id)? $id : ''; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputremarks">Remarks:</label>
                <div class="controls">
                    <textarea id="inputremarks" name="remarks"><%= (remarks)? remarks : '' %></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputpublished">Published : </label>
                <div class="controls" style="padding-top: 5px;">
                    <input type="radio" value="1" name="published" <%= (published == 1)? "checked='checked'" : '' %>  id="published" /> Yes
                    <input type="radio" value="0" name="published" <%= (published == 0)? "checked='checked'" : '' %> id="published" /> No
                </div>
            </div>
        </div>
	</script>

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var paginateddocsItems = new DocumentCollection();
            <?php if(isset($id)): ?>
	            paginateddocsItems.vessel_id = <?php echo $id; ?>;
	        <?php endif; ?>
            var documentmasterView = new DocumentMasterView({collection: paginateddocsItems});
            var documentpagination = new DocumentPaginatedView({collection: paginateddocsItems});           
        });
    </script>

    <script type="text/template" id="alertDocumentTemplate">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>

	<!-- Modal Add -->          
	<div class="modal hide fade" id="addDocument">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Add Document <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-document-add"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-success" id="options-submit">Submit</a>
	    </div>
	</div>
	<!-- End Add -->

	<!-- Modal Edit -->          
	<div class="modal hide fade" id="editDocument">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Edit Document <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-document-edit"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-primary" id="options-update">Submit Changes</a>
	    </div>
	</div>
	<!-- End Edit -->

     <!-- Modal Delete --> 
    <div class="modal hide fade" id="deleteDocument">
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

	</div>
</div>

