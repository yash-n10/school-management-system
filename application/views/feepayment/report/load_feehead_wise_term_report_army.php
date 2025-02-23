<style>
    .dt-button.red 
    {
        color: darkgreen;
        font-weight: bold;
    }
</style>
<form id="frmstudent4" role="form" method="POST">
    <div class="table-responsive">
        <table id="studentlist4" class="table table-bordered table-striped">
            <thead>
                <tr> 
                    <th rowspan="2" style="border-bottom:1px solid black;"> TRANSACTION DATE </th>                
                    <?php 
                    if ($trans_status == 'YES') 
                    { 
                    ?>
                        <th colspan="<?php echo count($fee_ty) + 2 ?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
                    <?php 
                    } 
                    else 
                    { 
                    ?>
                        <th colspan="<?php echo count($fee_ty) + 1 ?>" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
                    <?php 
                    } 
                    ?>
                    <!--<th rowspan="2" style="border-bottom:1px solid black;"> TOTAL FEE </th>-->
                    <th rowspan="2" style="border-bottom:1px solid black;"> Instant Discount </th>
                    <th rowspan="2" style="border-bottom:1px solid black;"> TOTAL AMOUNT </th>
                    <th colspan="<?php echo count($paymodeqry);?>" style="text-align: center;border-bottom:1px solid black"> Mode</th>
                </tr> 
                <tr>
                    <?php 
                    $total_fee_amt_wise = array();
                    foreach ($fee_ty as $d => $v) 
                    {
                        $total_fee_amt_wise[$d] = 0;
                        ?>
                        <th style="border-bottom:1px solid black;"> <?php echo $v; ?> </th>
                    <?php 
                    } 
                    ?>
                    <?php if ($trans_status == 'YES') { ?>
                        <th style="border-bottom:1px solid black;"> Transport Fee </th>
                    <?php } ?>
                    <th style="border-bottom:1px solid black;"> Fine </th>
                    <?php $tot_mode=array();foreach ($paymodeqry as $p) { $tot_mode[$p->id]=0;?>
                        <th style="border-bottom:1px solid black;"> <?php echo $p->mode_name;?> </th>
                    <?php }?>

                </tr>
            </thead>
            <tbody id="feehead_load_td">
                <?php
                $total_fee_amt = 0;
                $trans_amt_total = 0;
                $fine_amt_total = 0;
                $total_disc_amt = 0;
                foreach ($fetch_transaction_date as $ftd) 
                {
                    $fee_head_id = explode(',', $ftd->fhid);
                    $stud_class = explode(',', $ftd->classid);
                    $stud_course = explode(',', $ftd->courseid);
                    // $stud_cat = explode(',', $ftd->stud_category);
                    $start_fee_mn = explode(',', $ftd->st_fe_mn);
                    $mode_str = explode(',', $ftd->mode);
                    $mode_amt = explode(',', $ftd->ttamt);
                    $total_fee_amt += $ftd->total_amount;
                    $total_disc_amt += $ftd->discount_amount;

                    /*
                    $stud_class = $ftd->class_id;
                    $stud_course = $ftd->course_id;
                    $stud_cat = $ftd->stud_category;
                    $start_fee_mn = $ftd->start_fee_month;
                    $mode_str = $ftd->mode;
                    $mode_amt = $ftd->total_amount;
                    $total_fee_amt += $ftd->total_amount;
                    $total_disc_amt += $ftd->discount_amount;
                    */
                    
                    ?>                 
                    <tr>
                        <td><?php echo $ftd->payment_date; ?></td> 

                        <?php
                        $total = 0;
                        foreach ($fee_ty as $d => $v) 
                        {
                            $fee_amt = 0;
                            foreach($fee_head_id as $k=>$vc) 
                            {
                                $max_class_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year, max(id) as max_id', "(from_class_id<=$stud_class[$k] and to_class_id>=$stud_class[$k]) and course=$stud_course[$k] and status='Y' and year<=$session_start_yr");

                                $fetch_trsn_dets = $this->db->query("SELECT stud_category FROM fee_transaction_det WHERE fee_trans_head_id = $vc GROUP BY fee_trans_head_id")->result();
                                // print_r($fetch_trsn_dets);
                                $cat = $fetch_trsn_dets[0]->stud_category;
                                
                                $class_fee = $this->dbconnection->select("class_fee_det", "fee_amount,fee_cat,fee_id", "class_fee_head_id={$max_class_year[0]->max_id} and stud_cat=$cat and status=1 and fee_id=".$d);
                                if (count($class_fee) > 0) 
                                {
                                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id=$vc and fee_cat_id=" . $class_fee[0]->fee_cat);
                                
                                    if (count($fee_qry) > 0) 
                                    {
                                        if($fee_qry[0]->month_no!=0)
                                        {
                                            if($fee_cat[$d]==5)
                                            {
                                                $de=$class_fee[0]->fee_amount/3;
                                            }
                                            else
                                            {
                                               $de=$class_fee[0]->fee_amount;
                                            }                                           
                                        }
                                        else
                                        {
                                            if($fee_cat[$d]==1)
                                            {
                                                $start_fee_month=$start_fee_mn[$k];
                                              
                                                $rest_month = (12-$start_fee_month)+1;
                                                $fee_amount = $class_fee[0]->fee_amount;
                                                $fee_id     = $class_fee[0]->fee_id;
                                                if($fee_id==10 || $fee_id==16)
                                                {
                                                    $de = $fee_amount;
                                                }                
                                                else
                                                {
                                                    $de = ($fee_amount/12)*$rest_month;
                                                }
                                            }
                                            else
                                            {
                                                $dee=$class_fee[0]->fee_amount/12;
                                                $de=$dee*12;
                                            }
                                        }
                                        foreach ($fee_qry as $rfee) 
                                        {
                                            $fee_amt = $fee_amt + $de;
                                            $total += $de;
                                        }
                                    }
                                    else
                                    {
                                        $fee_amt=$fee_amt+0;
                                    } 
                                }                            
                            }
                            ?>
                        <td><?php echo $fee_amt; ?></td>
                        <?php 
                        } 
                        if ($trans_status == 'YES') 
                        {
                            if (!empty($ftd->transport_amt)) 
                            {
                                $trns_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount", "fee_trans_head_id in($ftd->fhid) and fee_cat_id=6");
                                $trans_amt = 0;
                                if (count($trns_qry) > 0) 
                                {
                                    foreach ($trns_qry as $rt) 
                                    {
                                        $trans_amt = $trans_amt + $rt->amount;
                                        $total += $rt->amount;
                                    }
                                } 
                                else 
                                {
                                    $trans_amt = 0;
                                    $total += 0;
                                }
                            } 
                            else 
                            {
                                $trans_amt = 0;
                                $total += 0;
                            }
                            ?>
                            <td><?php echo $trans_amt; ?></td>
                            <?php 
                            $trans_amt_total += $trans_amt;
                        } ?>
                        <td>
                            <?php
                            $fine_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id in ($ftd->fhid) and fee_cat_id=0");
                            $fine_amt = 0;
                            if (count($fine_qry) > 0) 
                            {
                                foreach ($fine_qry as $rfine) {
                                    $fine_amt = $fine_amt + $rfine->amount;
                                    $total += $rfine->amount;
                                }
                            } 
                            else 
                            {
                                $fine_amt = 0;
                                $total += 0;
                            }

                            $fine_amt_total += $fine_amt;
                            echo $fine_amt;
                            ?>
                        </td>
                        <td><?php echo $ftd->discount_amount; ?></td>
                        <td><?php echo $total -= $ftd->discount_amount; ?></td>
                        <?php 
                            $mode_show=array();
                            foreach ($paymodeqry as $p) 
                            { 
                                $mode_show[$p->id]=0;
                                foreach ($mode_str as $mk=>$mvalue) 
                                {
                                    if(strtolower($mvalue)==strtolower($p->mode_name))
                                    {
                                        $mode_show[$p->id] += $mode_amt[$mk];
                                    }
                                }
                                $tot_mode[$p->id] += $mode_show[$p->id];
                        ?>
                        <td><?php if($mode_show[$p->id]!=''){echo$mode_show[$p->id].' INR';}?> </td>
                        <?php 
                            }
                        ?>
                    </tr>
                <?php 
                } 
                ?>
                <tr>
                    <th>Total</th>
                    <?php 
                    foreach($fee_ty as $d=>$v) 
                    {
                    ?>
                        <th> <?php echo $total_fee_amt_wise[$d]; ?> </th>
                    <?php 
                    } 
                    ?>
                    <?php 
                    if($trans_status=='YES')
                    {
                    ?>
                    <th><?php echo $trans_amt_total;?></th>
                    <?php 
                    }
                    ?>
                    <th><?php echo $fine_amt_total;?></th>
                    <th><?php echo $total_disc_amt;?></th>
                    <th><?php echo $total_fee_amt;?></th>
                    <?php foreach ($paymodeqry as $p) {?>
                    <th> <?php if($tot_mode[$p->id]!=''){echo $tot_mode[$p->id].' INR';}?> </th>
                    <?php }?>
                </tr>


            </tbody>
        </table>

    </div>
</form>
<script>
    var table = $('#studentlist4').DataTable(
            {
//             lengthChange: false,
//                "order": [[3, "desc"]],
                dom: 'Bfrtip',
                buttons: [
//                            'excel', 'pdf', 'csv' 
                    {
                        extend: 'collection',
                        text: 'Export',
                        className: 'red',
                        buttons: [

//                                        '<i class="fa fa-file-excel-o"></i>copy',
                            'excel',
                            'csv',
                            {
                                extend: 'pdfHtml5',
                                orientation: 'landscape',
                                pageSize: 'A0'
                            },
                            {
                                extend: 'print',
                                orientation: 'landscape',
                                pageSize: 'A0'
                            },
//
//
//
////                                        'copyFlash',
////                                        'csvFlash',
////                                        'excelFlash',
////                                        'pdfFlash',
////                                        'print'
                        ]
                    }
                ]


            });

//            table.buttons().container()
//        .appendTo( '#studentlist1_wrapper .col-sm-6:eq(0)' );

</script>