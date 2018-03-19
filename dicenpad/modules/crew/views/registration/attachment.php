<div class="accordion-group row-section">
	
	<?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#attachment-info"><?php endif; ?>
		<div class="row-title">ATTACHMENT FILES</div> 
	<?php if($crew_id): ?></a><?php endif; ?>

	<div id="attachment-info" class="accordion-body collapse">
		<div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="Attachmentpagination"></div> 
                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a id="attachment_add-btn" class="btn" data-toggle="modal">
                    <i class="icon-plus"></i> Add
                </a> 
                <?php endif; ?>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alert6-div"></div> 
                
                <table class="responsive-table" id="options-table-attachment">
                    <thead>
                      <tr>
                        <th>Title</th>
	                    <th>Description</th>                                
	                    <th>Files</th>
                        <th width="3%">Actions</th>
                      </tr>
                    </thead>
                    <tbody></tbody>                            
                </table>
            </div>
        </div>
    
    <!-- backbonejs view template -->
    <script id="attachment-list-item" type="text/template">          
        <td><%= (file_title)? file_title : '' %>&nbsp;</td> 
        <td><%= (file_desc)? file_desc : '' %>&nbsp;</td>
        <td>
            <% if (file_docs != ''){ %>
                <a rel='tooltip' title='View Documents' target='_blank' href='<?php echo site_url();?>uploads/files/<%= file_docs %>'> Download </a>
            <% } else { %>
                No Files
            <% } %>
        </td>
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

    <script id="option-add-attachment" type="text/template">
        <div class="inopts">
            <div class="control-group">
                <label class="control-label" for="file_title">Title:</label>
                <div class="controls">
                    <input id="file_title" type="text" name="file_title" value=""/>
                    <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo isset($crew_id)? $crew_id : ''; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="file_desc">Description:</label>
                <div class="controls">
                    <textarea id="file_desc" name="file_desc" ></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="attachfile">File</label>
                <div class="controls" style="vertical-align:top">                    
                    <span class="btn fileinput-button">
                        <i class="icon-plus icon-black"></i>
                        <span>Select file...</span>
                        <input type="file" name="userfile" id="attachfile">
                    </span>  
                </div>
            </div>
        </div>
	</script>

	<script id="option-edit-attachment" type="text/template">
        <div class="inopt">
    	    <div class="control-group">
                <label class="control-label" for="file_title">Title:</label>
                <div class="controls">
                    <input id="file_title" type="text" name="file_title" value="<%= file_title %>"/>
                    <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo isset($crew_id)? $crew_id : ''; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="file_desc">Description:</label>
                <div class="controls">
                    <textarea id="file_desc" name="file_desc" ><%= file_desc %></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="attachfile">File :</label>
                <div class="controls">
                    <span class="btn fileinput-button">
                        <i class="icon-plus icon-black"></i>
                        <span>Change file...</span>
                        <input type="file" name="userfile" id="attachfile">
                    </span>
                </div>
            </div>
        </div>
	</script>

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var attachItems = new AttachmentCollection();
            <?php if($crew_id): ?>
	            attachItems.crew_id = <?php echo $crew_id; ?>;
	        <?php endif; ?>
            var attachmasterView = new AttachmentMasterView({collection: attachItems});
            var attachpagination = new AttachmentPaginatedView({collection: attachItems});           
        });
    </script>

    <script type="text/template" id="alert6Template">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>

	<!-- Modal Add -->          
	<div class="modal hide fade" id="addAttachment">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Add Attachment <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form method="post" action="" id="upload_file" class="form-horizontal">
	            <div id="container-attachment-add"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-success" id="options-submit">Submit</a>
	    </div>
	</div>
	<!-- End Add -->

	<!-- Modal Edit -->          
	<div class="modal hide fade" id="editAttachment">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Edit Attachment <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form method="post" action="" id="upload_file" class="form-horizontal">
	            <div id="container-attachment-edit"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-primary" id="options-update">Submit Changes</a>
	    </div>
	</div>
	<!-- End Edit -->

     <!-- Modal Delete --> 
    <div class="modal hide fade" id="deleteAttachment">
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

