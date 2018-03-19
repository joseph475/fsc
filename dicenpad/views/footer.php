	<div class="mar-bot"></div>  

    <?php if (is_logged_in()):?>
    <!-- <footer>
        <div id="status" class="navbar hidden-phone">
            <div class="btn-toolbar">
                <div class="btn-group pull-right">
                <p>&copy; <?php //echo date('Y'); ?> Fair Shipping Corporation. All Rights Reserved. Developed by <a target="_blank" href="http://www.philsoft-ph.com">Philsoft Technologies Group, Inc</a> </p>
            </div>
            <div class="btn-group viewsite">
                <a target="_blank" href="http://www.fairship.com.ph">
                <i class="icon-share-alt"></i>
                    View Site
                </a>
            </div>
            <div class="btn-group divider"> </div>
            <div class="btn-group loggedin-users">
                <span class="badge">0</span>
                Visitors
            </div>
            <div class="btn-group divider"> </div>
            <div class="btn-group logout">
                <a href="<?php //echo site_url('logout');?>">
                <i class="icon-minus-sign"></i>
                    Log out
                </a>
            </div>
            <div class="btn-group divider"> </div>
            <div class="btn-group date">
                <i class="icon-date"></i>
                <?php //echo date('l, F d, Y'); ?>
            </div>
        </div>
    </footer> -->
    <?php endif;?> 
    <?php 
    load_js();
    if (is_logged_in()):
    ?>
    <script type="text/javascript">
        $(document).ajaxSend(function(b,c,a){if(c.setRequestHeader){c.setRequestHeader("<?php echo $this->config->item('rest_key_name');?>","<?php echo $this->session->userdata('api_key')?>")}else{a.data["<?php echo $this->config->item('rest_key_name');?>"]="<?php echo $this->session->userdata('api_key')?>"}});$(document).ready(function(){$("body").ajaxError(function(b,a){if(a.status==403){window.location.reload()}})});
    </script>
    <?php endif;?>  

  </body>
</html>
<?php $ci =& get_instance(); echo $ci->db->close(); ?>