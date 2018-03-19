<style>  
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

  td:nth-of-type(1):before { content: "Document:"; }
  td:nth-of-type(2):before { content: "Sort Order:"; }
  td:nth-of-type(3):before { content: "Sub Order:"; }
  td:nth-of-type(4):before { content: "Officers Deck:"; }
  td:nth-of-type(5):before { content: "Officers Engr:"; }
  td:nth-of-type(6):before { content: "Officers Stwd:"; }
  td:nth-of-type(7):before { content: "Ratings Deck:"; }
  td:nth-of-type(8):before { content: "Ratings Engr:"; }
  td:nth-of-type(9):before { content: "Ratings Stwd:"; }
  td:nth-of-type(10):before { content: "Published:"; }
}

</style>

<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Documents Checklist <small>&raquo; Master File</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <li>
                        <a href="#status_id-1" 
                            data-toggle="tab" dep="1"
                            rel="tooltip" title="1">
                            Master List
                        </a>
                    </li>
                </ul>    
                <div id="myTabContent" class="tab-content">                    
                    <div class="pull-right" id="pagination"></div>
                    <form class="form-search" autocomplete="off">
                        <div class="addbutton-section">
                            <select name="type_id" id="type_id" style="width: 150px;">
                                <?php 
                                    if($types){
                                        foreach ($types as $value) {
                                            echo "<option value='{$value->id}'>{$value->title}</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <input type="text" class="input-medium search-query" data-provide="typeahead" id="search" autocomplete="off" />
                            
                            <button type="submit" class="btn" id="submit-search">Search</button>
                            <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                                <a class="btn btn-success record-add" rel="tooltip" title="Update" 
                                href="javascript:void(0);" data-toggle="modal">
                                    Load Documents
                                </a> 

                                <a class="btn btn-primary record-save" rel="tooltip" title="Save" 
                                href="javascript:void(0);" data-toggle="modal">
                                    Save
                                </a> 
                            <?php endif; ?>
                            <span id="loader-container"></span>
                        </div>
                    </form>   

                    <div id="alert-div"></div> 

                    <div class="tab-pane fade in" id="status_id-1">
                        <table class="responsive-table" id="options-table-1">
                            <thead>
                              <tr>
                                <th style="width: 3%;">&nbsp;</th>
                                <th style="width: 30%;" class="sortcolumn" col="document">Document</th>
                                <th style="width: 7%;"><center>Sort Order</center></th> 
                                <th style="width: 7%;"><center>Sub Order</center></th> 
                                <th style="width: 8%;"><center>Officers Deck</center></th> 
                                <th style="width: 8%;"><center>Officers Engr</center></th>   
                                <th style="width: 8%;"><center>Ratings Deck</center></th> 
                                <th style="width: 8%;"><center>Ratings Engr</center></th>  
                                <th style="width: 8%;"><center>Catering</center></th> 
                                <th style="width: 5%;"><center>Actions</center></th>
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
            </div>
        </div><!--/span-->
    </div><!--/row-->
    
    <!-- backbonejs view template -->
    <script id="emp-list-item" type="text/template">  
        <td>   
            <center>
                <input type="checkbox" <%= (published == 1)?  "checked='checked'" : '' %> name="published" id="published" />
            </center>   
        </td>         
        <td><%= (document)? document : ''  %></td>
        <td><center><input type="text" name="sort_order" value="<%= (sort_order)? sort_order : 0 %>" style="width: 30px;"/></center></td>
        <td>
            <center>
                <select name="sub_order" style="width: 50px;">
                    <option value="" <%= (sub_order == '')? 'selected="selected"' : '' %> >&nbsp;</option>
                    <option value="a" <%= (sub_order == 'a')? 'selected="selected"' : '' %> >a</option>
                    <option value="b" <%= (sub_order == 'b')? 'selected="selected"' : '' %> >b</option>
                    <option value="c" <%= (sub_order == 'c')? 'selected="selected"' : '' %> >c</option>
                    <option value="d" <%= (sub_order == 'd')? 'selected="selected"' : '' %> >d</option>
                    <option value="e" <%= (sub_order == 'e')? 'selected="selected"' : '' %> >e</option>
                    <option value="f" <%= (sub_order == 'f')? 'selected="selected"' : '' %> >f</option>
                    <option value="g" <%= (sub_order == 'g')? 'selected="selected"' : '' %> >g</option>
                </select>
            </center>
        </td>
        <td>
            <center>   
                <select name="officer_deck" style="width: 50px;">
                    <option value="-" <%= (officer_deck == '-')? 'selected="selected"' : '' %> >-</option>
                    <option value="O" <%= (officer_deck == 'O')? 'selected="selected"' : '' %> >O</option>
                    <option value="(O)" <%= (officer_deck == '(O)')? 'selected="selected"' : '' %> >(O)</option>
                </select>
            </center>
        </td>  
        <td>   
            <center>
                <select name="officer_engr" style="width: 50px;">
                    <option value="-" <%= (officer_engr == '-')? 'selected="selected"' : '' %> >-</option>
                    <option value="O" <%= (officer_engr == 'O')? 'selected="selected"' : '' %> >O</option>
                    <option value="(O)" <%= (officer_engr == '(O)')? 'selected="selected"' : '' %> >(O)</option>
                </select>
            </center>
        </td>  
        <td>  
            <center> 
                <select name="rating_deck" style="width: 50px;">
                    <option value="-" <%= (rating_deck == '-')? 'selected="selected"' : '' %> >-</option>
                    <option value="O" <%= (rating_deck == 'O')? 'selected="selected"' : '' %> >O</option>
                    <option value="(O)" <%= (rating_deck == '(O)')? 'selected="selected"' : '' %> >(O)</option>
                </select>
            </center>
        </td>  
        <td>   
            <center>
                <select name="rating_engr" style="width: 50px;">
                    <option value="-" <%= (rating_engr == '-')? 'selected="selected"' : '' %> >-</option>
                    <option value="O" <%= (rating_engr == 'O')? 'selected="selected"' : '' %> >O</option>
                    <option value="(O)" <%= (rating_engr == '(O)')? 'selected="selected"' : '' %> >(O)</option>
                </select>
            </center>
        </td> 
        <td>  
            <center> 
                <select name="rating_stwd" style="width: 50px;">
                    <option value="-" <%= (rating_stwd == '-')? 'selected="selected"' : '' %> >-</option>
                    <option value="O" <%= (rating_stwd == 'O')? 'selected="selected"' : '' %> >O</option>
                    <option value="(O)" <%= (rating_stwd == '(O)')? 'selected="selected"' : '' %> >(O)</option>
                </select>
            </center>
        </td> 
        <td>
            <div class="btn-group">
            <center>
                <?php if(is_allowed(getclass($clssnme, FALSE, 4))): ?>
                <a class="btn record-delete" rel="tooltip" title="Remove" 
                    href="javascript:void(0);" data-toggle="modal">
                    <i class="icon-remove"></i>
                </a>  
                <?php endif; ?> 
            </center>          
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
