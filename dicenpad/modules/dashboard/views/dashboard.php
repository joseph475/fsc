<div class="header navbar-fixed-top ">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span2 container-logo">
                <a class="logo" href="/admin">
                	<img alt="FSC" src="<?php echo base_url() . BASE_IMG . 'fsc_logo.png';?>" width="190px">
                </a>
            </div>
            <div class="span10">
                <h1 class="page-title">Control Panel </h1>
            </div>
        </div>
    </div>
</div>
<div style="margin-bottom: 20px"></div>
<div class="container-fluid">
	<div class="row-fluid">  
		<div class="span2">
			<ul class="nav nav-list">
			<li class="nav-header">Submenu</li>
			<li class="active">
				<a href="<?= site_url('admin'); ?>" rel='tooltip' title=''>Dashboard</a>
			</li>
		</ul>
		</div>
		<div class="span7">
			<?php echo $this->load->view('features/icons')?>
		</div>
		<div class="span3">
			<style>  
			@media 
			only screen and (max-width: 760px),
			(min-device-width: 768px) and (max-device-width: 1024px)  {

			  td:nth-of-type(1):before { content: "History Name:"; }
			}

			</style>
			<?php if($data): ?>
			<div class="module-title nav-header">Top 5 Log User</div>
			<div class="row-striped">
				<div class="row-fluid">
					<table class="responsive-table" id="options-table-1" style="margin-bottom: 0;">
                        <tbody>
                        	<?php foreach ($data as $key => $value): 
					            $ci =& get_instance();
					            $ci->load->config('dir');
					            $upload_path = $ci->config->item('upload_dir');

					            $path = $upload_path . 'media/thumbnails/';
					            $url = base_url() . BASE_IMG . 'user-photo.jpg';
					            $photo = ($value->photo)? $path . $value->photo : $url;
					        ?>

                        	<tr>
                        		<td>
						          <a data-content="
						            <center>
						                <image src='<?php echo ($photo)? $photo : '' ?>' width='106' style='margin-bottom: 15px;' />
						            </center>
						            <div class='row page-border'> </div>
						            <center>            
						                <a class='btn' rel='tooltip' title='View Profile' 
						                    href='<?php echo site_url();?>resume/<%= hash %>'>
						                    View Profile
						                </a>
						            </center>
						            " 
						            href="javascript:void(0);"
						            rel="clickover" data-original-title="<?php echo ($value->fullname)? $value->fullname : '' ?>">
						            <?php echo ($value->fullname)? $value->fullname : '' ?>
						            </a>
						            last logged in
						            <?php echo ($value->last_login)? date('M d, Y h:i A', strtotime($value->last_login)) : '' ?>
						          
						        </td>   
						    </tr>
                        	<?php endforeach; ?>

                        	<?php if(is_allowed('LOG_READ')): ?>  
                        	<tr>
                        		<td><p class="help-inline pull-right" style="margin-bottom: 0;"><a class="add-new" href="<?php echo site_url('log-history'); ?>" rel="Log History"><small>View log history</small></a></p></td>
                        	</tr>
                        	<?php endif; ?>
                        </tbody>                            
                    </table>
				</div>
			</div>		
			<?php endif; ?>		
		</div>
	</div>
</div>