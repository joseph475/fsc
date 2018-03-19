<div class="accordion-group row-section">
	
	<?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#comment-info"><?php endif; ?>
		<div class="row-title">SPECIAL COMMENT</div> 
	<?php if($crew_id): ?></a><?php endif; ?>

	<div id="comment-info" class="accordion-body collapse">
		<div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="commentpagination"></div> 
                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a id="comment_add-btn" class="btn" data-toggle="modal">
                    <i class="icon-plus"></i> Add
                </a> 
                <?php endif; ?>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alertComment-div"></div> 
                
                <table class="responsive-table" id="options-table-comment">
                    <thead>
                      <tr>
                        <th>Title</th>
	                    <th>Description</th>           
                        <th width="3%">Actions</th>
                      </tr>
                    </thead>
                    <tbody></tbody>                            
                </table>
            </div>
        </div>
    
    <!-- backbonejs view template -->
    <script id="comment-list-item" type="text/template">          
        <td><%= (title)? title : '' %>&nbsp;</td> 
        <td><%= (description)? description : '' %>&nbsp;</td>
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

    <script id="option-add-comment" type="text/template">
        <div class="inopts">
            <div class="control-group">
                <label class="control-label" for="inputtitle">Title:</label>
                <div class="controls">
                    <select name="title">
                        <?php 
                        if($comments ){
                            foreach ($comments as $value){ 
                                echo "<option value='{$value->option}' >{$value->option}</option>";
                            } 
                        }
                        ?>
                    </select>
                    <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo $crew_id; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputdescription">Description:</label>
                <div class="controls">
                    <textarea id="inputdescription" name="description">
                    </textarea>
                </div>
            </div>
        </div>
	</script>

	<script id="option-edit-comment" type="text/template">
        <div class="inopts">
    	    <div class="control-group">
                <label class="control-label" for="inputtitle">Title:</label>
                <div class="controls">
                    <select name="title">
                    <?php 
                    if($comments){
                        foreach ($comments as $value) {
                            echo "<option value='{$value->option}' ";
                        ?>
                        <%= (title == '<?php echo $value->option ?>')? 'selected="selected"' : '' %>
                        <?php
                            echo ">{$value->option}</option>";
                        } 
                    }
                    ?>
                    </select>
                    <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo $crew_id; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputdescription">Description:</label>
                <div class="controls">
                    <textarea id="inputdescription" name="description"><%= (description)? description : '' %></textarea>
                </div>
            </div>
        </div>
	</script>

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var paginatedcommentItems = new CommentCollection();
            <?php if($crew_id): ?>
	            paginatedcommentItems.crew_id = <?php echo $crew_id; ?>;
	        <?php endif; ?>
            var commentmasterView = new CommentMasterView({collection: paginatedcommentItems});
            var commentpagination = new CommentPaginatedView({collection: paginatedcommentItems});           
        });
    </script>

    <script type="text/template" id="alertCommentTemplate">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>

	<!-- Modal Add -->          
	<div class="modal hide fade" id="addComment">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Add Comment <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-comment-add"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-success" id="options-submit">Submit</a>
	    </div>
	</div>
	<!-- End Add -->

	<!-- Modal Edit -->          
	<div class="modal hide fade" id="editComment">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Edit Comment <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-comment-edit"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-primary" id="options-update">Submit Changes</a>
	    </div>
	</div>
	<!-- End Edit -->

     <!-- Modal Delete --> 
    <div class="modal hide fade" id="deleteComment">
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
