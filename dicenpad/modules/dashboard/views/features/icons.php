<section id="thumbnails">
	<?php if(is_allowed('SEARCH_READ')): ?> 
	<h2>Manager's Section</h2>
	<p>Managers Section Thumbnails are designed to showcase linked with Search by Crew &amp; Vessel, Various List.</p>
	<div class="row-fluid">
		<ul class="thumbnails">
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('search-by-vessel');?>" data-original-title="Search by vessel">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/searc_vessel.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Search by vessel</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<?php if(!$principal_id): ?>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('search-by-crew');?>" data-original-title="Search by Crew">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/searc_crew.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Search by Crew</small></p>
				  		</a>
				  	</center>
				</div>		
			</li>
			<?php endif; ?>
			<li class="span3">
				<div class="thumbnail ic">
				 	<center>
				  		<a href="<?php echo site_url('various-list');?>" data-original-title="Various list">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/variouslist.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Various list</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
		</ul>
	</div>
	<?php endif; ?>
	<h2>Default thumbnails</h2>
	<p>By default, Thumbnails are designed to showcase linked with FSC Modules.</p>
	<div class="row-fluid">
		<ul class="thumbnails">
			<?php 
			if(is_allowed('CREW_READ')): 
				if(is_allowed('CREW_INSERT')):
			?>     
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('crew-applicant');?>" data-original-title="New Applicant">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/new.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>New Crew</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<?php endif; ?>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
						<?php if(!$principal_id): ?>
				  		<a href="<?php echo site_url('crew-master-list');?>" data-original-title="Crew Master List">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/crew.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Crew Masterlist</small></p>
				  		</a>
				  		<?php else : ?>
				  		<a href="<?php echo site_url('crew-princ-list');?>" data-original-title="Crew Master List">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/crew.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Crew Masterlist</small></p>
				  		</a>
                        <?php endif; ?>
				  	</center>
				</div>
			</li>
			<?php endif; 
			if (is_allowed('INVENTORY_SETUP_READ')):?>

		<?php if(!$principal_id): ?>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('vessels-master-list');?>" data-original-title="Vessel Master List">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/vessel.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Vessel Masterlist</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
		<?php endif; ?>
		
			<?php if(!$principal_id): ?>
			<li class="span3">
				<div class="thumbnail ic">
				 	<center>
				  		<a href="<?php echo site_url('principal-master-list');?>" data-original-title="Principal Master List">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/principal.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Principal Masterlist</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('salary-breakdown');?>" data-original-title="Salary Breakdown">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/salary.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Salary Breakdown</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('position-setup');?>" data-original-title="Position Manager">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/rank.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Position Manager</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('document-list');?>" data-original-title="Document Manager">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/folder.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Document Manager</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('agent-master-list');?>" data-original-title="Agent Setup">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/agent.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Agent Setup</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<?php endif; ?>
			<?php endif;
			if(is_allowed('SCHEDULE_READ')): 
				if(is_allowed('SCHEDULE_INSERT')):
			?> 
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('schedule-replacement');?>" data-original-title="Schedule Replacement Plan">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/replacement.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>SRP</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<?php endif;?>
			
			
			<?php if(!$principal_id or $principal_id == 39): ?>

			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('schedule-list');?>" data-original-title="SRP Masterlist">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/srplist.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>SRP Masterlist</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
				<?php endif;?>
			<?php endif; 
            if(is_allowed('CONDUCT_READ')): ?>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('conduct-setup');?>" data-original-title="Conduct">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/conduct.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Conduct</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<?php endif; 
            if(is_allowed('BANK_STATEMENT_READ')): ?>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('bank-statement');?>" data-original-title="Bank Loan">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/bank_statement.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Bank Loan</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<?php endif; 
            if(is_allowed('SEND_RECEIVED_READ')): ?>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('send-document');?>" data-original-title="Sending Document">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/send.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Sending Document</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('received-document');?>" data-original-title="Received Document">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/received.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Received Document</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<?php endif;
			if (is_allowed('ADMINISTRATIVE_READ')):?>			
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('option-setup');?>" data-original-title="Option Manager">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/option.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Option Manager</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('master-form-setup');?>" data-original-title="ISO Master Form">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/iso.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>ISO Master Form</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('signatory-setup');?>" data-original-title="Signatories">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/signatory.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Signatories</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('check-list');?>" data-original-title="Document Checklist ">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/checklist.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Document Checklist</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('department-setup');?>" data-original-title="Department Manager">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/department.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Department Manager</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				 	<center>
				  		<a href="<?php echo site_url('division-setup');?>" data-original-title="Division Manager">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/division.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Division Manager</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('vessel-type-setup');?>" data-original-title="Vessel Type">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/vessel_type.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Vessel Type</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('sub-type-setup');?>" data-original-title="Vessel Sub-Type">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/vessel_type2.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Vessel Sub-Type</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('vessel-setup');?>" data-original-title="Flag Manager">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/flag.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>Flag</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<?php endif;
			if (is_allowed('ALL_ACCESS_READ')):?>	
			<li class="span3">
				<div class="thumbnail ic">
				  	<center>
				  		<a href="<?php echo site_url('user-manager');?>" data-original-title="User Manager">
				  			<img src="<?php echo base_url() . BASE_IMG;?>menu/users.png" />
				  			<div class="clearfix"></div>
				  			<p class="help-inline"><small>User Manager</small></p>
				  		</a>
				  	</center>
				</div>
			</li>
			<?php endif;?>
		</ul>
	</div>
</section>