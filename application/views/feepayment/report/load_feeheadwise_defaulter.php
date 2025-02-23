<style>
    .dt-button.red {
        color: darkgreen;
        font-weight: bold;
    }
</style>
<form id="frmstudent3" role="form" method="POST">

       <div class="table-responsive">
        <table id="studentlist3" class="table table-bordered table-striped">
            <thead>
                <tr> 
                    <th rowspan="2" style="border-bottom:1px solid black;"> Sl No.</th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Adm No.</th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Student Name</th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Class-Sec </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Fee Category</th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Mobile No </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Annual </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Month </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> Transport </th>
                    <?php if($trans_status=='YES'){?>
            <th colspan="<?php echo count($fee_ty)+3;?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }else{?>
            <th colspan="<?php echo count($fee_ty)+2;?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
            <?php }?>
            
            <th rowspan="2" style="border-bottom:1px solid black;"> Total Amount</th>
                </tr> 
                <tr>
                    <?php $total_fee_amt_wise=array();foreach($fee_ty as $d=>$v) {
                        $total_fee_amt_wise[$d]=0;?>
                    <th style="border-bottom:1px solid black;"> <?php echo $v; ?> </th>
                        <?php } ?>
                    <?php if($trans_status=='YES'){?>
                     <th style="border-bottom:1px solid black;"> Transport Fee </th>
                      <?php }?>
                     
                </tr>
             </thead>
             <tbody id="monthlyfees_load_td">
             <?php $i=1;
             $totsum=0;
                foreach ($query_defaulter as $row) {

                $clasfeehead = $this->db->query("select id from class_fee_head where from_class_id<=$row->class_id and to_class_id>=$row->class_id and course=$row->course_id and status='Y' and year<=$this->session_start_yr order by id desc limit 1")->result_array();            

                    if ($row->annual == 'Paid' || $row->annual == '') {
                        $anns = 0;
                    } else {
                        $anns = $sfees[$row->stud_category][$clasfeehead[0]['id']]['ann'];
                    }

                    if ($row->monthly == 'Paid' || $row->monthly == '') {
                        $mons = 0;
                        $h = '';
                    } else {
                    $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
                    $this->data['schoolgrp'] = $schoolgrp;
                    if($schoolgrp=='ARMY'){
                         $f = explode(' ', $row->monthly);

                    $mons = $f[0] * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon']/3;
                    $mn = $month - ($row->monthly - 1);
                    if ($month_arr[$mn] == $month_arr[$month]) {
                        $h = ' months (' . $month_arr[$mn] . ')';
                    } else {
                        $h = ' months (' . $month_arr[$mn] . ' to ' . $month_arr[$month] . ')';
                    }
                    }
                    else{
                        $f = explode(' ', $row->monthly);
                    $mons = $f[0] * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                    $mn = $month - ($row->monthly - 1);
                    if ($month_arr[$mn] == $month_arr[$month]) {
                        $h = ' months (' . $month_arr[$mn] . ')';
                    } else {
                        $h = ' months (' . $month_arr[$mn] . ' to ' . $month_arr[$month] . ')';
                    }
                    }
                   
                    }
                     $sum_fees = $mons + $anns + ($row->transport_amt * $row->monthly);
                     $annual_fees =  $monthly_fees = 0; 
                     $annual_fees   =  $sfees[$row->stud_category][$clasfeehead[0]['id']]['ann'];
                     $monthly_fees  =  $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                     $total_monthly_amount = $mons;

              ?>       
              <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $row->admission_no; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><?php echo $row->class_name.'-'.$row->sec_name; ?></td>
                  <td><?php echo $row->cat_code; ?></td>
                  <td><?php echo $row->phone; ?></td>
                  <td><?php echo $row->annual; ?></td>
                  <td><?php echo $row->monthly . $h; ?></td>
                  <td><?php echo $row->transport_amt * $row->monthly; ?></td>
                    <?php if($trans_status=='YES'){?>
            <td colspan="<?php echo count($fee_ty)+3;?>" style="text-align: center;">
            <?php }else{?>
            <td colspan="<?php echo count($fee_ty)+2;?>" style="text-align: center;">
        <?php } ?> 
                <!--   <td><?php echo $total_monthly_amount ? $total_monthly_amount:'0';?></td> -->
                 
                  <td><?php echo $sum_fees; ?></td>                
              </tr>
              <?php $i++;} ?>


             </tbody>
        </table>
        
       </div>
    </form>
<script>
    var table=$('#studentlist3').DataTable(
            {
                         dom: 'Bfrtip',
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
                                            pageSize: 'A2'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'landscape',
                                            pageSize: 'A2'
                                        },
                                    ]
                                }
                            ]

                            
            });
        
    
    </script>