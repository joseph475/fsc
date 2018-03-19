<div class="accordion-group row-section">
	
	<?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#children-info"><?php endif; ?>
		<div class="row-title">CHILDREN</div> 
	<?php if($crew_id): ?></a><?php endif; ?>

	<div id="children-info" class="accordion-body collapse">
		<div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="childpagination"></div> 
                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a id="child_add-btn" class="btn" data-toggle="modal">
                    <i class="icon-plus"></i> Add
                </a> 
                <?php endif; ?>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alert5-div"></div> 
                
                <table class="responsive-table" id="options-table-child">
                    <thead>
                      <tr>
                        <th>Name</th>
	                    <th>Birthdate</th>                                
	                    <th>Address</th>
                        <th>Relationship</th>
                        <th>Contact Nos.</th>
                        <th width="3%">Actions</th>
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

    <script id="option-add-child" type="text/template">
        <div class="inopts">
            <div class="control-group">
                <label class="control-label" for="inputchild_name">Name:</label>
                <div class="controls">
                    <input id="inputchild_name" type="text" name="child_name" value="" id="child_name" />
                    <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo $crew_id; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputchild_birthdate">Birthdate :</label>
                <div class="controls">
                    <input id="inputchild_birthdate" class="jrdate" type="text" name="child_birthdate" value=""  />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputchild_address">Address:</label>
                <div class="controls">
                    <input id="inputchild_address" type="text" name="child_address" value="" id="child_address" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputrelationship">Relationship</label>
                <div class="controls">
                    <select name="relationship">
                        <option value="Son">Son</option>
                        <option value="Daughter">Daughter</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="child_telephone">Contact Nos.:</label>
                <div class="controls">
                    <input id="child_telephone" type="text" name="child_telephone" value="" id="child_telephone" />
                </div>
            </div>
        </div>
	</script>

	<script id="option-edit-child" type="text/template">
        <div class="inopts">
    	    <div class="control-group">
                <label class="control-label" for="inputchild_name">Name:</label>
                <div class="controls">
                    <input id="inputchild_name" type="text"name="child_name" value="<%= (child_name)? child_name : '' %>" id="child_name" />
                    <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo isset($crew_id)? $crew_id : ''; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputchild_birthdate">Birthdate :</label>
                <div class="controls">
                    <input id="inputchild_birthdate" class="jrdate" type="text" name="child_birthdate" value="<%= (child_birthdate)? child_birthdate : '' %>"  />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputchild_address">Address:</label>
                <div class="controls">
                    <input id="inputchild_address" type="text" name="child_address" value="<%= (child_address)? child_address : '' %>" id="child_address" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputrelationship">Relationship</label>
                <div class="controls">
                    <select name="relationship">
                        <option value="Son" <%= (relationship == "Son")? "selected='selected'" : '' %>>Son</option>
                        <option value="Daughter" <%= (relationship == "Daughter")? "selected='selected'" : '' %>>Daughter</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="child_telephone">Contact Nos.:</label>
                <div class="controls">
                    <input id="child_telephone" type="text" name="child_telephone" value="<%= (child_telephone)? child_telephone : '' %>" id="child_telephone" />
                </div>
            </div>
        </div>
	</script>

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var paginatedchildItems = new ChildCollection();
            <?php if($crew_id): ?>
	            paginatedchildItems.crew_id = <?php echo $crew_id; ?>;
	        <?php endif; ?>
            var childmasterView = new ChildMasterView({collection: paginatedchildItems});
            var childpagination = new ChildPaginatedView({collection: paginatedchildItems});           
        });
    </script>

    <script type="text/template" id="alert5Template">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>

	<!-- Modal Add -->          
	<div class="modal hide fade" id="addChild">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Add Children <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-child-add"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-success" id="options-submit">Submit</a>
	    </div>
	</div>
	<!-- End Add -->

	<!-- Modal Edit -->          
	<div class="modal hide fade" id="editChild">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Edit Children <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-child-edit"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-primary" id="options-update">Submit Changes</a>
	    </div>
	</div>
	<!-- End Edit -->

     <!-- Modal Delete --> 
    <div class="modal hide fade" id="deleteChild">
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

