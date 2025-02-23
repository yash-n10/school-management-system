<div class="col-md-12">
    <div class="table-responsive" >    
           <table id="studentloadtbl" class="table table-bordered table-stripped" width="100%">
               <thead>
                   <tr  style="background-color:#00c0ef">
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u> Sl no </u></th>
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 80px; padding: 0px;"> <u> Admission No </u></th>
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 150px;"> <u> Student Name </u></th>
                     <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 150px;"> <u> Roll No. </u></th>
                    
                    <th colspan= "<?php echo $total_days ?>" style="vertical-align: middle; text-align: center;"><u> Month </u></th> 
                    <!-- <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 80px; padding: 0px;"> <u>Total Present </u></th>
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 80px; padding: 0px;"> <u>Total Absent </u></th> -->
                    <!--<th style="width:9px; background-color: white;"></th>-->
                   </tr>
                   <tr style="background-color:#ffcc80"> 
                   <?php for($n=1; $n<=$total_days; $n++) { ?>
                        <th style=""><?php echo date('D',strtotime("$yr-$month-$n")); ?></th>
                       <?php  }?>
                   </tr>
                   
                   <tr style="background-color:#8BC34A">
                       <?php for($j=1; $j<=$total_days; $j++) { ?>
                        <th style="<?php if(in_array($j,$each_sunday)){?> background:#3F51B5; <?php } ?>"> <?php echo $j; ?> </th>
                        	
                       <?php  }?>
                   </tr>
                 <!--  <tr style="background-color:#8BC34A">
                       <?php for($j=1; $j<=$total_days; $j++) { ?>
                        <th style="<?php if(in_array($j,$each_holiday)){?> background:#3F51B5; <?php } ?>"> <?php echo $j; ?> </th>
                       <?php  }?>
                   </tr> --> 
               </thead>

                <input type="hidden" value="<?php echo $total_days?>" name="total_days">
               <tbody>
		   <?php $count=0; $k=1; foreach($fetch_stud_attendance_report as $stud) {
		   	// echo '<pre>';
		   	// print_r($stud);
		 ?>
                   <tr>
                      <input type="hidden" value="<?php echo $stud->id?>" name="astud_id[]">
                      <input type="hidden" value="<?php echo $stud->admission_no?>" name="admission_no[]">
                      <input type="hidden" value="<?php echo $stud->roll?>" name="roll[]">
                      <input type="hidden" value="<?php echo $stud->class_id?>" name="class[]">
                      <input type="hidden" value="<?php echo $stud->section_id?>" name="section[]">
                       <td style=""><?php echo $k; ?></td>
                       <td style=""><?php echo $stud->admission_no;?> </td>
                       <td style=""><?php echo $stud->name;?></td>
                       <td style=""><?php echo $stud->roll;?></td>
                      
                       <?php
                        
                       for($i=1; $i<=$total_days; $i++) {

                            $cdate=date("Y-m-d");
                        	  $datee=$i;
                            $dateee=$month;
                            $dateeee=$yr;
                            $adate=$dateeee.'-'.$dateee.'-'.$datee;
                            $currmon=date("m");
              							$curryear=date("Y");
              							$currdate=date("d");


                            
                           $qry=$this->db->query("select h.id,h.class_id,h.section_id,h.month,d.atten_date,d.adm_no,d.stud_id,d.roll,d.attendance from stud_mnthly_att_head h,stud_mnthly_att_detail d where h.id=d.mnthly_att_head_id and h.month=$dateee and d.stud_id=$stud->id and h.status='Y' and h.class_id=$stud->class_id and h.section_id=$stud->section_id and d.atten_date=$datee")->result();

                           $qry1=$this->db->query("select count(h.id)cnt,h.id,h.class_id,h.section_id,h.month,d.adm_no,d.atten_date,d.stud_id,d.roll,d.attendance from stud_mnthly_att_head h,stud_mnthly_att_detail d where h.id=d.mnthly_att_head_id and h.month=$dateee and d.stud_id=$stud->id and h.status='Y' and d.attendance='P' and h.class_id=$stud->class_id and h.section_id=$stud->section_id ")->result();
                           	// echo '<pre>';
                           	// print_r($qry);
                           ?>

                           	<input type="hidden" value="<?php echo $qry[0]->id?>" name="head_id">	
                             <td style="<?php if(in_array($i,$each_sunday)){?> background:#3F51B5; <?php } ?>"><?php if(count($qry)>0){ ?>
                     			<?php if(in_array($i,$each_sunday)){?>
                     			<p style=color:white;writing-mode: horizontal;text-orientation:upright;><b>SUNDAY</b></p>
                     		<?php } else { ?>
                              	<select class="form-control" id="attendance" name="attendance[<?= $i;?>]['<?= $stud->id;?>']"> 
                                <option value="P" <?php if ($qry[0]->attendance == "P") { echo "selected=selected";} ?>>P</option>          
                                <option value="A" <?php if ($qry[0]->attendance == "A") { echo "selected=selected";} ?>>A</option>
                                <!-- <option value="" ><?php echo $qry[0]->attendance; ?></option> -->
                            </select>
                          <?php }
                        }
                      
                        else if(in_array($i,$each_sunday)){
                            // echo '<p style=color:white;writing-mode: horizontal;text-orientation:upright;><b>SUNDAY</b></p>';
                            echo '<select class="form-control" id="attendance" name="attendance['.$i.']['.$stud->id.']" style="pointer-events: none;"> 
                                <option value="S">SUNDAY</option>  
                            </select>';
                        }
                      
                        else
                        { 
                        	echo ' 	<select class="form-control" id="attendance" name="attendance['.$i.']['.$stud->id.']"> 
		                                <option value="P">P</option>          
		                                <option value="A">A</option>
		                            </select>' ;
                        } ?></td>
                      
                       <input type="hidden" value="<?php echo  $datee ?>" name="atten_date[]">
                        
                       <?php }
                        ?>
                      	<!-- <td style=""><?php echo $qry1[0]->cnt;?></td>
                       	<td style=""><?php echo $total_days;?></td> -->
                   </tr>
                  <?php    $k++; $count=0;} ?>
               </tbody>
           </table>
    </div>
</div>
<script>
    $(document).ready(function() {

        var table =$('#studentloadtbl').DataTable( {   
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging":         false,
            "searching":true,
            // dom: 'lfBrtip',
            
            //      buttons: [
            //                     {
            //                         extend: 'collection',
            //                         text: 'Download Format',
            //                         className: 'red',
            //                         buttons: [
            //                             'csv'
                                        
            //                         ]
            //                     }
            //                 ],
            
        } );


} );
</script>