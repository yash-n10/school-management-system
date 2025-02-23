<div class="col-md-12">
    <div class="table-responsive" >    
       <!--<form enctype='multipart/form-data' id='form' class="form-horizontal" action="" method='post'>
                 <div class="box-body">
                    <div class="col-lg-3">Select CSV File to upload</div>
                    <div class="col-lg-3">
                        <input class="form-control" size='50' type='file' name='attendance_upload' required>
                    </div>
                    <div class="col-lg-2"><input type='submit' class="btn btn-success" name='submit' id='submit' value='Upload'></div>
                </div>
            </form> -->
           <table id="studentloadtbl" class="table table-bordered table-stripped" width="100%">
               <thead>
                   <tr  style="background-color:#00c0ef">
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u> Sl no </u></th>
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u> Stud Id </u></th>
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 80px; padding: 0px;"> <u> Admission No </u></th>
                    <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 150px;"> <u> Student Name </u></th>
                     <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 150px;"> <u> Roll No. </u></th>
                    
                    <th colspan= "<?php echo $total_days ?>" style="vertical-align: middle; text-align: center;"><u> Month </u></th> 
                   
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
               </thead>

                <input type="hidden" value="<?php echo $total_days?>" name="total_days">
               <tbody>
		   <?php $count=0; $k=1; foreach($fetch_stud_attendance_report as $stud) {
		 ?>
                   <tr>
                      <input type="hidden" value="<?php echo $stud->id?>" name="astud_id[]">
                      <input type="hidden" value="<?php echo $stud->admission_no?>" name="admission_no[]">
                      <input type="hidden" value="<?php echo $stud->roll?>" name="roll[]">
                      <input type="hidden" value="<?php echo $stud->class_id?>" name="class[]">
                      <input type="hidden" value="<?php echo $stud->section_id?>" name="section[]">
                       <td style=""><?php echo $k; ?></td>
                       <td style=""><?php echo $stud->id;?> </td>
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
                           ?>

                             <td style="<?php if(in_array($i,$each_sunday)){?> background:#3F51B5; <?php } ?>"><?php
                      
                         if(in_array($i,$each_sunday)){
                            echo '<select class="form-control" id="attendance" name="attendance['.$i.']['.$stud->id.']" style="pointer-events: none;"> 
                                <option value="S">S</option>  
                            </select>';
                        }
                      
                        else
                        { 
                        	echo '<select class="form-control" id="attendance" name="attendance['.$i.']['.$stud->id.']"> 
		                                <option value="P">P</option>          
		                                
		                            </select>' ;
                        } ?></td>
                      
                       <input type="hidden" value="<?php echo  $datee ?>" name="atten_date[]">
                        
                       <?php }
                        ?>
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
            dom: 'lfBrtip',
            
                 buttons: [
                                {
                                    extend: 'collection',
                                    text: 'Download Format',
                                    className: 'red',
                                    buttons: [
                                        'csv'
                                        
                                    ]
                                }
                            ],
            
        } );


} );
</script>