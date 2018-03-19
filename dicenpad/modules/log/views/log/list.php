<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Activity:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span8">
            <div class="page-header">
                <h2>Log <small>&raquo; History File</small></h2>
            </div>    
            <div class="row-fluid">             
                <div id="myTabContent" class="tab-content">                    
                    <div class="pull-right" id="pagination"></div>
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <span id="loader-container"></span>
                    </form>   

                    <div id="alert-div"></div> 
                    
                    <table class="responsive-table" id="options-table-1">
                        <thead>
                          <tr>
                            <th class="sortcolumn" col="fullname">Activity</th>
                          </tr>
                        </thead>
                        <tbody></tbody>                            
                    </table>
                    <div id="load-more-container" class="visible-phone">
                        <p>
                            <div class="progress progress-striped active">
                                <div class="bar" style="width:100%;background-color:#eee"></div>
                            </div>
                            <div style="text-align:center">
                                <a href="javascript:void(0);" id="loadmore-options">Load more</a>
                            </div>  
                        </p>
                    </div>
                   
                </div>
            </div>
        </div><!--/span-->
        <div class="span4">
            <div class="page-header">
                <h2>Top 5 <small>&raquo; Log User</small></h2>
            </div>
            <div class="well well-small">
                <?php if(isset($data)): ?>
                 <table class="responsive-table" id="options-table-2" style="margin-bottom: 0;">
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
                            <td>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                    </tbody>                            
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div><!--/row-->
    
    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">   
        <?php 
            $ci =& get_instance();
            $ci->load->config('dir');
            $upload_path = $ci->config->item('upload_dir');

            $path = $upload_path . 'media/thumbnails/';
            $url = base_url() . BASE_IMG . 'user-photo.jpg';
        ?>       
        <td>
          <a data-content="
            <center>
                <image src='<%= (photo)? "<?php echo $path; ?>" + photo : "<?php echo $url; ?>"   %>' width='106' style='margin-bottom: 15px;' />
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
            rel="clickover" data-original-title="<%= (fullname)? fullname : ''  %>">
            <%= (fullname)? fullname : ''  %>
            </a>
            logged on 
            <%= (created)? created : '' %>
            with I.P of 
            <i><%= (ip_address)? ip_address : '' %></i>
        </td>   
    </script>

    <!-- backbonejs view template -->
    <?php $this->load->view('template/pagination');?>

    <!-- Script for autoloading on mobile device -->
    <script type="text/javascript">
        $(document).ready(function() {

            var typeahead = new TypeAheadCollection();
            var paginatedItems = new PaginatedCollection();
            var directoryView = new DirectoryView({collection: paginatedItems});
            var pagination = new PaginatedView({collection: paginatedItems});           
        });
    </script>

    <script type="text/template" id="alertTemplate">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>

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