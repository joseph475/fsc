<div class="accordion-group row-section">
	
	<?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#bank-info"><?php endif; ?>
		<div class="row-title">BANK LOAN</div> 
	<?php if($crew_id): ?></a><?php endif; ?>

	<div id="bank-info" class="accordion-body collapse">
		<div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="bankpagination"></div> 
                <?php if(is_allowed(getclass('BANK_LOAN', FALSE, 2))): ?>
                <a id="bank_add-btn" class="btn" data-toggle="modal">
                    <i class="icon-plus"></i> Add
                </a> 
                <?php endif; ?>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alertBanks-div"></div> 
                
                <table class="responsive-table" id="options-table-bank">
                    <thead>
                      <tr>
                        <th>Type</th>
	                    <th>Amount</th>                                
	                    <th>Remarks</th>
                        <th>Date Issued</th>
                        <th width="3%">Actions</th>
                      </tr>
                    </thead>
                    <tbody></tbody>                            
                </table>
            </div>
        </div>
    
    <!-- backbonejs view template -->
    <script id="bank-list-item" type="text/template">          
        <td><%= (type)? type + ' ' + type_nos : '' %></td> 
        <td><%= (amount)? amount : '' %>&nbsp;</td>
        <td><%= (remarks)? remarks : '' %>&nbsp;</td>
        <td><%= (date_issued)? date_issued : '' %>&nbsp;</td>
        <td><center>
            <div class="btn-group">
                <?php if(is_allowed(getclass('BANK_LOAN', FALSE, 3))): ?>
                <a class="record-edit" rel="tooltip" title="Edit" 
                    href="javascript:void(0);" data-toggle="modal">
                    <i class="icon-edit"></i>
                </a>
                <?php endif; ?>

                <?php if(is_allowed(getclass('BANK_LOAN', FALSE, 4))): ?>
                <a class="record-delete" rel="tooltip" title="Remove" 
                    href="javascript:void(0);" data-toggle="modal">
                    <i class="icon-remove"></i>
                </a>  
                <?php endif; ?>           
            </div>
            </center>
        </td>
    </script>

    <script id="option-add-bank" type="text/template">
        <div class="inbanks">
            <div class="control-group">
                <label class="control-label" for="amount">Amount :</label>
                <div class="controls">
                    <input id="amount" type="text" name="amount" value=""  />
                    <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo $crew_id; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="type">Type :</label>
                <div class="controls">
                    <select id="type" name="type" style="width: 170px;">
                        <option value="AUB">AUB</option>
                        <option value="CA">CA</option>
                    </select>
                    <input id="prefix" type="text" name="type_nos" value="" placeholder="Nos" style="width: 10%;" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="remarks">Remarks :</label>
                <div class="controls">
                    <textarea name="remarks" id="remarks"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="date_issued">Date Issued :</label>
                <div class="controls">
                    <input id="date_issued" class="ddate" type="text" name="date_issued" value=""  />
                </div>
            </div>
        </div>
	</script>

	<script id="option-edit-bank" type="text/template">
        <div class="inbanks">
            <div class="inopt">
                <div class="control-group">
                    <label class="control-label" for="amount">Amount :</label>
                    <div class="controls">
                        <input id="amount" type="text" name="amount" value="<%= (amount)? amount : '' %>"  />
                    <input id="inputcrew_id" type="hidden" name="crew_id" value="<?php echo $crew_id; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="type">Type :</label>
                    <div class="controls">
                        <select id="type" name="type" style="width: 170px;">
                            <option value="AUB" <%= (type == 'AUB')? "selected='selected'" : '' %>>AUB</option>
                            <option value="CA" <%= (type == 'CA')? "selected='selected'" : '' %>>CA</option>
                        </select>
                        <input id="type_nos" type="text" name="type_nos" value="<%= (type_nos)? type_nos : '' %>" placeholder="Nos" style="width: 10%;" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="remarks">Remarks :</label>
                    <div class="controls">
                        <textarea name="remarks" id="remarks"><%= (remarks)? remarks : '' %></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="date_issued">Date Issued :</label>
                    <div class="controls">
                        <input class="ddate" type="text" name="date_issued" value="<%= (date_issued)? date_issued : '' %>" placeholder="mm/dd/yyyy"  />
                    </div>
                </div>
            </div>
        </div>
	</script>

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var paginatedbankItems = new BankCollection();
            <?php if($crew_id): ?>
	            paginatedbankItems.crew_id = <?php echo $crew_id; ?>;
	        <?php endif; ?>
            var bankmasterView = new BankMasterView({collection: paginatedbankItems});
            var bankpagination = new BankPaginatedView({collection: paginatedbankItems});           
        });
    </script>

    <script type="text/template" id="alertBanksTemplate">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>

	<!-- Modal Add -->          
	<div class="modal hide fade" id="addbank">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Add Bank Loan <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-bank-add"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-success" id="options-submit">Submit</a>
	    </div>
	</div>
	<!-- End Add -->

	<!-- Modal Edit -->          
	<div class="modal hide fade" id="editbank">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">×</button>
	        <h3>Edit Bank Loan <small>&raquo; Setup</small></h3>
	    </div>
	    <div class="modal-body">
	        <form class="form-horizontal">
	            <div id="container-bank-edit"></div>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	        <a href="javascript:void(0);" class="btn btn-primary" id="options-update">Submit Changes</a>
	    </div>
	</div>
	<!-- End Edit -->

     <!-- Modal Delete --> 
    <div class="modal hide fade" id="deletebank">
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

