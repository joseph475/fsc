<div class="accordion-group row-section">
    
    <?php if($crew_id): ?><a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#interview-info"><?php endif; ?>
        <div class="row-title">INTERVIEW REPORT</div> 
    <?php if($crew_id): ?></a><?php endif; ?>

    <div id="interview-info" class="accordion-body collapse">
        <div class="row-details">            
            <div id="myTabContent" class="tab-content">      

                <a id="interview-btn" class="btn btn-primary" >Save</a>

                <div class="clearfix" style="margin-bottom: 20px;"></div>

                <div id="alertInterview-div"></div> 

                <table class="responsive-table">
                    <tr>
                        <td>Name</td>
                        <td><?= isset($fullname)? $fullname : '' ?></td>    
                        <td>Rank</td>
                        <td width="15%">
                            <select name="intposition_id" class="ab" style="width: 96%">
                                <?php 
                                if($positions){
                                    foreach ($positions as $p_value){ 
                                        echo "<option value='{$p_value->id}' " . (($p_value->id == _p($interview,'position_id'))? 'selected="selected"' : '') . ">{$p_value->position}</option>";
                                    } 
                                }
                                ?>
                            </select>
                        </td>  
                        <td>Age</td>
                        <td width="15%"><input type="text" class="ab" id="age" value="<?= (_p($interview, 'age'))? _p($interview, 'age') : $age ?>" name="age" style="width: 96%"/></td>
                    </tr>
                    <tr>
                        <td>Assigned Vessel</td>
                        <td>
                            <select name="intvessel_id" class="ab" style="width: 96%">
                                <?php 
                                if($vessels){
                                    foreach ($vessels as $v_value){ 
                                        echo "<option value='{$v_value->id}' " . (($v_value->id == _p($interview,'vessel_id'))? 'selected="selected"' : '') . ">{$v_value->vessel_name}</option>";
                                    } 
                                }
                                ?>
                            </select>
                        </td>    
                        <td>Tentative Schedule</td>
                        <td><input type="text" class="ab" id="tentative_sched" value="<?= _p($interview,'tentative_sched') ?>" name="tentative_sched" style="width: 96%"/></td>
                        <td>Department</td>
                        <td>
                            <select name="vesseltype" class="ab" style="width: 96%">
                                <option value="Deck" <?php echo ('Deck' == _p($interview,'vesseltype'))? 'selected="selected"' : '' ?> >Deck</option>
                                <option value="Engine" <?php echo ('Engine' == _p($interview,'vesseltype'))? 'selected="selected"' : '' ?> >Engine</option>
                            </select>
                        </td>  
                    </tr>
                    <tr>
                        <td rowspan="6" style="vertical-align: top;">Previous Vessels</td>
                        <td colspan="2">Kind of Vessels</td>
                        <td colspan="3"><input type="text" class="ab" id="prevkindvessel" value="<?= _p($interview,'prevkindvessel') ?>" name="prevkindvessel" style="width: 96%"/></td>
                    </tr>
                    <tr>
                        <td colspan="2">Kind of Engines <em><strong>(Engine Dept)</strong></em></td>
                        <td colspan="3"><input type="text" class="ab" id="prevkindengine" value="<?= _p($interview,'prevkindengine') ?>" name="prevkindengine" style="width: 96%"/></td>
                    </tr>
                    <tr>
                        <td colspan="2">Kind of Cargoes <em><strong>(Deck Dept)</strong></em></td>
                        <td colspan="3"><input type="text" class="ab" id="prevkindcargo" value="<?= _p($interview,'prevkindcargo') ?>" name="prevkindcargo" style="width: 96%"/></td>
                    </tr>
                    <tr>
                        <td colspan="2">Trade Route <em><strong>(Deck Dept)</strong></em></td>
                        <td colspan="3"><input type="text" class="ab" id="prevtraderoute" value="<?= _p($interview,'prevtraderoute') ?>" name="prevtraderoute" style="width: 96%"/></td>
                    </tr>
                    <tr>
                        <td colspan="2">Salaries Last 3 Vessels</td>
                        <td colspan="3"><input type="text" class="ab" id="prevsalary" value="<?= _p($interview,'prevsalary') ?>" name="prevsalary" style="width: 96%"/></td>
                    </tr>
                    <tr>
                        <td colspan="2">Experienced with Foreign Crew</td>
                        <td colspan="3"><input type="text" class="ab" id="prevforeignexp" value="<?= _p($interview,'prevforeignexp') ?>" name="prevforeignexp" style="width: 96%"/></td>
                    </tr>
                </table>

                <hr/>

                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Evaluation</th> 
                            <th width="35%">Observation</th>
                            <th width="15%">Grade</th>
                            <th width="30%">Remarks</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td style="vertical-align: top;">General Appearance</td>
                            <td style="vertical-align: top;">Features, Grooming, Nature/ Character and Attitude</td>
                            <td>
                                <select name="evalgrade1" class="ab" style="width: 96%">
                                    <option value="5" <?php echo ('5' == _p($interview,'evalgrade1'))? 'selected="selected"' : '' ?> >5 - Best</option>
                                    <option value="4" <?php echo ('4' == _p($interview,'evalgrade1'))? 'selected="selected"' : '' ?> >4 - Good</option>
                                    <option value="3" <?php echo ('3' == _p($interview,'evalgrade1'))? 'selected="selected"' : '' ?> >3 - Average</option>
                                    <option value="2" <?php echo ('2' == _p($interview,'evalgrade1'))? 'selected="selected"' : '' ?> >2 - Poor</option>
                                    <option value="1" <?php echo ('1' == _p($interview,'evalgrade1'))? 'selected="selected"' : '' ?> >1 - Worst</option>
                                </select>
                            </td>
                            <td><input type="text" class="ab" id="inputevalremark1" value="<?= _p($interview,'evalremark1') ?>" name="evalremark1" style="width: 96%"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td style="vertical-align: top;">Physical Condition</td>
                            <td style="vertical-align: top;">Height/Weight Ratio, Complex of face/eyes, Color Blindnes and Blood Pressure</td>
                            <td>
                                <select name="evalgrade2" class="ab" style="width: 96%">
                                    <option value="5" <?php echo ('5' == _p($interview,'evalgrade2'))? 'selected="selected"' : '' ?> >5 - Best</option>
                                    <option value="4" <?php echo ('4' == _p($interview,'evalgrade2'))? 'selected="selected"' : '' ?> >4 - Good</option>
                                    <option value="3" <?php echo ('3' == _p($interview,'evalgrade2'))? 'selected="selected"' : '' ?> >3 - Average</option>
                                    <option value="2" <?php echo ('2' == _p($interview,'evalgrade2'))? 'selected="selected"' : '' ?> >2 - Poor</option>
                                    <option value="1" <?php echo ('1' == _p($interview,'evalgrade2'))? 'selected="selected"' : '' ?> >1 - Worst</option>
                                </select>
                            </td>
                            <td><input type="text" class="ab" id="inputevalremark2" value="<?= _p($interview,'evalremark2') ?>" name="evalremark2" style="width: 96%"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td style="vertical-align: top;">Flexibility</td>
                            <td style="vertical-align: top;">Ability to Get along with Other Crew and Any Unfinished Contract</td>
                            <td>
                                <select name="evalgrade3" class="ab" style="width: 96%">
                                    <option value="5" <?php echo ('5' == _p($interview,'evalgrade3'))? 'selected="selected"' : '' ?> >5 - Best</option>
                                    <option value="4" <?php echo ('4' == _p($interview,'evalgrade3'))? 'selected="selected"' : '' ?> >4 - Good</option>
                                    <option value="3" <?php echo ('3' == _p($interview,'evalgrade3'))? 'selected="selected"' : '' ?> >3 - Average</option>
                                    <option value="2" <?php echo ('2' == _p($interview,'evalgrade3'))? 'selected="selected"' : '' ?> >2 - Poor</option>
                                    <option value="1" <?php echo ('1' == _p($interview,'evalgrade3'))? 'selected="selected"' : '' ?> >1 - Worst</option>
                                </select>
                            </td>
                            <td><input type="text" class="ab" id="inputevalremark3" value="<?= _p($interview,'evalremark3') ?>" name="evalremark3" style="width: 96%"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td style="vertical-align: top;">Self-Confidence</td>
                            <td style="vertical-align: top;">Total Year of Sea Carrier as Position-Applied and Times of Rehired Same Company</td>
                            <td>
                                <select name="evalgrade4" class="ab" style="width: 96%">
                                    <option value="5" <?php echo ('5' == _p($interview,'evalgrade4'))? 'selected="selected"' : '' ?> >5 - Best</option>
                                    <option value="4" <?php echo ('4' == _p($interview,'evalgrade4'))? 'selected="selected"' : '' ?> >4 - Good</option>
                                    <option value="3" <?php echo ('3' == _p($interview,'evalgrade4'))? 'selected="selected"' : '' ?> >3 - Average</option>
                                    <option value="2" <?php echo ('2' == _p($interview,'evalgrade4'))? 'selected="selected"' : '' ?> >2 - Poor</option>
                                    <option value="1" <?php echo ('1' == _p($interview,'evalgrade4'))? 'selected="selected"' : '' ?> >1 - Worst</option>
                                </select>
                            </td>
                            <td><input type="text" class="ab" id="inputevalremark4" value="<?= _p($interview,'evalremark4') ?>" name="evalremark4" style="width: 96%"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td style="vertical-align: top;">Evaluation</td>
                            <td style="vertical-align: top;">Any recommendation from Previous Crew/ Company or Level of his Skills/ Leadership</td>
                            <td>
                                <select name="evalgrade5" class="ab" style="width: 96%">
                                    <option value="5" <?php echo ('5' == _p($interview,'evalgrade5'))? 'selected="selected"' : '' ?> >5 - Best</option>
                                    <option value="4" <?php echo ('4' == _p($interview,'evalgrade5'))? 'selected="selected"' : '' ?> >4 - Good</option>
                                    <option value="3" <?php echo ('3' == _p($interview,'evalgrade5'))? 'selected="selected"' : '' ?> >3 - Average</option>
                                    <option value="2" <?php echo ('2' == _p($interview,'evalgrade5'))? 'selected="selected"' : '' ?> >2 - Poor</option>
                                    <option value="1" <?php echo ('1' == _p($interview,'evalgrade5'))? 'selected="selected"' : '' ?> >1 - Worst</option>
                                </select>
                            </td>
                            <td><input type="text" class="ab" id="inputevalremark5" value="<?= _p($interview,'evalremark5') ?>" name="evalremark5" style="width: 96%"/></td>
                        </tr>
                        <tr>
                            <td rowspan="5" style="vertical-align: top;">6</td>
                            <td rowspan="5" style="vertical-align: top;">Working Ability</td>
                            <td style="vertical-align: top;">1. For ISM/ISO Documentations <em><strong>(Engine Dept)</strong></em> <br/> 1. For ISM/ISO and MARPOL Regulations <em><strong>(Deck Dept)</strong></em></td>
                            <td>
                                <select name="evalgrade6a" class="ab" style="width: 96%">
                                    <option value="5" <?php echo ('5' == _p($interview,'evalgrade6a'))? 'selected="selected"' : '' ?> >5 - Best</option>
                                    <option value="4" <?php echo ('4' == _p($interview,'evalgrade6a'))? 'selected="selected"' : '' ?> >4 - Good</option>
                                    <option value="3" <?php echo ('3' == _p($interview,'evalgrade6a'))? 'selected="selected"' : '' ?> >3 - Average</option>
                                    <option value="2" <?php echo ('2' == _p($interview,'evalgrade6a'))? 'selected="selected"' : '' ?> >2 - Poor</option>
                                    <option value="1" <?php echo ('1' == _p($interview,'evalgrade6a'))? 'selected="selected"' : '' ?> >1 - Worst</option>
                                </select>
                            </td>
                            <td rowspan="5"><textarea name="evalremark6" class="ab" style="width: 96%; height: 225px;"><?= _p($interview,'evalremark6') ?></textarea></td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">2. For Regulation of MARPOL <em><strong>(Engine Dept)</strong></em> <br/> 2. For GMDSS System and Computer <em><strong>(Deck Dept)</strong></em></td>
                            <td>
                                <select name="evalgrade6b" class="ab" style="width: 96%">
                                    <option value="5" <?php echo ('5' == _p($interview,'evalgrade6b'))? 'selected="selected"' : '' ?> >5 - Best</option>
                                    <option value="4" <?php echo ('4' == _p($interview,'evalgrade6b'))? 'selected="selected"' : '' ?> >4 - Good</option>
                                    <option value="3" <?php echo ('3' == _p($interview,'evalgrade6b'))? 'selected="selected"' : '' ?> >3 - Average</option>
                                    <option value="2" <?php echo ('2' == _p($interview,'evalgrade6b'))? 'selected="selected"' : '' ?> >2 - Poor</option>
                                    <option value="1" <?php echo ('1' == _p($interview,'evalgrade6b'))? 'selected="selected"' : '' ?> >1 - Worst</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">3. For Engine Maintenance <em><strong>(Engine Dept)</strong></em> <br/> 3. For Navigation and Watchkeeping <em><strong>(Deck Dept)</strong></em></td>
                            <td>
                                <select name="evalgrade6c" class="ab" style="width: 96%">
                                    <option value="5" <?php echo ('5' == _p($interview,'evalgrade6c'))? 'selected="selected"' : '' ?> >5 - Best</option>
                                    <option value="4" <?php echo ('4' == _p($interview,'evalgrade6c'))? 'selected="selected"' : '' ?> >4 - Good</option>
                                    <option value="3" <?php echo ('3' == _p($interview,'evalgrade6c'))? 'selected="selected"' : '' ?> >3 - Average</option>
                                    <option value="2" <?php echo ('2' == _p($interview,'evalgrade6c'))? 'selected="selected"' : '' ?> >2 - Poor</option>
                                    <option value="1" <?php echo ('1' == _p($interview,'evalgrade6c'))? 'selected="selected"' : '' ?> >1 - Worst</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">4. For General Engine Trouble Shootings <em><strong>(Engine Dept)</strong></em> <br/> 4. For Char Readings, Light List, Pilot Book <em><strong>(Deck Dept)</strong></em></td>
                            <td>
                                <select name="evalgrade6d" class="ab" style="width: 96%">
                                    <option value="5" <?php echo ('5' == _p($interview,'evalgrade6d'))? 'selected="selected"' : '' ?> >5 - Best</option>
                                    <option value="4" <?php echo ('4' == _p($interview,'evalgrade6d'))? 'selected="selected"' : '' ?> >4 - Good</option>
                                    <option value="3" <?php echo ('3' == _p($interview,'evalgrade6d'))? 'selected="selected"' : '' ?> >3 - Average</option>
                                    <option value="2" <?php echo ('2' == _p($interview,'evalgrade6d'))? 'selected="selected"' : '' ?> >2 - Poor</option>
                                    <option value="1" <?php echo ('1' == _p($interview,'evalgrade6d'))? 'selected="selected"' : '' ?> >1 - Worst</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">5. For Engine Stores, Spares Control <em><strong>(Engine Dept)</strong></em><br/> 5. For Duties and Responsibilites <em><strong>(Deck Dept)</strong></em></td>
                            <td>
                                <select name="evalgrade6e" class="ab" style="width: 96%">
                                    <option value="5" <?php echo ('5' == _p($interview,'evalgrade6e'))? 'selected="selected"' : '' ?> >5 - Best</option>
                                    <option value="4" <?php echo ('4' == _p($interview,'evalgrade6e'))? 'selected="selected"' : '' ?> >4 - Good</option>
                                    <option value="3" <?php echo ('3' == _p($interview,'evalgrade6e'))? 'selected="selected"' : '' ?> >3 - Average</option>
                                    <option value="2" <?php echo ('2' == _p($interview,'evalgrade6e'))? 'selected="selected"' : '' ?> >2 - Poor</option>
                                    <option value="1" <?php echo ('1' == _p($interview,'evalgrade6e'))? 'selected="selected"' : '' ?> >1 - Worst</option>
                                </select>
                            </td>
                        </tr>                        
                        <tr>
                            <td style="vertical-align: top;" rowspan="2">7</td>
                            <td style="vertical-align: top;" rowspan="2">Final Evaluation</td>
                            <td style="vertical-align: top;">Total Evaluation</td>
                            <td colspan="2"><input type="text" class="ab" id="evalgrade7a" value="<?= _p($interview,'evalgrade7a') ?>" name="evalgrade7a" style="width: 96%"/></td>
                        </tr>                    
                        <tr>
                            <td style="vertical-align: top;">Average Evaluation</td>
                            <td colspan="2"><input type="text" class="ab" id="evalgrade7b" value="<?= _p($interview,'evalgrade7b') ?>" name="evalgrade7b" style="width: 96%"/></td>
                        </tr>
                    </tbody>                            
                </table>
                <hr/>
                <table class="responsive-table">
                    <tr>
                        <th>Grade</th>
                        <td>5 - Best</td>
                        <td>4 - Good</td>
                        <td>3 - Average</td>
                        <td>2 - Poor</td>
                        <td>1 - Worst</td>
                    </tr>
                </table>
                <hr/>
                <table class="responsive-table">
                    <tr>
                        <td>Recommendation</td>
                        <td><input type="text" class="ab" id="recommendation" value="<?= _p($interview,'recommendation') ?>" name="recommendation" style="width: 96%"/></td>
                        <td>Good for Vessel MV/MT</td>
                        <td><input type="text" class="ab" id="goodforvessel" value="<?= _p($interview,'goodforvessel') ?>" name="goodforvessel" style="width: 96%"/></td>
                     </tr>
                </table>
                <hr/>
                <table class="responsive-table">
                    <tr>
                        <th>1st Interviewed by:</th>
                        <th>Checked by:</th>
                        <th>Approved by:</th>
                    </tr>
                    <tr>
                        <td><input type="text" class="ab" id="interviewby" value="<?= _p($interview,'interviewby') ?>" name="interviewby" style="width: 96%" placeholder="Interviewed by"/></td>
                        <td><input type="text" class="ab" id="checkedby" value="<?= _p($interview,'checkedby') ?>" name="checkedby" style="width: 96%" placeholder="Checked by"/></td>
                        <td><input type="text" class="ab" id="approvedby" value="<?= _p($interview,'approvedby') ?>" name="approvedby" style="width: 96%" placeholder="Approved by"/></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        <?php if($crew_id): ?>
            var interviewcollection = new Interviewcollection();
            interviewcollection.id = <?= (_p($interview,'id'))? _p($interview,'id') : 0 ?>; 
            interviewcollection.crew_id = <?php echo $crew_id; ?>; 
            var interviewView = new InterviewView({collection: interviewcollection});
        <?php endif; ?>


         $("#tentative_sched").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"}); 
         $("#datecreated").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"}); 
    });
</script>

<script type="text/template" id="alertInterviewTemplate">
    <div class="alert alert-<%= type %>">
        <button class="close" data-dismiss="alert" type="button">×</button>
        <%= message %>
    </div>
</script>
