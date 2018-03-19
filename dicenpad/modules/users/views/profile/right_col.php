<?php 
add_js('template/right-col.js');
?>
<div id="depusers-preview">  
  <div class="page-header">
    <a href="#"> <h3><?php echo $dep_name;?>&nbsp;(<span class="depuser-count"></span>) </h3> </a>
  </div>
  <p class="depusers-container"></p>
</div>

<div class="page-header">
  <a href="#"> <h3>Trophy (4)</h3> </a>
</div>

<ul class="thumbnails">
  <li class="span3">
    <div class="thumbnail">
      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Trophy Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/trophy_1_tn.png"></a>
    </div>
  </li>
  <li class="span3">
    <div class="thumbnail">
      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Trophy Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/trophy_2_tn.png"></a>
    </div>
  </li>
  <li class="span3">
    <div class="thumbnail">
      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Trophy Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/trophy_3_tn.png"></a>
    </div>
  </li>
  <li class="span3">
    <div class="thumbnail">
      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Trophy Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/trophy_4_tn.png"></a>
    </div>
  </li>
</ul>

<div class="page-header">
  <a href="#"> <h3>Badge (2) </h3> </a>
</div>

<ul class="thumbnails">
  <li class="span3">
    <div class="thumbnail">
      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/badge_1_tn.png"></a>
    </div>
  </li>

  <li class="span3">
    <div class="thumbnail">
      <a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Badge Title"><img src="<?php echo base_url() . BASE_IMG;?>badge/badge_3_tn.png"></a>
    </div>
  </li>
   
</ul>

<div class="page-header">
  <h3>Thank you's </h3>
</div>

<a data-content="And here's some thank you message, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Henry Smith" class="label label-info">Henry Smith</a>
<a data-content="And here's some  thank you message, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Michelle Rodriguez" class="label label-info">Michelle Rodriguez</a>
<a data-content="And here's some  thank you message, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Joe Henderson" class="label label-info">Joe Henderson</a>
<a data-content="And here's some  thank you message, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Bob Ventura" class="label label-info">Bob Ventura</a>
<a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Allan Martinez" class="label label-info">Allan Martinez</a>
<a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Henry Smith" class="label label-info">Henry Smith</a>
<a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Michelle Rodriguez" class="label label-info">Michelle Rodriguez</a>
<a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Joe Henderson" class="label label-info">Joe Henderson</a>
<a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Bob Ventura" class="label label-info">Bob Ventura</a>
<a data-content="And here's some description of this award, lorem ipsum dolor set amet" rel="popover" href="#" data-original-title="Allan Martinez" class="label label-info">Allan Martinez</a>


<script type="text/javascript">
  $(document).ready(function () {
    var depUsers = new DepartmentUsersCollection();
    depUsers.department_id = <?php echo $department_id;?>;
    <?php if (isset($exclude_id)):?>
      depUsers.exclude_id = <?php echo $exclude_id;?>;
    <?php endif;?>
    var depUsersView = new DepartmentUsersView({collection: depUsers});
  });
</script>

<script type="template/javascript" id="depuser-template"><%= full_name %></script>