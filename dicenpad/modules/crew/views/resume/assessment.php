<div class="accordion-group row-section">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#assessment-info">
        <div class="row-title">PERSONAL ASSESSMENT</div> 
    </a>
    <div id="assessment-info" class="accordion-body collapse"> 
    	<div class="row-details" style="padding-top: 20px;">            
            <div id="myTabContent" class="tab-content">                

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <table class="responsive-table" id="options-table-assessment">
                    <tbody>
                        <tr>
                            <td width="30%">Family</td>
                            <td width="3%"><center><h5><?php echo $pa_family ?></h5></center></td>
                            <td width="30%">Smoking</td>
                            <td width="3%"><center><h5><?php echo $pa_smoking ?></h5></center></td>
                            <td width="30%">Drinking</td>
                            <td width="3%"><center><h5><?php echo $pa_drinking ?></h5></center></td>
                        </tr>
                        <tr>
                            <td colspan="2">A: Married  B: With Parents  C: Alone</td>
                            <td colspan="2">A: None  B: 1 package/day</td>
                            <td colspan="2">A: None  B: 1 can beer/day  C: Heavy</td>
                        </tr>
                        <tr>
                            <td>Any Previous Illness</td>
                            <td><center><h5><?php echo $pa_prev_ill ?></h5></center></td>
                            <td>Job Ability</td>
                            <td><center><h5><?php echo $pa_job_ability?></h5></center></td>
                            <td>Motivation to be Seaman</td>
                            <td><center><h5><?php echo $pa_motivation ?></h5></center></td>
                        </tr>
                        <tr>
                            <td colspan="2">A: None  B: With some remarks</td>
                            <td colspan="2">A: Good  B: Normal  C: Poor</td>
                            <td colspan="2">A: Positive answer  B: Money Purpose</td>
                        </tr>
                        <tr>
                            <td colspan="2">Why he wants to change Company?</td>
                            <td colspan="4"><?php echo $pa_change ?></td>
                        </tr>
                    </tbody>                            
                </table>
            </div>
        </div>
    </div>
</div>

