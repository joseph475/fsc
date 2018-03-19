
<div class="container-fluid" id="options-list-view">
    <div class="row-fluid">    
        <div class="span12">
            <div class="page-header">
                <h2>Vessel <small>&raquo; Search</small></h2>
            </div>    
            <div class="row-fluid">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab-a" 
                            data-toggle="tab" dep="1"
                            rel="tooltip" title="1">
                            Active
                        </a>
                    </li>
                    <li>
                        <a href="#tab-b" 
                            data-toggle="tab" dep="1"
                            rel="tooltip" title="1">
                            In-active
                        </a>
                    </li>
                </ul> 
                    
                <div class="inopt">
                    <div id="myTabContent" class="tab-content">     
                        <div class="tab-pane fade in active" id="tab-a">
                            <?php echo form_open('crew-list', 'class="form-horizontal" '); ?>
                            <div class="control-group">
                                <label class="control-label control-label-l" for="inputvessel_id">Vessel :</label>
                                <div class="controls controls-l">
                                    <select name="vessel_id" id="vessel_id" >
                                        <?php 
                                        foreach ($vessels as $v_value){ 
                                            echo "<option value='{$v_value->id}' >{$v_value->vessel_name}</option>";
                                        } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label control-label-l" for="inputyear">Year :</label>
                                <div class="controls controls-l">
                                    <input id="inputyear" type="text" name="year" value="<?php echo date("Y"); ?>" style="width: 100px;"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label control-label-l" for="inputmonth">Month :</label>
                                <div class="controls controls-l">
                                    <select name="month" id="month" style="width: 75px;">
                                        <?php 
                                            for ($i=1; $i <= 12; $i++) { 
                                                echo "<option value='{$i}' " . ((date("n") == $i)? 'selected="selected"' : '') .  ">{$i}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label control-label-l" for="inputday">Day :</label>
                                <div class="controls controls-l">
                                    <select name="day" id="day" style="width: 75px;">
                                        <?php 
                                            for ($i=1; $i <= 31; $i++) { 
                                                echo "<option value='{$i}' " . ((date("j") == $i)? 'selected="selected"' : '') .  ">{$i}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls controls-l">
                                    <button type="submit" class="btn btn-success" id="submit-search">Manifest</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>

                        <div class="tab-pane fade" id="tab-b">
                            <?php echo form_open('crew-list', 'class="form-horizontal" '); ?>
                            <div class="control-group">
                                <label class="control-label control-label-l" for="inputvessel_id">Vessel :</label>
                                <div class="controls controls-l">
                                    <select name="vessel_id" id="vessel_id" >
                                        <?php 
                                        foreach ($vessels2 as $v_value){ 
                                            echo "<option value='{$v_value->id}' >{$v_value->vessel_name}</option>";
                                        } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label control-label-l" for="inputyear">Year :</label>
                                <div class="controls controls-l">
                                    <input id="inputyear" type="text" name="year" value="<?php echo date("Y"); ?>" style="width: 100px;"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label control-label-l" for="inputmonth">Month :</label>
                                <div class="controls controls-l">
                                    <select name="month" id="month" style="width: 75px;">
                                        <?php 
                                            for ($i=1; $i <= 12; $i++) { 
                                                echo "<option value='{$i}' " . ((date("n") == $i)? 'selected="selected"' : '') .  ">{$i}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label control-label-l" for="inputday">Day :</label>
                                <div class="controls controls-l">
                                    <select name="day" id="day" style="width: 75px;">
                                        <?php 
                                            for ($i=1; $i <= 31; $i++) { 
                                                echo "<option value='{$i}' " . ((date("j") == $i)? 'selected="selected"' : '') .  ">{$i}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls controls-l">
                                    <button type="submit" class="btn btn-success" id="submit-search">Manifest</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div id="alert-div"></div>
            
                    </div>
                </div>
            </div>
        </div><!--/span-->
    </div><!--/row-->
    