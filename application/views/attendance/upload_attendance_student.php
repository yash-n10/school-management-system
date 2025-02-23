<div class="col-md-12">
  <button type="button" class="btn btn-success">P-PRESENT</button>
  <button type="button" class="btn btn-danger">A-ABSENT</button>
  <button type="button" class="btn btn-warning">S-SUNDAY</button>
    <div class="table-responsive">    
        <table id="student123" class="table table-bordered table-stripped" width="100%">
          <thead>
            <tr  style="background-color:#dcedc8">
                <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd;"> <u> Sl no </u></th>
                <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 80px; padding: 0px;"> <u> Admission No </u></th>
                <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 150px;"> <u> Student Name </u></th>                    
                <th colspan= "<?php echo $total_days ?>" style="vertical-align: middle; text-align: center;"><u> Month </u></th> 
                <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 80px; padding: 0px;"> <u>Total Present </u></th>
                <th rowspan="3" style="vertical-align: middle; text-align: center; border-right-color: #bdbdbd; width: 80px; padding: 0px;"> <u>Total Absent </u></th>
            </tr>
             <tr style="background-color:#e1bee7"> 
             <?php for($n=1; $n<=$total_days; $n++) { ?>
                  <th style=""><?php echo date('D',strtotime("$yr-$month-$n")); ?></th>
                 <?php  }?>
             </tr>
                   
              <tr style="background-color:#fce4ec">
                 <?php for($j=1; $j<=$total_days; $j++) { ?>
                  <th style="<?php if(in_array($j,$each_sunday)){?> background:#ffcc80; <?php } ?>"> <?php echo $j; ?> </th>
                 <?php  }?>
              </tr>
          </thead>
               
         <tbody style="text-align: center;">
            <?php $count=0; $k=1; foreach($fetch_stud_attendance_report as $stud) { ?>
             <tr>
                <td style=""><?php echo $k; ?></td>
                <td style=""><?php echo $stud->admission_no;?> </td>
                <td style=""><?php echo $stud->name;?></td>
                      
                 <?php                
                 for($i=1; $i<=$total_days; $i++) {
                     $qry=$this->db->query("select t1.month,t2.attendance,t2.adm_no,t2.periods from stud_mnthly_att_head t1 ,stud_mnthly_att_detail t2 where t2.stud_id=$stud->id and t1.month=$month and t2.atten_date=$i and t1.id=t2.mnthly_att_head_id and t1.status='Y'")->result();

                     ?>
                     <td style="<?php if(in_array($i,$each_sunday)){?> background:#ffcc80; <?php } ?>"><?php if(count($qry)>0){echo '<span style="color:#3c8dbc">'.$qry[0]->attendance.'</span>' ;
                       echo "<br>"; print_r($qry[0]->periods);
                        if($qry[0]->attendance=='P')
                            { $count++; }
                        } 
                        else if(in_array($i,$each_sunday)){
                            echo '';
                        }
                        else { echo '';} ?></td>
                       <?php 
                       
                       
                        }
                        ?>
               


               <td style=""><?php echo $count;?></td>
               <td style=""><?php echo ($total_work-$count);?></td>
            </tr>
                  <?php    $k++; $count=0;} ?>
        </tbody>
      </table>
    </div>
</div>
<script>
    $(document).ready(function() {

        var table =$('#student123').DataTable( {   
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "searching":true,
             dom: 'lfBrtip',
            
                 buttons: [
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    className: 'red',
                                    buttons: [
                                        'excel',
                                        'csv',
                                        {
                                            extend: 'pdf',
                                            orientation: 'landscape',
                                            pageSize: 'A3'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'landscape',
                                            pageSize: 'A3'
                                        },
                                    ]
                                }
                            ],
            
        } );


} );
</script>
