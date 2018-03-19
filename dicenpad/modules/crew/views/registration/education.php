<div class="accordion-group row-section">
	
	<?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#education-info"><?php endif; ?>
		<div class="row-title">EDUCATIONAL ATTAINMENT</div> 
	<?php if($crew_id): ?></a><?php endif; ?>

	<div id="education-info" class="accordion-body collapse">
		<div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="pagination"></div> 
                <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                <a id="educ_add-btn" class="btn" data-toggle="modal">
                    <i class="icon-plus"></i> Add
                </a> 
                <?php endif; ?>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alert3-div"></div> 
                
                <table class="responsive-table" id="options-table-educs">
                    <thead>
                      <tr>
                        <th>Year (Start - End)</th>
	                    <th>School</th>                                
	                    <th>Course Finished</th>
                        <th>Special Course</th>
                        <th>Qualification</th>
                        <th width="3%">Actions</th>
                      </tr>
                    </thead>
                    <tbody></tbody>                            
                </table>
            </div>
        </div>
    
    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">          
        <td><%= (year)? year : '' %>&nbsp;</td> 
        <td><%= (school)? school : '' %>&nbsp;</td>
        <td><%= (course)? course : '' %>&nbsp;</td>
        <td><%= (vocational)? vocational : '' %>&nbsp;</td>
        <td><%= (qualification)? qualification : '' %>&nbsp;</td>
        <td>
            <center>
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

    <script id="option-add-template" type="text/template">
        <div class="control-group inopts">
            <label class="control-label" for="inputyear">Year:</label>
            <div class="controls">
                <input id="inputyear" type="text" name="year" value="" id="year" />
                <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo $crew_id; ?>" />
            </div>
        </div>
        <div class="control-group inopts">
            <label class="control-label" for="inputschool">School :</label>
            <div class="controls">
                <input id="inputschool" type="text" name="school" value=""  />
            </div>
        </div>
        <div class="control-group inopts">
            <label class="control-label" for="inputQualification">Qualification</label>
            <div class="controls">
                <select id="qualification" name="qualification" style="width: 170px;">
                    <option value="High School Diploma">High School Diploma</option>
                    <option value="Vocational Diploma/Short Course Certificate">Vocational Diploma/Short Course Certificate</option>
                    <option value="Bachelors/College Degree">Bachelors/College Degree</option>
                    <option value="Post Graduate Diploma/Masters Degree">Post Graduate Diploma/Masters Degree</option>
                    <option value="Professional License">Professional License(Passed Board/Bar/Professional License Exam)</option>
                    <option value="Doctorate Degree">Doctorate Degree</option>
                </select>
            </div>
        </div>
        <div class="control-group inopts">
            <label class="control-label" for="inputcourse">Course:</label>
            <div class="controls">
                <input id="inputcourse" type="text" name="course" value="" id="year" />
            </div>
        </div>
        <div class="control-group inopts">
            <label class="control-label" for="inputvocational">Vocational :</label>
            <div class="controls">
                <input id="inputvocational" type="text" name="vocational" value=""  />
            </div>
        </div>
        <div class="control-group inopts">
            <label class="control-label" for="inputHighest">Highest Attainment?</label>
            <div class="controls">
                <select id="highest" name="highest" style="width: 170px;">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>
	</script>

	<script id="option-edit-template" type="text/template">
	    <div class="control-group">
            <label class="control-label" for="inputyear">Year:</label>
            <div class="controls">
                <input id="inputyear" type="text" class="ab" name="year" value="<%= (year)? year : '' %>" id="year" />
                <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo $crew_id; ?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputschool">School :</label>
            <div class="controls">
                <input id="inputschool" class="ab" type="text" name="school" value="<%= (school)? school : '' %>"  />
            </div>
        </div>
        <div class="control-group inopts">
            <label class="control-label" for="inputQualification">Qualification</label>
            <div class="controls">
                <select id="qualification" class="ab" name="qualification" style="width: 170px;">
                    <option value="High School Diploma" <%= (qualification == "High School Diploma")? 'selected="selected"' : '' %>>High School Diploma</option>
                    <option value="Vocational Diploma/Short Course Certificate" <%= (qualification == "Vocational Diploma/Short Course Certificate")? 'selected="selected"' : '' %>>Vocational Diploma/Short Course Certificate</option>
                    <option value="Bachelors/College Degree" <%= (qualification == "Bachelors/College Degree")? 'selected="selected"' : '' %>>Bachelors/College Degree</option>
                    <option value="Post Graduate Diploma/Masters Degree" <%= (qualification == "Post Graduate Diploma/Masters Degree")? 'selected="selected"' : '' %>>Post Graduate Diploma/Masters Degree</option>
                    <option value="Professional License" <%= (qualification == "Professional License")? 'selected="selected"' : '' %>>Professional License(Passed Board/Bar/Professional License Exam)</option>
                    <option value="Doctorate Degree" <%= (qualification == "Doctorate Degree")? 'selected="selected"' : '' %>>Doctorate Degree</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputcourse">Course:</label>
            <div class="controls">
                <input id="inputcourse" class="ab" type="text" name="course" value="<%= (course)? course : '' %>" id="year" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputvocational">Vocational :</label>
            <div class="controls">
                <input id="inputvocational" class="ab" type="text" name="vocational" value="<%= (vocational)? vocational : '' %>"  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputHighest">Highest Attainment?</label>
            <div class="controls">
                <select id="highest" class="ab" name="highest" style="width: 170px;">
                    <option value="1" <%= (highest == 1)? 'selected="selected"' : '' %>>Yes</option>
                    <option value="0" <%= (highest == 0)? 'selected="selected"' : '' %>>No</option>
                </select>
            </div>
        </div>
	</script>

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var paginatedItems = new EducCollection();
            <?php if($crew_id): ?>
	            paginatedItems.crew_id = <?php echo $crew_id; ?>;
	        <?php endif; ?>
            var educmasterView = new EducMasterView({collection: paginatedItems});
            var pagination = new PaginatedView({collection: paginatedItems});           
        });
    </script>

    <script type="text/template" id="alert3Template">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>

	<!-- Modal Add -->          
	<div class="modal hide fade" id="addData">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Add Education <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-option-add"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-success" id="options-submit">Submit</a>
	    </div>
	</div>
	<!-- End Add -->

	<!-- Modal Edit -->          
	<div class="modal hide fade" id="editData">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Edit Education <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-option-edit"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-primary" id="options-update">Submit Changes</a>
	    </div>
	</div>
	<!-- End Edit -->

     <!-- Modal Delete --> 
    <div class="modal hide fade" id="deleteData">
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

