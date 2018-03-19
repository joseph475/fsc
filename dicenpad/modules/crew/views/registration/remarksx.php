<div class="accordion-group row-section">
    
    <?php if(isset($about)): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#managers-remarks"><?php endif; ?>
        <div class="row-title">MANAGER'S REMARKS</div> 
    <?php if(isset($about)): ?></a><?php endif; ?>

    <div id="managers-remarks" class="accordion-body collapse">
        <div class="row-details">            
            <div id="myTabContent" class="tab-content">      

                <a id="remarks-btn" class="btn btn-primary" >Save</a>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alertRemarks-div"></div> 

                <script type="text/javascript">
                    $(document).ready(function () {
                        <?php if(isset($about)): ?>
                            var remarkscollection = new Remarkscollection();
                            remarkscollection.id = <?php echo $crew_id; ?>; 
                            var remarksView = new RemarksView({collection: remarkscollection});
                        <?php endif; ?>
                    });
                </script>

                <script type="text/template" id="alertRemarksTemplate">
                    <div class="alert alert-<%= type %>">
                        <button class="close" data-dismiss="alert" type="button">×</button>
                        <%= message %>
                    </div>
                </script>

                <textarea name="remarks" id="remarks" class="ab" style="width: 99%; height: 120px;"><?php echo isset($remarks)? $remarks : ''; ?></textarea>
            </div>
        </div>

    </div>
</div>

