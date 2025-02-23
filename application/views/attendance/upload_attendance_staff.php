<div class="col-md-12">
               
    <div class="table-responsive">
           <table id="student" class="table table-bordered table-stripped table-responsive">
               <thead>
                   <tr  style="background-color:#dcedc8">
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u> Sl no </u></th>
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width:80px;"> <u> Employee Code </u></th>
                    <!--<th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u> Category </u></th>-->
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width:150px;"> <u> Employee Name </u></th>
                    
                    <th colspan= "<?php echo $total_days ?>" style="vertical-align: middle; text-align: center;"><u> Month </u></th> 
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width:80px;"> <u>Total Present </u></th>
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width:80px;"> <u>Total Absent </u></th>
                    <!--<th style="width:9px; background-color: white;"></th>-->
                   </tr>
                   <tr style="background-color:#e1bee7"> 
                   <?php for($day=1; $day<=$total_days; $day++) { ?>
                        <th style=""> <?php echo date('D',strtotime("$yr-$month-$day")); ?> </th>
                       <?php  }?>
                   </tr>
                   
                   <tr style="background-color:#fce4ec">
                       <?php for($date=1; $date<=$total_days; $date++) { ?>
                        <th style="<?php if(in_array($date,$each_sunday)){?> background:#ffcc80; <?php } ?>"> <?php echo $date; ?> </th>
                       <?php  } ?>
                   </tr>
               </thead>
               
               <tbody>
		   <?php $count=0; $a=1; foreach($fetch_staff_attendance_report as $staff) { ?>
                   <tr>
<!--                       <input type="hidden" value="<?php // echo $yr;?>" name="astud_id[]">-->
                       <td style="width:50px;"><?php echo $a; ?></td>
                       <td style="width:50px;"><?php echo $staff->employee_code; ?></td>
                       <td style="width:150px !important;"><?php echo $staff->name;?></td>
                      
                       <?php for($b=1; $b<=$total_days; $b++) {
                           
                        $qry=$this->dbconnection->select("staff_attendance", "attendance", "emp_no=$staff->id and date='$yr-$month-$b'");?>
                        <td style="<?php if(in_array($b,$each_sunday)){?> background:#ffcc80; <?php } ?> width:5px; ">
                                        <?php if(count($qry)>0)
                                            {
                                                echo $qry[0]->attendance;
                                                if($qry[0]->attendance=='P')
                                                    { $count++;}
                                            } 
                                            else if(in_array($b,$each_sunday)){
                                                echo '';
                                            }
                                            else if($qry[0]->attendance=='HF'){
                                                echo 'HF';
                                            }
                                            else { echo 'A';} ?>
                        </td>
                        
                       <?php }  ?>
                       <td style="width:50px;"><?php echo $count;?></td>
                       <td style="width:50px;"><?php echo ($total_work-$count);?></td>
                   </tr>
                  <?php  $a++; $count=0; } ?>
               </tbody>
           </table>
    </div>
</div>


<script>
    $(document).ready(function () {

        var table = $('#student').DataTable({
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "searching": true

        });


    });


</script>
