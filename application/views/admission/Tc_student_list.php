<div class="form-group has-feedback">
    <div class="box">
        <div class="box-body">

            <div class="col-lg-12" style="text-align:right;">
                <?php // if(substr($right_access,0,1)=='C'){?>
                    <button  class="btn btn-add" id="add_inactive_student" title="Add Inactive Student"> <i class="fa fa-plus-circle fa-lg"></i> </button>

                    <?php // }?>
                    <a class="btn btn-export" id="studexport" href='<?= base_url() . uri_string() ?>/exportcsv/All/All' download data-toggle="tooltip" data-placement="bottom" title="Export Inactive Student">
                        <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                    </a>
            </div>
        </div>
    </div>
    <div class="box">            

        <?php if ($this->session->flashdata('successmsg')) { ?>
        <div class="box-body">
            <div class="col-md-5 col-md-offset-3" style="height:40px">
                
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible"  id="success-alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong><?php echo $this->session->flashdata('successmsg'); ?>
                        </div>
                    </div>
            </div>
        </div>
         <?php } ?>
         <?php //} else if($this->session->flashdata('errormsg')){ ?>
        <?php if ($this->session->flashdata('errormsg')) { ?>
        <div class="box-body">
            <div class="col-md-5 col-md-offset-3" style="height:40px">
                
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible"  id="success-alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error !</strong><?php echo $this->session->flashdata('errormsg'); ?>
                        </div>
                    </div>
            </div>
        </div>
         <?php// } else {  ?>
         <?php } ?>

        <div class="box-body">
            <form id='frmemployee' role="form" method="POST">
                <div class="table-responsive">
                    <table id="employeelist" class="table table-bordered table-striped">
                        <thead style="background:#99ceff;">
                            <tr> 

                                <th style="border-bottom:0px">#</th>
                                <th style="border-bottom:0px">Admission No.</th>
                                <th style="border-bottom:0px">Student Name</th>
                                <th style="border-bottom:0px">Date</th>
                                <th style="border-bottom:0px">Academic Session</th>
                                <th style="border-bottom:0px">Reason</th>
                                <th style="border-bottom:0px">Remark</th>
                                <th style="border-bottom:0px">Status</th>

                                <th style="border-bottom:0px">Deposit(Onetime) Refund </th>   
                                <th style="border-bottom:0px">Quarterly Refund</th>   
                                <th style="border-bottom:0px">Annual Refund</th>   
                                <th style="border-bottom:0px">Total Refundable Amount</th>   
                                
                                <th style="border-bottom:0px">Action</th>
                            </tr>
                        </thead>
                        <thead style="background: #cce6ff">
                            <tr id="searchhead">
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="0"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="2"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="3"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="4"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="5"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="6"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="7"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="8"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="9"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="10"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="11"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($query_payment as $key=> $row):

                                ?>

                                <tr onclick="chkadmissio(<?php echo $row->admission_no; ?>);">
                                    <td><?php echo $count; ?></td>                                         
                                    <td><?php echo $row->admission_no; ?></td>                                         
                                    <td><?php echo $row->name; ?></td>                                         
                                    <td><?php echo $row->date; ?></td>                                         
                                    <td><?php // echo $row->academic_year_id; ?></td>                                         
                                    <td><?php echo $row->reason; ?></td>                                         
                                    <td><?php echo $row->remarks; ?></td>                                         
                                    <td><?php echo $row->status; ?></td>           
                                    <?php if ($row->status == 'TC') {
                                        
                                        $dexplode= explode('-', $row->date) ;
                                        $daytc=$dexplode[2];
                                        $montc=$dexplode[1]; //6
                                        if( $daytc<=05) { //5
                                            $montc=$montc-1;
                                        }
                                        
                                        $montc1=$montc;
                                        if ($montc >= 1 && $montc <= 3) {
                                            $montc1 = 4;
                                        }
                                        $montc1 = $montc1 - 3; //mon rkhna
                                        if($quarterly[$key]->m>0) {
                                            $quar_feeamt=$quarterly[$key]->amount/$quarterly[$key]->m;
                                        }else{
                                            $quar_feeamt=$quarterly[$key]->amount;
                                        }
                                        $monthpaid=$quarterly[$key]->m+ ($row->start_fee_month-1);
                                        if($monthpaid>0) {
                                            $monrefund=$monthpaid-$montc1;
                                            $monrefundant=$monrefund*$quar_feeamt;
                                        }else{
                                            $monrefundant=0;
                                            $monrefund=0;
                                        }
//                                        $ann_feeamt=$annual[$key]->amount/(12-$row->start_fee_month-1);
//                                        $annrefund=$annual[$key]->amount-($ann_feeamt*($montc1-($row->start_fee_month-1)))-120;
                                        $ann_feeamt=($annual[$key]->amount-120-180)/(12);
                                        $annrefund=$ann_feeamt*(12-($montc1+($row->start_fee_month-1)));
                                        if($annrefund<0) $annrefund=0;
                                        $onetime=$refundable_onetime[$key]->amount;
                                        ?>
                                        <td><?php echo round($onetime); ?></td>   
                                        <td><?php echo round($monrefundant); ?></td>   
                                        <td><?php echo round($annrefund); ?></td>   
                                        <td><?php echo round($monrefundant+$annrefund+$onetime); ?></td>   
                                    <?php } else { ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <?php } ?>
                                    <!--<td><?php // echo $row->email; ?></td>-->                                         
                                    <td>
                                    <div class="form-group row">

                                    <?php // if(substr($right_access,2,1)=='U'){ ?>
                                    <div class="col-sm-2">
                                        <a class="btn a-edit" id="<?php echo $row->tc_id; ?>" href="<?php echo base_url(); ?>admission/TcStudent/EditTcStudentPage/<?php echo $row->tc_id; ?>" style="padding-left: 0px;">
                                            <i class="fa fa-edit"></i> 
                                        </a>
                                        <a class="btn a-delete" id="<?php echo $row->tc_id; ?>" href="<?php echo base_url(); ?>admission/TcStudent/deleteTCstudent/<?php echo $row->tc_id; ?>" style="padding-left: 0px;">
                                            <i class="fa fa-trash"></i> 
                                        </a>
                                    </div>
                                    <?php // } ?>
                                    <div class="col-sm-2">
                                        <a class="btn a-invoice" href="<?php echo base_url(); ?>certificate/certificate/direct_tc_certificate_pdf/<?php echo $row->student_id; ?>" id="tc_gen" value="" style="padding-left: 0px;" title="Generate TC" target="_blank">
                                            <i class="fa fa-print"></i> 
                                        </a>
                                    </div>
                                    </div>
                                    </td>
                                </tr>
                            <?php $count++;
                            endforeach; ?>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </form>
        </div>
          <div class="row" style="padding-top:2%">
 <!--                    <div class="col-sm-12" id="fee_collect_div">
                        <div class="panel  panel-success">
                            <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-th-list"></i><b> <span style="color:black">Student Information</span></b></div>
                            <div class="panel-body" style="padding:0px"></div>
                        </div>
                        <div class="panel  panel-info">
                            <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-folder-open">  </i> <b> <span style="color:black"> Fees Collection</span></b></div>
                            <div class="panel-body" style="padding:0px;"></div>
                        </div>
                    </div>
                </div>  
    </div>

</div>
</div>
<script>
    function chkadmissio(me)
    {
        var adm=me;
//        alert(adm);
       $('#fee_collect_div').html('<div class="panel  panel-success">\n\
<div class="panel-heading" style="padding: 5px 15px;">\n\
<i class="glyphicon glyphicon-th-list"></i><b> <span style="color:black">Student Information</span></b>\n\
</div>\n\
<div class="panel-body" style="padding:0px"></div>\n\
</div>\n\
<div class="panel  panel-info">\n\
<div class="panel-heading" style="padding: 5px 15px;">\n\
<i class="glyphicon glyphicon-folder-open">  </i> <b> <span style="color:black"> Fees Collection</span></b>\n\
</div>\n\
<div class="panel-body" style="padding:0px;"></div></div>');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('admission/TcStudent/loadfeedata'); ?>',
                    data:
                            {
                                adm: adm,
                            },
                    success: function (res)
                    {
                        console.log('hiiiii');
//                                           alert(res);
                        $('#fee_collect_div').html(res);
                        $('select').select2({width:'100%',theme: "classic"});

                    },
                    error: function (req, status)
                    {
                        alert('No data Found');
                        return false;
                    }
                });
    }
</script> -->
<script>
    var globalid = '';
    var school_temp = '';
    var newtxt = 1000;

    $(document).ready(function ()
    {
        $('#add_inactive_student').click(function ()
        {


            window.location.href = "<?php echo base_url('admission/TcStudent/AddTcStudentPage'); ?>";

        });


    });

    $(function ()
    {
        var table = $('#employeelist').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
        $('#searchhead th input').on('keyup change', function () {

            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });

    });

</script>




