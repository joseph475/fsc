<div class="accordion-group row-section">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#registration-module" href="#interview-info">
        <div class="row-title">INTERVIEW REPORT</div> 
    </a>

    <div id="interview-info" class="accordion-body collapse">
        <div class="row-details">            
            <div id="myTabContent" class="tab-content">     

                <?php if(is_allowed(getclass($clssnme, FALSE, 5))): ?>
                <a href="<?= site_url("crew-interview/" . $hash) ?>" target="_blank" id="interview-btn" class="btn btn-default" >Generate Report</a>
                <?php endif; ?>        
                <div class="clearfix" style="margin-bottom: 20px;"></div> 

                <table class="responsive-table">
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td><strong>Date</strong></td>
                        <td><?= date('F d, Y') ?></td>
                    </td>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><?= isset($fullname)? $fullname : '' ?></td>    
                        <td><strong>Rank</strong></td>
                        <td width="15%"><?= _p($interview,'rank_interview') ?></td>  
                        <td><strong>Age</strong></td>
                        <td width="15%"><?= _p($interview, 'age') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Assigned Vessel</strong></td>
                        <td><?= _p($interview,'vesselname_interview') ?></td>    
                        <td><strong>Tentative Schedule</strong></td>
                        <td colspan="3"><?= _p($interview,'tentative_sched') ?></td>
                    </tr>
                    <tr>
                        <td rowspan="6" style="vertical-align: top;"><strong>Previous Vessels</strong></td>
                        <td colspan="2"><strong>Kind of Vessels</strong></td>
                        <td colspan="3"><?= _p($interview,'prevkindvessel') ?></td>
                    </tr>
                    <?php if(_p($interview,'vesseltype') == 'Engine'): ?>
                    <tr>
                        <td colspan="2"><strong>Kind of Engines</strong></td>
                        <td colspan="3"><?= _p($interview,'prevkindengine') ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if(_p($interview,'vesseltype') == 'Deck'): ?>
                    <tr>
                        <td colspan="2"><strong>Kind of Cargoes</strong></td>
                        <td colspan="3"><?= _p($interview,'prevkindcargo') ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Trade Route</strong></td>
                        <td colspan="3"><?= _p($interview,'prevtraderoute') ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="2"><strong>Salaries Last 3 Vessels</strong></td>
                        <td colspan="3"><?= _p($interview,'prevsalary') ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Experienced with Foreign Crew</strong></td>
                        <td colspan="3"><?= _p($interview,'prevforeignexp') ?></td>
                    </tr>
                </table>

                <hr/>

                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Evaluation</th> 
                            <th width="35%">Observation</th>
                            <th width="8%"><center>Grade</center></th>
                            <th width="30%">Remarks</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td style="vertical-align: top;">General Appearance</td>
                            <td style="vertical-align: top;">Features, Grooming, Nature/ Character and Attitude</td>
                            <td><center><?= _p($interview,'evalgrade1') ?></center></td>
                            <td><?= _p($interview,'evalremark1') ?></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td style="vertical-align: top;">Physical Condition</td>
                            <td style="vertical-align: top;">Height/Weight Ratio, Complex of face/eyes, Color Blindnes and Blood Pressure</td>
                            <td><center><?= _p($interview,'evalgrade2') ?></center></td>
                            <td><?= _p($interview,'evalremark2') ?></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td style="vertical-align: top;">Flexibility</td>
                            <td style="vertical-align: top;">Ability to Get along with Other Crew and Any Unfinished Contract</td>
                            <td><center><?= _p($interview,'evalgrade3') ?></center></td>
                            <td><?= _p($interview,'evalremark3') ?></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td style="vertical-align: top;">Self-Confidence</td>
                            <td style="vertical-align: top;">Total Year of Sea Carrier as Position-Applied and Times of Rehired Same Company</td>
                            <td><center><?= _p($interview,'evalgrade4') ?></center></td>
                            <td><?= _p($interview,'evalremark4') ?></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td style="vertical-align: top;">Evaluation</td>
                            <td style="vertical-align: top;">Any recommendation from Previous Crew/ Company or Level of his Skills/ Leadership</td>
                            <td><center><?= _p($interview,'evalgrade5') ?></center></td>
                            <td><?= _p($interview,'evalremark5') ?></td>
                        </tr>
                        <tr>
                            <td rowspan="5" style="vertical-align: top;">6</td>
                            <td rowspan="5" style="vertical-align: top;">Working Ability</td>
                            <td style="vertical-align: top;"><?= (_p($interview,'vesseltype') == 'Engine')? '1. For ISM/ISO Documentations' : '1. For ISM/ISO and MARPOL Regulations' ?></td>
                            <td><center><?= _p($interview,'evalgrade6a') ?></center></td>
                            <td rowspan="5"><?= _p($interview,'evalremark6') ?></td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;"><?= (_p($interview,'vesseltype') == 'Engine')? '2. For Regulation of MARPOL' : '2. For GMDSS System and Computer' ?></td>
                            <td><center><?= _p($interview,'evalgrade6b') ?></center></td>                            
                        </tr>
                        <tr>
                            <td style="vertical-align: top;"><?= (_p($interview,'vesseltype') == 'Engine')? '3. For Engine Maintenance' : '3. For Navigation and Watchkeeping' ?></td>
                            <td><center><?= _p($interview,'evalgrade6c') ?></center></td>                            
                        </tr>
                        <tr>
                            <td style="vertical-align: top;"><?= (_p($interview,'vesseltype') == 'Engine')? '4. For General Engine Trouble Shootings' : '4. For Char Readings, Light List, Pilot Book' ?></td>
                            <td><center><?= _p($interview,'evalgrade6d') ?></center></td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;"><?= (_p($interview,'vesseltype') == 'Engine')? '5. For Engine Stores, Spares Control' : '5. For Duties and Responsibilites' ?></td>
                            <td><center><?= _p($interview,'evalgrade6e') ?></center></td>
                        </tr>                        
                        <tr>
                            <td style="vertical-align: top;" rowspan="2">7</td>
                            <td style="vertical-align: top;" rowspan="2">Final Evaluation</td>
                            <td style="vertical-align: top;">Total Evaluation</td>
                            <td colspan="2"><?= _p($interview,'evalgrade7a') ?></td>
                        </tr>                    
                        <tr>
                            <td style="vertical-align: top;">Average Evaluation</td>
                            <td colspan="2"><?= _p($interview,'evalgrade7b') ?></td>
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
                        <td><?= _p($interview,'recommendation') ?></td>
                        <td>Good for Vessel MV/MT</td>
                        <td><?= _p($interview,'goodforvessel') ?></td>
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
                        <td><?= _p($interview,'interviewby') ?></td>
                        <td><?= _p($interview,'checkedby') ?></td>
                        <td><?= _p($interview,'approvedby') ?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>
