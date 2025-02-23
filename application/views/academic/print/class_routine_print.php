                                <?php
                                $toggle = true;
                                $dayarray=array('1'=>'sunday','2'=>'monday','3'=>'tuesday','4'=>'wednesday','5'=>'thursday','6'=>'friday','7'=>'saturday');
                                foreach ($classes as $row):
                                    $secm = explode('-', $row->section);
                                    if (!empty($row->section) && count($secm) > 0) {
                                        foreach ($secm as $sec):
                                            $sec_name = '';
                                            $sec_namedash = '';
                                            $sec_nameid = $row->id;
                                            if ($sec != '') {
                                                $sec_name = $sectionname[$sec];
                                                $sec_namedash ="-".$sec_name;
                                                $sec_nameid =$row->id . $sec;
                                            }
                                            ?>

                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a style="font-size: 20px;padding: 7px 420px 8px 2px;" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $sec_nameid;?>">
                                                            
                                                            <i class="icon-rss icon-1x"></i> Class <?php echo $row->class_name . '-' . $sec_name; ?>
                                                            <?php
                                                            
                                                            $clid = $row->id;
                                                            if (!empty($teachername[$clid][$sec])) {
                                                                ?>
                                                                <span  style="font-size: 14px;padding-left:5px"><span style="font-weight: bold;">Class Teacher :&nbsp;</span><?php echo $teachername[$clid][$sec]; ?></span>
                                                            <?php } else { ?>
                                                                <span  style="font-size: 14px;padding-left:5px"><span style="font-weight: bold;">Class Teacher :&nbsp;</span>N/A</span>
                                                            <?php } ?>
                                                                
                                                                
                                                        </a>
                                                    </h4>
                                                    
                                                </div>

                                                <div id="collapse<?php echo $row->id . $sec; ?>" class="panel-collapse collapse <?php if ($toggle) { echo 'in'; $toggle = false;}?> " >
                                                    <div class="panel-body  table-responsive" style="width:90%">
                                                        <table  class="table table-striped table-bordered table-hover" style="width:90%">
                                                            <thead style="background: yellowgreen">
                                                                <tr>
                                                                    <th>Time<br/>Day</th>
                                                                    <?php foreach ($period as $per_value) { ?>
                                                                        <th><?php echo $per_value->name; ?><br/>(<?php echo $per_value->time_start; ?>:<?php echo $per_value->time_start_min; ?> - <?php echo $per_value->time_end; ?>:<?php echo $per_value->time_end_min; ?>)</th>
                                                                    <?php } ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>                                                           

                                                                <?php for ($d = 1; $d <= 7; $d++) {?>
                                                                    <?php if($dayarray[$d]!='sunday'){ ?>
                                                                    <tr class="gradeA">
                                                                        <th width="100" style="background: #d6f793;"><?php echo strtoupper($dayarray[$d]); ?></th>
                                                                            <?php foreach ($period as $per_valu) { ?>
                                                                            <td>  
                                                                                <?php if ($dayarray[$d] == 'sunday') { 
                                                                                    echo 'Holiday';
                                                                                } else {
                                                                                     $pid = $per_valu->id;
                                                                                    $clsid = $row->id;

                                                                                    $rows = $this->dbconnection->GetRoutinedata($pid, $dayarray[$d], $clsid, $sec,$academic_session);                                                                 
                                                                                    $co = count($rows);
                                                                                    if ($co > 0) {
                                                                                        ?>
                                                                                        <div class="btn-group">
                                                                                            <button class="btn btn-info" data-toggle="dropdown" style="height: 96px;width: 160px;">
                                                                                                <b>
                                                                                                <?php echo $newtext1 = wordwrap($rows[0]['name'], 10); ?>
                                                                                                </b>
                                                                                                <br>
                                                                                                <i>
                                                                                                <?php if ($rows[0]['tname']) { ?>

                                                                                                    (<?php echo $newtext = wordwrap($rows[0]['tname'], 5); ?>)
                                                                                                <?php
                                                                                                } else {
                                                                                                    echo '(N/A)';
                                                                                                }
                                                                                                ?>
                                                                                                </i>
                                                                                            </button>
                                                                                            
                                                                                        </div>
                                                                                        <?php
                                                                                    } else {
                                                                                        echo '--';?>
                                                                                         
                                                                                    <?php }
                                                                                    ?>
                                                                                <?php } ?>    

                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                <?php }} ?>
                                                            </tbody>
                                                        </table>                                        
                                                    </div>
                                                </div>
                                            </div>


                                <?php endforeach; ?>

                                <?php } 
                                 
                                endforeach; 
                                      ?>