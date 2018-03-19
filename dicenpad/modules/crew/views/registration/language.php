<div class="accordion-group row-section">
    
    <?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#language-info"><?php endif; ?>
        <div class="row-title">ENGLISH LEVEL</div> 
    <?php if($crew_id): ?></a><?php endif; ?>

    <div id="language-info" class="accordion-body collapse">
        <div class="row-details">            
            <div id="myTabContent" class="tab-content">      

                <a id="language-btn" class="btn btn-primary" >Save</a>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alertlanguage-div"></div> 

                <script type="text/javascript">
                    $(document).ready(function () {
                        <?php if($crew_id): ?>
                            var langcollection = new Langcollection();
                            langcollection.id = <?php echo $crew_id; ?>; 
                            var langView = new LangView({collection: langcollection});
                        <?php endif; ?>
                    });
                </script>

                <script type="text/template" id="alertLangTemplate">
                    <div class="alert alert-<%= type %>">
                        <button class="close" data-dismiss="alert" type="button">×</button>
                        <%= message %>
                    </div>
                </script>

                <table class="table" id="options-table-language">
                    <tbody>
                        <tr>
                            <td style="border-right: 1px solid #DDD;">Read and write</td>
                            <td><center><input type="radio" class="ab" name="read_write" value="1" <?php echo (1 == $read_write)? 'checked="checked"' : ''; ?>/> Excellent</center></td>
                            <td><center><input type="radio" class="ab" name="read_write" value="2" <?php echo (2 == $read_write)? 'checked="checked"' : ''; ?>/> Good</center></td>
                            <td><center><input type="radio" class="ab" name="read_write" value="3" <?php echo (3 == $read_write)? 'checked="checked"' : ''; ?>/> Acceptable</center></td>
                            <td><center><input type="radio" class="ab" name="read_write" value="4" <?php echo (4 == $read_write)? 'checked="checked"' : ''; ?>/> Poor</center></td>
                            <td><center><input type="radio" class="ab" name="read_write" value="5" <?php echo (5 == $read_write)? 'checked="checked"' : ''; ?>/> Unsuitable</center></td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid #DDD;">Speak and Listen</td>
                            <td><center><input type="radio" class="ab" name="speak_listen" value="1" <?php echo (1 == $speak_listen)? 'checked="checked"' : ''; ?>/> Excellent</center></td>
                            <td><center><input type="radio" class="ab" name="speak_listen" value="2" <?php echo (2 == $speak_listen)? 'checked="checked"' : ''; ?>/> Good</center></td>
                            <td><center><input type="radio" class="ab" name="speak_listen" value="3" <?php echo (3 == $speak_listen)? 'checked="checked"' : ''; ?>/> Acceptable</center></td>
                            <td><center><input type="radio" class="ab" name="speak_listen" value="4" <?php echo (4 == $speak_listen)? 'checked="checked"' : ''; ?>/> Poor</center></td>
                            <td><center><input type="radio" class="ab" name="speak_listen" value="5" <?php echo (5 == $speak_listen)? 'checked="checked"' : ''; ?>/> Unsuitable</center></td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid #DDD;">Other Language</td>
                            <td colspan="5"><input type="text" class="ab" name="other_language" value="<?php echo $other_language ?>"/></td>
                        </tr>
                    </tbody>                            
                </table>
            </div>
        </div>

    </div>
</div>

