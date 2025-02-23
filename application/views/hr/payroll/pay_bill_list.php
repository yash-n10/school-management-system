
<div class="form-group">

    <div class="box">            
        <div class="box-body">
            <?php if (substr($right_access, 0, 1) == 'C') { ?>
                <div class="col-lg-12">
                    <div class="col-lg-12" style="text-align:right;">
                        <button data-toggle="modal" class="btn btn-add" id="calc_sal" title="Pay bill Generation"> <i class="fa fa-plus-circle fa-lg"></i></button>
                    </div>

                </div>
            <?php } $colcnt1=0;?>  


        </div>
        <div class="box-body">
            <form id='frmtemplate' role="form" method="POST">
                <div class="box-body"> 
                    <div class="table-responsive">
                        <table id="salary_calculation_list" class="table table-bordered table-striped">
                            <thead style="background: #99ceff;">
                                <tr>
                                    <th style="border-bottom:0px">Pay Bill No</th>  
                                    <th style="border-bottom:0px">For Year-Month</th>  
                                    <th style="border-bottom:0px">Date of Generation</th>  
                                    <th style="border-bottom:0px">Actions</th>  
                                </tr>
                            </thead>
                            <thead style="background: #d9e9f8;">
                                <tr id="searchhead">
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1;
            $colcnt1++; ?>"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1;
            $colcnt1++; ?>"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1;
            $colcnt1++; ?>"/>
                                    </th>



                                    <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                </tr>
                            </thead>
                            <tbody>  
                                <?php
                                $count = 1;
                                foreach ($query as $row):
                                    $sa_date=$row->sal_pay_date;
                                    $sal_date=date($sa_date,'Y-m-d');
                                    ?>

                                    <tr>

                                        <td><?php echo $row->paybillno; ?></td>                                                                               
                                        <td><?php echo $row->year . '-' . $row->month; ?></td>                                                                               
                                        <td><?php echo $sa_date; ?></td>                                                                                                                                                            
                                                                            
                                        <td>

                                                <!--<div class="form-group row">-->
                                                <?php if (substr($right_access, 3, 1) == 'D') { ?>
                                                    <!--<div class="col-sm-1" style="line-height: 2;">-->
                                                    <input type="checkbox" class="btn"  id="<?php echo $row->paybillno; ?>">
                                                    <!--</div>-->
        <?php } if (substr($right_access, 2, 1) == 'U') { ?>  
                                                    <!--<div class="col-sm-2">-->

                                                    <a class="btn a-edit" id="<?php echo $row->paybillno; ?>" onclick="edit(this)">
                                                        <i class="fa fa-edit"></i>  
                                                    </a>


                                        <?php }
                               
                                    ?>
                                        </td>

                                    </tr>
<?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>

                    </div>
                </div>
<?php if (substr($right_access, 3, 1) == 'D') { ?>
                    <div class="box-body" style="text-align:right">
                    <?php if (count($query) > 0) { ?>              
                            <input type="button" class="btn btn-danger" id="sal_head" value="Delete" onclick="delete_salary_calc();">
    <?php } ?>

                    </div>
<?php } ?>
            </form>

            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

    <script>


        $(function ()
        {
            var table = $('#salary_calculation_list').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });

            $('#searchhead th input').on('keyup change', function () {
    //            if ( this.search() !== this.value ) {
    //                this
    //                    .search( this.value )
    //                    .draw();
    //            }
                var i = $(this).attr('data-column');
                var v = $(this).val();
                table.columns(i).search(v).draw();
            });

        });

        $('#calc_sal').click(function ()
        {
            window.location.href = "<?php echo base_url('hr/payroll/pay_bill/add_sal_calc'); ?>";

        });

        function edit(me)
        {
            var id = me.id;
            window.location.href = "<?php echo base_url('hr/payroll/pay_bill/edit_sal_calc'); ?>" + '/' + id;
        }

    //$('#salary_calculation_list button').click(function()
    //{
    //    var id=$(this).attr('id');
    ////    alert('hi'+id);
    //     window.location.href = "<?php // echo base_url('hr/payroll/salary_calculator/edit_sal_calc');  ?>"+'/'+id+'/'+'View';
    //});


        function paySlip(me, status) {

            $.ajax({
                url: "<?php echo site_url('hr/payroll/my_payslip/viewSalary') ?>",
                type: "POST",
                data: {id: me.id},
                dataType: "JSON",
                success: function (data)
                {
    //                        alert(data);
                    $('#sal_cal_id').val(me.id);
                    $('#sal_ecode').text(data['emp_code']);
                    $('#sal_ename').text(data['emp_name']);
                    $('#sal_ecat').text(data['emp_cat']);
                    $('#sal_edesg').text(data['emp_desg']);
                    $('#sal_aadhar').text(data['emp_desg']);
                    $('#sal_pf').text(data['pfaccnt']);
                    $('#sal_esic').text(data['esicaccnt']);
                    $('#sal_bnkaccnt').text(data['bnkaccnt']);
                    $('#sal_workingdays').text(data['workingdays']);
                    $('#sal_leaveapprove').text(data['leaveapprove']);
                    $('#sal_absent').text(data['absent']);
                    $('#sal_present').text(data['present']);
                    $('#sal_payslipno').text(data['payslipno']);
                    $('#sal_month').text(data['sal_monthyr']);
                    $('.earning').remove();
                    $('#heading').after(data['earning']);
                    $('#sal_grosssal').text(data['gross']);
                    $('.deduction').remove();
                    $('#grosssal').after(data['deduction']);
                    $('#sal_netsal').text(data['net']);
                    $('#sal_pfemployer').text(data['pfemployer']);
                    $('#sal_esicemployer').text(data['esicemployer']);
                    $('#sal_ctcm').text(data['ctcm']);
                    $('#sal_ctcy').text(data['ctcm'] * 12);
                    if (status == 'payment') {
                        $('#salary_payment').show();
                        $('#payslip_dwnld').hide();
                        $('#pay-title').text('Salary Payment');
                    } else {
                        $('#salary_payment').hide();
                        $('#payslip_dwnld').show();
                        $('#pay-title').text('Pay Slip')
                    }
                    $('#mySalaryView').modal('show');
                },
                error: function (data, status)
                {
                    alert('e' + data + status);
                }
            });
        }


        $('#salary_payment').click(function ()
        {
            var con = confirm('Are you sure want to proceed further ?');

            if (con == true) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('hr/payroll/salary_calculator/pay') ?>",
                    data: {
                        sal_calc_id: $('#sal_cal_id').val(),
                        sal_month: $('#sal_month').text(),
                        sal_ecode: $('#sal_ecode').text(),
                    },
                    datatype: 'text',
                    success: function (data)
                    {
                        alert('Salary Paid');
                        window.location.href = "<?php echo base_url('hr/payroll/salary_calculator'); ?>";
                    },
                    error: function (req, status)
                    {
                        alert('Error while paying');
                    }
                });
            }

        });



        function delete_salary_calc()
        {
            var r = confirm("Are you sure you want to delete this record?");
            if (r == true)
            {
    //                      var emp_id_string =$(this).attr('id');
                var emp_id_string = [];
                var i = 0;
                $("input:checked").each(function ()
                {
                    emp_id_string[i] = $(this).attr("id");
                    i++;
                });
    //                        alert(emp_id_string.length);
                if (emp_id_string.length == 0) {
                    alert('Please choose any checkbox first');
                    return false;
                }

                $.ajax({
                    url: "<?php echo site_url('hr/payroll/salary_calculator/delete') ?>",
                    type: "POST",
                    data: {employee_id_string: emp_id_string},
                    dataType: "text",
                    success: function (data)
                    {
                        window.location.href = "<?php echo base_url('hr/payroll/salary_calculator'); ?>";
    //                         
                    },
                    error: function (data, status)
                    {
                        alert('e' + data + status);
                    }});

            }
        }


        $('#mnth,' + '#year').change(function ()
        {
            var mon = $('#mnth').val();
            var yr = $('#year').val();
            window.location.href = "<?php echo base_url('hr/payroll/salary_calculator/index'); ?>" + '/' + yr + '/' + mon;
        });

    </script>




