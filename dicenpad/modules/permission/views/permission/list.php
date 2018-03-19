<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Application:"; }
  td:nth-of-type(2):before { content: "Resource ID:"; }
  td:nth-of-type(3):before { content: "VIEW:"; }
  td:nth-of-type(4):before { content: "INSERT:"; }
  td:nth-of-type(5):before { content: "UPDATE:"; }
  td:nth-of-type(6):before { content: "DELETE:"; }
  td:nth-of-type(7):before { content: "PRINT:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>User Permission <small>&raquo; Master File</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <?php foreach ($options_record as $index => $options_value):?>
                    <?php if ($index < 9):?>
                        <li>
                            <a href="#status_id-<?php echo strtolower($options_value->role_id)?>" 
                                data-toggle="tab" dep="<?php echo strtolower($options_value->role_id)?>"
                                rel="tooltip" title="<?php echo strtolower($options_value->role); ?>">
                                <?php echo (strlen($options_value->role) > 20) ? ucwords(strtoupper(substr($options_value->role,0,20))) . '&hellip;' : ucwords(strtoupper($options_value->role));?>
                            </a>
                        </li>
                    <?php ;else:?>
                        <li <?php if ($index == 9): ?> class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                MORE
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                            <?php ;else:?>
                            ><!-- end <li> -->
                            <?php endif;?>
                            <a href="#status_id-<?php echo strtolower($options_value->role_id)?>" 
                                data-toggle="tab" dep="<?php echo strtolower($options_value->role_id)?>"
                                rel="tooltip" title="<?php echo strtolower($options_value->role);?>"
                                >
                                <?php echo ucwords(strtoupper($options_value->role));?>
                            </a>
                        </li>
                        <?php if ($index == (count($options_record) - 1)):?></ul><?php endif;?>
                    <?php endif;?>
                  <?php endforeach;?>
                </ul>  
                <div id="myTabContent" class="tab-content">                    
                    <div class="pull-right" id="pagination"></div>
                    <form class="form-search" autocomplete="off">
                        <div class="addbutton-section">
                            <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                            <button type="submit" class="btn" id="submit-search">Search</button>
                            
                            <a class="btn btn-primary record-save" rel="tooltip" title="Save" 
                            href="javascript:void(0);" data-toggle="modal">
                                Save
                            </a> 
                            <span id="loader-container"></span>
                        </div>
                    </form>   

                    <div id="alert-div"></div> 

                    <?php foreach ($options_record as $options_value):?>
                    <div class="tab-pane fade in" id="status_id-<?php echo $options_value->role_id;?>">
                        <table class="responsive-table" id="options-table-<?php echo $options_value->role_id;?>">
                            <thead>
                              <tr>
                                <th class="sortcolumn" col="jd_admin_resource.resource_code">Application</th>
                                <th class="sortcolumn" col="jd_admin_resource.resource_id"><center>Resource ID</center></th>                         
                                <th><center>VIEW</center></th>
                                <th><center>INSERT</center></th>
                                <th><center>UPDATE</center></th>
                                <th><center>DELETE</center></th>
                                <th><center>PRINT</center></th>
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
                    <?php endforeach;?>
                </div>
            </div>
        </div><!--/span-->
    </div><!--/row-->
    
    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">          
        <td>
            <a data-content="
            <%= (resource)? resource : '' %>
            <div class='row page-border'> </div>
            " 
            href="javascript:void(0);"
            rel="clickover" data-original-title="<%= (resource_code)? resource_code : ''  %>">
            <%= (resource_code)? resource_code : ''  %>
            </a><br/><p class="help-inline"><small><%= (resource)? resource : '' %></small></p>
        </td>
        <td><center><%= (resource_id)? resource_id : ''  %>&nbsp;</center></td>       
        <td>
            <center>   
                <select name="i_read" style="width: 70px;">
                    <option value="allow" <%= (i_read == 'allow')? 'selected="selected"' : '' %> >allow</option>
                    <option value="deny" <%= (i_read == 'deny')? 'selected="selected"' : '' %> >deny</option>
                </select>
            </center>
        </td>  
        <td>   
            <center>
                <select name="i_insert" style="width: 70px;">
                   <option value="allow" <%= (i_insert == 'allow')? 'selected="selected"' : '' %> >allow</option>
                    <option value="deny" <%= (i_insert == 'deny')? 'selected="selected"' : '' %> >deny</option>
                </select>
            </center>
        </td> 
        <td>
            <center>   
                <select name="i_update" style="width: 70px;">
                    <option value="allow" <%= (i_update == 'allow')? 'selected="selected"' : '' %> >allow</option>
                    <option value="deny" <%= (i_update == 'deny')? 'selected="selected"' : '' %> >deny</option>
                </select>
            </center>
        </td>  
        <td>  
            <center> 
                <select name="i_delete" style="width: 70px;">
                    <option value="allow" <%= (i_delete == 'allow')? 'selected="selected"' : '' %> >allow</option>
                    <option value="deny" <%= (i_delete == 'deny')? 'selected="selected"' : '' %> >deny</option>
                </select>
            </center>
        </td>  
        <td>  
            <center> 
                <select name="i_print" style="width: 70px;">
                    <option value="allow" <%= (i_print == 'allow')? 'selected="selected"' : '' %> >allow</option>
                    <option value="deny" <%= (i_print == 'deny')? 'selected="selected"' : '' %> >deny</option>
                </select>
            </center>
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

            //var form = new OptionsForm({typeahead: directoryView});

            $(window).scroll(function() {
                 if (!directoryView.collection.isLoading && $('#load-more-container').is(':visible')
                    && $(window).scrollTop() + $(window).height() > getDocHeight() - 100 ) {
                    $('#loadmore-employee').trigger('click');
                }
            });
            var app_router = new EmployeeListRouter;

            Backbone.history.start();  
                   
        });
    </script>

    <script type="text/template" id="alertTemplate">
        <div class="alert alert-<%= type %>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <%= message %>
        </div>
    </script>