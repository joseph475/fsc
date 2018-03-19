<div class="accordion-group row-section">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#education-info">
        <div class="row-title">EDUCATIONAL ATTAINMENT</div> 
    </a>
    
    <div id="education-info" class="accordion-body collapse">
    	<div class="row-details" style="padding-top: 20px;">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="pagination"></div> 

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <table class="responsive-table" id="options-table-educs">
                    <thead>
                      <tr>
                        <th>Year (Start - End)</th>
                        <th>School</th>                                
                        <th>Course Finished</th>
                        <th>Special Course</th>
                        <th>Qualification</th>
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
        </script>
        
        <!-- backbonejs view template -->
        <?php $this->load->view('template/pagination');?>

        <!-- Script for autoloading on mobile device -->
        <script type="text/javascript">
            $(document).ready(function() {

                var paginatedItems = new EducCollection();
                <?php if(isset($crew_id)): ?>
    	            paginatedItems.crew_id = <?php echo $crew_id; ?>;
    	        <?php endif; ?>
                var educmasterView = new EducMasterView({collection: paginatedItems});
                var pagination = new PaginatedView({collection: paginatedItems});           
            });
        </script>

    </div>
</div>
