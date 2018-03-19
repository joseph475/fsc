<div style="margin-bottom: 50px"></div>

<div class="container-narrow " id="download-module">
    <div class="page-header">
        <h2 class="crew_applicant">
            Download 
            <small>» Module</small>
        </h2>
    </div>

    <!-- CREW PERSONAL INFORMATION -->
    <div class="row-section">     
        <div class="row-title"> Download Information</div> 

        <div class="row-details" id="fileupload">               
            <div id="alert0-div"></div>

            <div class="pull-right">
                <a class="btn" href="<?php echo site_url("download-manager"); ?>"> Back to List </a> 
            </div>

            <div class="clearfix"></div>

            <div style="margin-bottom: 20px"></div>

            <form id='form-modal'>
                <table class="responsive-table" id="options-table-1">
                    <tbody>
                        <tr>
                            <td><h5>Date</h5></td>
                            <td class="ab"><?php echo isset($date_created)? date('M d, Y', strtotime($date_created)) : '';?></td>
                        </tr>
                        <tr>
                            <td width="10%;"><h5>Type</h5></td>
                            <td width="90%;" class="ab"><h4><?php echo isset($type)? $type : '';?></h4></td>
                        </tr>
                        <tr>
                            <td><h5>Title</h5></td>
                            <td class="ab"><h4><?php echo isset($title)? $title : '';?></h4></td>
                        </tr>                        
                        <tr>
                            <td><h5>CC</h5></td>
                            <td class="ab"><?php echo isset($users)? $users : '';?></td>
                        </tr>
                        <tr>
                            <td><h5>Created By</h5></td>
                            <td class="ab"><?php echo isset($author)? $author : '';?></td>
                        </tr>
                        <tr>
                            <td><h5>Attachment</h5></td>
                            <td>
                                <?php 
                                    if(isset($filename)) {
                                        if(!empty($filename) || $filename <> '')  {
                                            echo "<a href='". base_url("uploads/files/". $filename) ."' target='_blank' > <i class='icon-download'></i> Download</a>";
                                        } else {
                                            echo "No file attach";
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;"><h5>Description</h5></td>
                            <td colspan="3" class="ab"><?php echo isset($description)? $description : ''; ?></td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <div class="clearfix"></div>
        </div>        
        
    </div>
    
</div>
