<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Name:"; }
  td:nth-of-type(2):before { content: "Role:"; }
  td:nth-of-type(3):before { content: "Position:"; }
  td:nth-of-type(4):before { content: "Department:"; }
  td:nth-of-type(5):before { content: "Actions:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>User <small>&raquo; Manager</small></h2>
            </div>    
            <div class="row-fluid">             
                <div id="myTabContent" class="tab-content">                    
                    <div class="pull-right" id="pagination"></div>
                    <form class="form-search" autocomplete="off">
                        <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                        <button type="submit" class="btn" id="submit-search">Search</button>
                        <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>

                            <div class="btn-group" style="display: inline-block; position: absolute; margin-left: 3px;">
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-plus"></i> Add <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li>
                                    <a rel="tooltip" title="Add" 
                                    href="<?php echo site_url('add-new-user'); ?>">
                                        <i class="icon-plus"></i>FSC User
                                    </a> 
                                </li>
                                <li>
                                    <a rel="tooltip" title="Add" 
                                    href="<?php echo site_url('add-new-user2'); ?>">
                                        <i class="icon-plus"></i>Principal User
                                    </a> 
                                </li>
                              </ul>
                            </div>
                        <?php endif; ?>

                        <span id="loader-container"></span>
                    </form>   

                    <div id="alert-div"></div> 
                    
                    <table class="responsive-table" id="options-table-1">
                        <thead>
                          <tr>
                            <th class="sortcolumn" col="fullname">Name</th>
                            <th class="sortcolumn" col="role_id">Role</th>
                            <th class="sortcolumn" col="position_id">Position</th>
                            <th>Department</th>
                            <th>Principal</th>
                            <th>Actions</th>
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
                    href='<?php echo site_url();?>profile/<%= user_id %>'>
                    View Profile
                </a>
                <a class='btn btn-danger record-delete' rel='tooltip' title='Delete Profile' 
                    href='javascript:void(0);' data-toggle='modal'>
                    Delete Profile
                </a> 
            </center>
            " 

            href="javascript:void(0);"
            rel="clickover" data-original-title="<%= (fullname)? fullname : ''  %>">
            <%= (fullname)? fullname : ''  %>
          </a>
        </td>
        <td><%= (role)? role : '' %></td>
        <td><%= (position)? position : '' %></td>
        <td><%= (department)? department : '' %></td>
        <td><%= (principal_name)? principal_name : '' %></td>
        <td>
            <div class="btn-group">
                <?php if(is_allowed(getclass($clssnme, FALSE, 3))): ?>
                <% if(principal_id == 0) { %>
                <a class="btn" rel="tooltip" title="Edit" 
                    href="<?php echo site_url('edit-user'); ?>/<%= (user_id)? user_id : '' %>">
                    <i class="icon-edit"></i>
                </a>
                <% } else { %>
                <a class="btn" rel="tooltip" title="Edit" 
                    href="<?php echo site_url('edit-user2'); ?>/<%= (user_id)? user_id : '' %>">
                    <i class="icon-edit"></i>
                </a>
                <% } %>
                <?php endif; ?>

                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                <a class="btn record-delete" rel="tooltip" title="Remove" 
                    href="javascript:void(0);" data-toggle="modal">
                    <i class="icon-remove"></i>
                </a>   
                <?php endif; ?>           
            </div>
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