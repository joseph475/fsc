
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo base_url();?>admin">
                <span><em class="fsc">FSC</em> Crew Management <strong class="v1">v 1.0</strong></span> 
            </a>
            <?php if (is_logged_in()):?>
            <div class="nav-collapse">
                <ul class="nav">
                    <li class="divider-vertical"></li>
                    
                    <li class="<?php echo ($this->uri->segment(1)=='supervisor'?'active':'');?> dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Modules <b class="caret visible-desktop"></b></a>
                        <ul class="dropdown-menu visible-desktop">
                            <li class="nav-header">Crew</li>  
                            <?php if(is_allowed('CREW_READ')): ?>                          
                            <?php if(is_allowed('CREW_INSERT')): ?><li><a href="<?php echo site_url('crew-applicant');?>">New Applicant</a></li><?php endif; ?>   
                            <?php if(!$principal_id): ?>
                            <li><a href="<?php echo site_url('crew-master-list');?>">Master List</a></li>
                            <?php else : ?>
                            <li><a href="<?php echo site_url('crew-princ-list');?>">Master List</a></li>
                            <?php endif; ?>
                            <?php endif; ?>
                            <li class="divider"></li>
                            <li class="nav-header">Quick Setting</li>
                            <?php if (is_allowed('INVENTORY_SETUP_READ')):?>                         
                            <?php if(is_allowed('INVENTORY_SETUP_INSERT')): ?><li><a href="<?php echo site_url('vessel-entry');?>">New Vessel</a></li><?php endif; ?>   
                            <li><a href="<?php echo site_url('vessels-master-list');?>">Vessel Master List</a></li>
                                
                            <?php if(!$principal_id): ?>
                            <?php if(is_allowed('INVENTORY_SETUP_INSERT')): ?><li><a href="<?php echo site_url('principal-entry');?>">New Principal</a></li><?php endif; ?>   
                            <li><a href="<?php echo site_url('principal-master-list');?>">Principal Master List</a></li>   
                        
                            <li><a href="<?php echo site_url('salary-breakdown');?>">Salary Breakdown</a></li>
                            <li><a href="<?php echo site_url('position-setup');?>">Position Manager</a></li>
                            <li><a href="<?php echo site_url('document-list');?>">Document Manager</a></li> 
                            <li><a href="<?php echo site_url('agent-master-list');?>">Agent Setup</a></li>
                            <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <?php if(is_allowed('SCHEDULE_READ') && is_allowed('FLIGHT_READ')): ?>
                    <li class="<?php echo ($this->uri->segment(1)=='hr'?'active':'');?> dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Operation <b class="caret visible-desktop"></b></a>
                         <ul class="dropdown-menu visible-desktop">
                            <li class="nav-header">Transaction</li>
                            <?php if(is_allowed('SCHEDULE_READ')): ?>
                            <?php if(is_allowed('SCHEDULE_INSERT')): ?><li><a href="<?php echo site_url('schedule-replacement');?>">Schedule Replacement</a></li><?php endif; ?>   
                            <li><a href="<?php echo site_url('schedule-list');?>">Schedule Master List</a></li>
                            <?php endif; ?>
                            <?php if(is_allowed('FLIGHT_READ')): ?>
                            <li><a href="<?php echo site_url('flight-schedule-list');?>">Flight Assignment</a></li>
                            <?php endif; ?>
                            <li class="divider"></li>
                            <li class="nav-header">Documents</li>
                            <?php if(is_allowed('MEMO_READ')): ?>
                            <li><a href="<?php echo site_url('upload-manager');?>">Upload Memo</a></li>
                            <li><a href="<?php echo site_url('download-manager');?>">Download Memo</a></li>
                            <?php endif; 
                            if(is_allowed('CONDUCT_READ')): ?>
                            <li><a href="<?php echo site_url('conduct-setup');?>">Conduct</a></li>
                            <?php 
                            endif;  

                            if(is_allowed('SEND_RECEIVED_READ')): 
                            ?>
                            <li><a href="<?php echo site_url('send-document');?>">Sending Docs</a></li>
                            <li><a href="<?php echo site_url('received-document');?>">Received Docs</a></li>
                            <?php endif; ?>
                        </ul>
                    </li> 
                    <?php endif; ?>

                    <li class="<?php echo ($this->uri->segment(1)=='hr'?'active':'');?> dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret visible-desktop"></b></a>
                        <ul class="dropdown-menu visible-desktop">
                            <li class="nav-header">Crew</li>
                            <?php if(is_allowed('SEARCH_READ')): ?>  
                            <?php if(!$principal_id): ?>
                            <li><a href="<?php echo site_url('search-by-crew');?>">Search by Crew</a></li>
                            <li><a href="<?php echo site_url('search-by-crew-principal');?>">Search by Crew &amp; Principal </a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo site_url('search-by-vessel');?>">Search by Vessel</a></li>
                            <li><a href="<?php echo site_url('various-list');?>">Various List</a></li>
                            <?php endif;
                            if(is_allowed('CERTIFICATES_READ') || is_allowed('ONBOARD_READ')): ?>                 
                            <li class="divider"></li>
                            <li class="nav-header">Documents</li>        
                            <li><a href="<?php echo site_url('poea-rps-list');?>">POEA and RPS</a></li>
                            <li><a href="<?php echo site_url('embarkation-list');?>">Embarkation List</a></li>
                            <li><a href="<?php echo site_url('disembarkation-list');?>">Disembarkation List</a></li>    
                            <li><a href="<?php echo site_url('expiry-per-documents');?>">Expiry per Document</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <?php if (is_allowed('ALL_ACCESS_READ')):?>
                    <li class="<?php echo ($this->uri->segment(1)=='hr'?'active':'');?> dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Users <b class="caret visible-desktop"></b></a>
                        <ul class="dropdown-menu visible-desktop">
                            <li class="nav-header">Admin</li>
                            <li><a href="<?php echo site_url('admin-department');?>">Department</a></li>
                            <li><a href="<?php echo site_url('admin-role');?>">Role</a></li>
                            <li><a href="<?php echo site_url('admin-position');?>">Position</a></li>
                            <!--<li><a href="<?php //echo site_url('admin-label');?>">Label</a></li>-->
                            <li class="divider"></li>
                            <li class="nav-header">User</li>
                            <li><a href="<?php echo site_url('user-manager');?>">User Manager</a></li>
                            <li><a href="<?php echo site_url('user-permission');?>">Permission</a></li>
                            <li class="divider"></li>
                            <li class="nav-header">Log</li>
                            <li><a href="<?php echo site_url('log-history');?>">History</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>


                    <?php if (is_allowed('ADMINISTRATIVE_READ') && is_allowed('BANK_STATEMENT_READ')):?>
                    <li class="<?php echo ($this->uri->segment(1)=='hr'?'active':'');?> dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Settings <b class="caret visible-desktop"></b></a>
                        <ul class="dropdown-menu visible-desktop">
                            <?php if (is_allowed('ADMINISTRATIVE_READ')):?>
                            <li class="nav-header">Administrative</li>
                            <li><a href="<?php echo site_url('options-setup');?>">Options Setup</a></li>
                            <li><a href="<?php echo site_url('master-form-setup');?>">ISO Master Form </a></li>
                            <li><a href="<?php echo site_url('signatory-setup');?>">Signatories</a></li>
                            <li><a href="<?php echo site_url('check-list');?>">Checklist </a></li>
                            <li><a href="<?php echo site_url('department-setup');?>">Department Manager</a></li>
                            <li><a href="<?php echo site_url('division-setup');?>">Division Manager</a></li>
                            <li><a href="<?php echo site_url('type-setup');?>">Vessel Type</a></li>
                            <li><a href="<?php echo site_url('sub-type-setup');?>">Vessel Sub-Type</a></li>
                            <li><a href="<?php echo site_url('flag-setup');?>">Flag Setup</a></li>
                            <li class="divider"></li>
                            <?php endif; 
                            if(is_allowed('BANK_STATEMENT_READ')): 
                            ?>
                            <li><a href="<?php echo site_url('bank-statement');?>">Bank Loan</a></li>
                            <?php endif;?>
                            <?php if (is_allowed('ADMINISTRATIVE_READ')):?>
                            <li class="nav-header">Maintenance</li>
                            <li><a href="<?php echo site_url('crew-master/no-position');?>">Crew with No Position</a></li>
                            <?php endif;?>
                        </ul>
                    </li>
                    <?php endif;?>
                </ul>

                <ul class="nav pull-right">
                    <li class="divider-vertical"></li>
                    <li><a href="<?php echo site_url('admin');?>"><img src="<?php echo site_url() . BASE_IMG . 'home.png';?>" height="20" width="20"> <strong>Back to Main</strong> </a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="<?php echo site_url('logout');?>"><img src="<?php echo site_url() . BASE_IMG . 'exit.png';?>" height="20" width="20"> <strong>Logout</strong> </a></li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo $thumbnail_url;?>" height="20" width="20"> <strong><?php echo $first_name . ' ' . $last_name;?></strong> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url();?>profile">View Profile</a></li>
                        </ul>
                    </li>

                </ul>
            </div><!-- /.nav-collapse -->
            <?php endif;?>   <!-- End is logged in -->        
        </div>
    </div><!-- /navbar-inner -->
</div><!-- /navbar -->
