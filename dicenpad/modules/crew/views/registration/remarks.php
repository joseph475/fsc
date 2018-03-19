<div class="accordion-group row-section">
	
	<?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#remarks-info"><?php endif; ?>
		<div class="row-title">MANAGER REMARKS</div> 
	<?php if($crew_id): ?></a><?php endif; ?>

	<div id="remarks-info" class="accordion-body collapse">
		<div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="remarkspagination"></div> 
                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a id="remarks_add-btn" class="btn" data-toggle="modal">
                    <i class="icon-plus"></i> Add
                </a> 
                <?php endif; ?>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alert5r-div"></div> 
                
                <table class="responsive-table" id="options-table-remarks">
                    <thead>
                      <tr>
                        <th>Comment</th>
	                    <th>Comment By</th>                                
	                    <th>Date Commented</th>
                        <th width="3%">Actions</th>
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

    <script id="option-add-remarks" type="text/template">
        <div class="inopts">
            <div class="control-group">
                <label class="control-label" for="remarks">Comments:</label>
                <div class="controls">
                    <textarea name="remarks" id="remarks"></textarea>
                    <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo $crew_id; ?>" />
                    <input type="hidden" name="remarks_by" value="<?php echo $first_name . ' ' . $last_name;?>" />
                </div>
            </div>
        </div>
	</script>

	<script id="option-edit-remarks" type="text/template">
        <div class="inopts">
    	    <div class="control-group">
                <label class="control-label" for="remarks">Comments:</label>
                <div class="controls">
                    <textarea name="remarks" id="remarks"><%= (remarks)? remarks : '' %></textarea>
                    <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo $crew_id; ?>" />
                    <input type="hidden" name="remarks_by" value="<?php echo $first_name . ' ' . $last_name;?>" />
                </div>
            </div>
        </div>
	</script>

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var paginatedremarksItems = new RemarksCollection();
            <?php if($crew_id): ?>
	            paginatedremarksItems.crew_id = <?php echo $crew_id; ?>;
	        <?php endif; ?>
            var remarksmasterView = new RemarksMasterView({collection: paginatedremarksItems});
            var remarkspagination = new RemarksPaginatedView({collection: paginatedremarksItems});           
        });
    </script>

    <script type="text/template" id="alert5rTemplate">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>

	<!-- Modal Add -->          
	<div class="modal hide fade" id="addremarks">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Add Managers Remarks <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-remarks-add"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-success" id="options-submit">Submit</a>
	    </div>
	</div>
	<!-- End Add -->

	<!-- Modal Edit -->          
	<div class="modal hide fade" id="editremarks">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Edit Managers Remarks <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-remarks-edit"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-primary" id="options-update">Submit Changes</a>
	    </div>
	</div>
	<!-- End Edit -->

     <!-- Modal Delete --> 
    <div class="modal hide fade" id="deleteremarks">
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

