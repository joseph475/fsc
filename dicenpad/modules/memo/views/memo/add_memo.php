<script src="<?php echo js_dir('tinymce/tinymce.min.js');?>" type="text/javascript"></script>
<div style="margin-bottom: 50px"></div>

<div class="container-narrow " id="download-module">
    <div class="page-header">
        <h2 class="crew_applicant">
            New Upload 
            <small>» Module</small>
        </h2>
    </div>

    <!-- CREW PERSONAL INFORMATION -->
    <div class="row-section">     
        <div class="row-title"> Upload Information</div> 

        <div class="row-details" id="fileupload">    
            <?php if(isset($notification)) echo $notification; ?>    

            <?php 
                $attributes = array('id' => 'form-modal', 'autocomplete' => 'off');
                echo form_open_multipart('save-memo', $attributes); 
            ?>       
                <div class="pull-right">
                    <a class="btn" href="<?php echo site_url("upload-manager"); ?>"> Back to List </a> 
                    <?php if(is_allowed(getclass($clssnme, FALSE, 2))): ?>
                    <button class="btn btn-primary" >Save</button>  
                    <?php endif; ?>
                </div>

                <div class="clearfix"></div>

                <div style="margin-bottom: 20px"></div>

                <table class="responsive-table" id="options-table-1">
                    <tbody>
                        <tr>
                            <td width="10%;"><h5>Type</h5></td>
                            <td class="ab">
                                <input type="text" id="input_type" placeholder="Type" value="<?php echo set_value('type'); ?>" name="type"/>  
                            </td>
                            <td rowspan="2" style="vertical-align: top;"><h5>User</h5></td>
                            <td rowspan="2" class="ab">
                                <div class="scrollcheck">
                                    <input type="checkbox" name="check_all"> CHECK ALL <br/>
                                    <?php 
                                    if($users){ 
                                        foreach ($users as $value) {
                                            echo "<input type='checkbox' class='idRow' value='{$value->user_id}' name='user[]'> " . strtoupper($value->fullname) . " <br/>";
                                        }
                                    } else {
                                        echo "Catergory List not found!";
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><h5>Title</h5></td>
                            <td class="ab">
                                <input type="text" id="input_title" placeholder="Title" value="<?php echo set_value('title'); ?>" name="title"/>
                            </td>
                        </tr>
                        <tr>
                            <td><h5>Attachment</h5></td>
                            <td>
                                <input type="file" name="userfile" />
                                <!-- <input type="file" name="userfile[]" size="25" class="multi"/>    
                                <p><small>The image needs to be at least 105 pixels wide or 105 pixels tall.</small></p> -->
                            </td>
                            <td colspan="2">File must be in (.doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .zip, .rar) format</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;"><h5>Description</h5></td>
                            <td colspan="3" class="ab">
                                <textarea id="elm1" name="description"><?php echo set_value('description'); ?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php echo form_close(); ?>
            <div class="clearfix"></div>
        </div>        
        
    </div>
    
</div>

<script type="text/javascript">
    tinymce.init({
        selector: "textarea#elm1",
        theme: "modern",
        height: 300,
        plugins: [
             "advlist autolink link image lists charmap preview hr anchor pagebreak ",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
             "save table contextmenu directionality emoticons template paste textcolor"
       ],
       //content_css: "css/content.css",
       toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
       style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ]
     }); 

    $(document).on(' change','input[name="check_all"]',function() {
        $('.idRow').prop("checked" , this.checked);
    });
</script>
