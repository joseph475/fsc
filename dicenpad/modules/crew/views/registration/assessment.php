<div class="accordion-group row-section">
    
    <?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#assessment-info"><?php endif; ?>
        <div class="row-title">PERSONAL ASSESSMENT</div> 
    <?php if($crew_id): ?></a><?php endif; ?>

    <div id="assessment-info" class="accordion-body collapse">
        <div class="row-details">            
            <div id="myTabContent" class="tab-content">      

                <a id="assessment-btn" class="btn btn-primary" >Save</a>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alertAssess-div"></div> 

                <script type="text/javascript">
                    $(document).ready(function () {
                        <?php if($crew_id): ?>
                            var assesscollection = new Assesscollection();
                            assesscollection.id = <?php echo $crew_id; ?>; 
                            var assessView = new AssessView({collection: assesscollection});
                        <?php endif; ?>
                    });
                </script>

                <script type="text/template" id="alertAssessTemplate">
                    <div class="alert alert-<%= type %>">
                        <button class="close" data-dismiss="alert" type="button">×</button>
                        <%= message %>
                    </div>
                </script>

                <table class="responsive-table" id="options-table-assessment">
                    <tbody>
                        <tr>
                            <td width="15%">Family</td>
                            <td width="18%">
                                <select name="pa_family" class="fw98 ab">
                                    <option value="A" <?php echo ('A' == $pa_family)? 'selected="selected"' : '' ?> >A. Married</option>
                                    <option value="B" <?php echo ('B' == $pa_family)? 'selected="selected"' : '' ?> >B. With Parents</option>
                                    <option value="C" <?php echo ('C' == $pa_family)? 'selected="selected"' : '' ?> >C. Alone</option>
                                </select>
                            </td>
                            <td width="15%">Smoking</td>
                            <td width="18%">
                                <select name="pa_smoking" class="fw98 ab">
                                    <option value="A" <?php echo ('A' == $pa_smoking)? 'selected="selected"' : '' ?> >A. None</option>
                                    <option value="B" <?php echo ('B' == $pa_smoking)? 'selected="selected"' : '' ?> >B. 1/2 package/day</option>
                                    <option value="C" <?php echo ('C' == $pa_smoking)? 'selected="selected"' : '' ?> >C. 1 package/day</option>
                                </select>
                            </td>
                            <td width="15%">Drinking</td>
                            <td width="18%">
                                <select name="pa_drinking" class="fw98 ab">
                                    <option value="A" <?php echo ('A' == $pa_drinking)? 'selected="selected"' : '' ?> >A. None</option>
                                    <option value="B" <?php echo ('B' == $pa_drinking)? 'selected="selected"' : '' ?> >B. 1 can beer/day</option>
                                    <option value="C" <?php echo ('C' == $pa_drinking)? 'selected="selected"' : '' ?> >C. Heavy</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Any Previous Illness</td>
                            <td>
                                <select name="pa_prev_ill" class="fw98 ab">
                                    <option value="A" <?php echo ('A' == $pa_prev_ill)? 'selected="selected"' : '' ?> >A. None</option>
                                    <option value="C" <?php echo ('C' == $pa_prev_ill)? 'selected="selected"' : '' ?> >C. With some remarks</option>
                                </select>
                            </td>
                            <td>Job Ability</td>
                            <td>
                                <select name="pa_job_ability" class="fw98 ab">
                                    <option value="A" <?php echo ('A' == $pa_job_ability)? 'selected="selected"' : '' ?> >A. Good</option>
                                    <option value="B" <?php echo ('B' == $pa_job_ability)? 'selected="selected"' : '' ?> >B. Normal</option>
                                    <option value="C" <?php echo ('C' == $pa_job_ability)? 'selected="selected"' : '' ?> >C. Poor</option>
                                </select>
                            </td>
                            <td>Motivation to be Seaman</td>
                            <td>
                                <select name="pa_motivation" class="fw98 ab">
                                    <option value="A" <?php echo ('A' == $pa_motivation)? 'selected="selected"' : '' ?> >A. Positive answer</option>
                                    <option value="B" <?php echo ('B' == $pa_motivation)? 'selected="selected"' : '' ?> >B. Intermediate</option>
                                    <option value="C" <?php echo ('C' == $pa_motivation)? 'selected="selected"' : '' ?> >C. Money Purpose</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="vertical-align: top;">Why he wants to change Company?</td>
                            <td colspan="4">
                                <textarea name="pa_change" style="width: 98%;" class="ab"><?php echo $pa_change ?></textarea>
                            </td>
                        </tr>
                    </tbody>                            
                </table>
            </div>
        </div>

    </div>
</div>

