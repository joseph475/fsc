<div class="row-section">
    <div class="row-title">FOR PROMOTION</div> 

    <div id="promotion-info">
        <div class="row-details">            
            <div id="myTabContent" class="tab-content">                    
                <div class="pull-right" id="promotionpagination"></div> 

                <span id="loader-p-container"></span>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alertpe7-div"></div> 
                
                <table class="responsive-table table-attr-center" id="options-table-promotion">
                    <thead>
                        <tr>
                            <th width="2%">Nos</th>
                            <th width="7%">Rank Status</th> 
                            <th width="7%">New Rank</th>                                
                            <th width="35%">Name</th>
                            <th width="6%">Medical Issued</th>
                            <th width="6%">SIRB Expiry</th>
                            <th width="6%">PASSPORT Expiry</th>
                            <th width="6%">COC Expiry</th>
                            <th width="9%">Contract Duration</th>
                            <th width="16%">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>                            
                </table>

                <!-- backbonejs view template -->
                <script id="promotion-list-item" type="text/template">
                    <td><center><%= (counter)? counter : ''  %></center></td>
                    <td><center><%= (old_code)? old_code : ''  %></center></td>
                    <td><center><%= (new_code)? new_code : ''  %></center></td>
                    <td>
                      <a href="<?php echo site_url();?>resume/<%= (hash)? hash : '' %>" target="_blank" >
                        <%= (fullname)? fullname : ''  %>
                      </a>
                    </td>
                    <td class="fs11px"><center><%= (medical_issued)? medical_issued : ''  %></center></td>
                    <td class="fs11px"><center><%= (sirb)? sirb : ''  %></td>
                    <td class="fs11px"><center><%= (passport_expired)? passport_expired : ''  %></center></td>
                    <td class="fs11px"><center><%= (coc_expired)? coc_expired : ''  %></center></td>
                    <td class="fs11px"><center><%= (duration)? duration : ''  %></center></td>
                    <td><%= (remarks)? remarks : ''  %></td>
                </script>

                <?php $this->load->view('template/pagination');?>

                <script type="text/javascript">
                    $(document).ready(function() {
                        var promotionItems = new PromotionCollection();

                        <?php if($id): ?>
                            promotionItems.sched_id = <?php echo $id; ?>;
                            promotionItems.vessel_id = <?php echo $vessel_id; ?>;
                            promotionItems.end_date = "<?php echo date('Y-m', strtotime($repat_date)); ?>";
                        <?php endif; ?>
                   
                        var promotionmasterView = new PromotionMasterView({collection: promotionItems});
                        var promotionpagination = new PromotionPaginatedView({collection: promotionItems});           
                    });
                </script>

                <script type="text/template" id="alertpe7Template">
                    <div class="alert alert-<%= type %>">
                        <button class="close" data-dismiss="alert" type="button">×</button>
                        <%= message %>
                    </div>
                </script>
            </div>
        </div>

    </div>
</div>





