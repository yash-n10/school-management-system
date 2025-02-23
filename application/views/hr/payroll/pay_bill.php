<style>

    .form-group{margin-bottom: 10px;} 
    fieldset { 
        border: solid 1px #DDD !important;
        padding: 0 10px 10px 10px;
        border-bottom: none;
    }
    legend{
        width: auto !important;
        padding:0 10px;
        border: none;
        font-size: 14px;
    }
    .form-control{
        padding: 6px 5px !important;
    }
    .chosen-disabled {
        opacity: 6.5!important;
        cursor: default;
    }
    .div_margin{
        padding-left:0px !important;
        padding-right:0px !important;
    }
</style>
<div class="form-group">
    <div class="panel  panel-default"> 


        <div class="panel-body">

            <form enctype="multipart/form-data" id="salarydetails_form" action="" method="post">
                <div class="col-sm-12 col-md-12">

                    <div class="form-group ">
                        <label class="control-label col-md-2">Pay Bill No.</label>
                        <div class="col-md-2" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="paybillno" name="paybillno" placeholder="Pay Bill No" value='<?php if($task=='Save') {echo date('ymdHis');}else{ echo $paybill;}?>' readonly>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-md-2">Year/Month</label>
                        <div class="col-md-2" style='padding-bottom:1%'>
                            <div class='input-group date' id='datetimepicker1'>
                                    <input type='month' class="form-control" id="applicable_from" name="applicable_from" value="<?php echo $month;?>" placeholder="xxxx-xx (e.g 2017-11)" required <?php if($task!='Save') echo 'readonly';?>>
                                </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-md-2"></label>
                        <div class="col-md-2" style='padding-bottom:1%'>
                            <input type="button" name="print" id="printdoc" value="print">
                        </div>
                    </div>
                </div> 
                <div class="col-sm-12 col-md-12 table-responsive" id="load_employee">
                    <table id="loadbill" class="table table-bordered table-striped">
                        <thead>
                            <tr> 
                                <th> Sl No. </th>
                                <th> Name</th>
                                <th> Desig </th>
                                <th> Fixed Pay </th>
                                <th> Grade Pay </th>
                                <th> Actual Basic </th>
                                <th> WD</th>
                                <?php foreach($saltype as $r) {
                                    
                                if($r->salary_typ==1) {
                                ?>
                                    <th> <?php echo  $r->salary_name;?></th>
                              
                                <?php }}?>
                                <th> Total Gross</th>
                                <?php foreach($saltype as $r) {
                                    
                                if($r->salary_typ==2) {
                                    
                                ?>
                                    <th> <?php echo  $r->salary_name;?></th>
                              
                                <?php }}?>
                                <th> Advance Taken</th>
                                <th> Total Deduction</th>    
                                <th> Net Pay</th>   
                            </tr> 
                        </thead>
                        <tbody id="bill_load_td">
                            
                            <?php $i=0;foreach ($query as $q) { $i++;?>
                            <tr> 
                                <td> <?php echo $i;?> </td>
                                <td> <input type="hidden" name="emp_id[]" value="<?php echo $q->id;?>">
                                <?php echo $q->name;?></td>
                                <input type="hidden" name="log_id[]" value="<?php echo $q->logid;?>">
                                <td> <?php echo $q->designation_desc;?> </td>
                                <td> <?php echo $q->current_basic_pay;?> </td>
                                <td> <?php echo $q->grade_pay;?> </td>
                                <td> <?php echo $q->current_basic_pay;?> </td>
                                <td><input type="text" name="wd[]" value="<?php if($task=='Save') echo $wd; else echo $q->working_day;?>" onchange="calc_fun(this,<?php echo $q->current_basic_pay;?>)"></td>
                                <?php $gross=0; 
                                $ba=$q->current_basic_pay;        
                                $grade_pay=$q->grade_pay;        
                                $dapercent=$saltype[1]->percent_or_amt;
                                $da=($dapercent*$ba)/100;
                                $total_gross=0;
                                $total_deduct=0;
                                foreach($saltype as $r) {
                                    $wagetype=$r->wages_type;
                                    $percent_amt=$r->percent_or_amt;
                                        if($r->salary_typ==1) {
                                            if($r->id==1){
                                ?>
                                                    <td id="<?php echo 'earn_'.$r->id;?>"> <?php echo $ba;$total_gross=$total_gross+$ba;?> </td>
                                             <?php 
                                             
                                            }elseif($r->id==2){?>
                                    
                                                    <td id="<?php echo 'earn_'.$r->id;?>"> <?php echo $da;$total_gross=$total_gross+$da?> </td>
                                            <?php }else{
                                         
                                         
                                                    switch($wagetype) {
                                                         case 'FIXED' :$amtsal=$percent_amt; break;
                                                         case 'GROSS' :$amtsal=($percent_amt*$gross)/100;break;
                                                         case 'BA+DA' :$amtsal=($percent_amt*($ba+$da))/100;break;
                                                         case 'BA' :   $amtsal=($percent_amt*$ba)/100; break;
                                                         default:$amtsal=0;
                                                    }
                                                    ?>

                                                   <td id="<?php echo 'earn_'.$r->id;?>"> <?php echo $amtsal;$total_gross=$total_gross+$amtsal;?> </td>
                                            <?php 
                                     
                                            }
                                     
                                        }
                                     
                                }?>
                                <td id="calcgrosssal"><?php echo $total_gross;?> </td>
                                <?php foreach($saltype as $r) {
                                            $wagetype=$r->wages_type;
                                            $percent_amt=$r->percent_or_amt;
                                            if($r->salary_typ==2) {
                                            switch($wagetype) {
                                                     case 'FIXED' :$amtdsal=$percent_amt; break;
                                                     case 'GROSS' :$amtdsal=($percent_amt*$gross)/100;break;
                                                     case 'BA+DA' :$amtdsal=($percent_amt*($ba+$da))/100;break;
                                                     case 'BA' :   $amtdsal=($percent_amt*$ba)/100;    break;
                                                     default:$amtdsal=0;
                                                }
                                ?>
                                                    <td id="<?php echo 'deduct_'.$r->id;?>"> <?php echo $amtdsal;$total_deduct=$total_deduct+$amtdsal;?></td>
                              
                                            <?php 
                                            
                                            }
                                                     
                                      }?>
                                <td><input type="text" name="advance[]" value="<?php echo 0;?>"> </td>    
                                <td id="totaldeduct"> <?php echo $total_deduct;?> </td>    
                                <td id="net_pay_id"> <?php echo $total_gross-$total_deduct;?> <input type="hidden" name="net_pay[]" value="<?php echo $total_gross-$total_deduct;?>"></td>   
                            </tr> 
                            <?php }?>
                        </tbody>
                    </table>
                </div>
                
                <div class="col-sm-12 col-md-12" style="text-align: center">
                    
                    <input type="button" class="btn btn-success" id="btn_save" value="<?php echo $task;?>">
                </div>
            </form>
        </div>

    </div>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->


<script> 

    $(document).ready(function () {

    var task='<?php echo $task;?>';

        

        $('#btn_save').click(function () {

            if (task == 'Save')
            {
                action_url = '<?php echo base_url('hr/payroll/pay_bill/save'); ?>';
            }
            else
            {
                var sal_calc_id = '<?php echo $paybill; ?>';
                action_url = '<?php echo base_url('hr/payroll/pay_bill/update'); ?>' + '/' + sal_calc_id;
            }


//                alert(action_url);
            if (!$('#salarydetails_form')[0].checkValidity())
            {
//                                                alert($('#add_stud_frm')[0].validationMessage);
                $(this).show();
                $('#salarydetails_form')[0].reportValidity();
                return false;
            } else {

                var savestatus = confirm('Are you sure want to save');

                if (savestatus == true) {
                    $.ajax({
                        type: 'POST',
                        url: action_url,
                        data: $('#salarydetails_form').serialize(),
                        datatype: 'text',
                        success: function (data)
                        {
                            alert('saved successfully');
                            window.location.href = "<?php echo base_url('hr/payroll/pay_bill'); ?>";
                        },
                        error: function (req, status)
                        {
                            alert('error while saving');
                        }
                    });
                }
            }
        });

        $('#printdoc').click(function(){
            var data = '<input type="button" value="Print this page" onClick="window.print()">';           
            data += '<html><body>';
            data += '<div id="div_print">';
            data += $('#salarydetails_form').html();
            data += '</div></body></html>';

            myWindow=window.open('','','width=200,height=100');
            myWindow.innerWidth = screen.width;
            myWindow.innerHeight = screen.height;
            myWindow.screenX = 0;
            myWindow.screenY = 0;
            myWindow.document.write(data);
            myWindow.focus();
        });

        $('#applicable_from').on('change focus',function(){
            if(this.value!='') {
            $('#salarydetails_form').attr('href', '<?php echo base_url('hr/payroll/pay_bill/load_employee'); ?>');
            $('#salarydetails_form') .submit(); 
            }
        });


        function getNumberOfDays(month, year)
        {
            var day = new Date(year, month, 0).getDate();
            return day;
//      alert(day);
        }

        function getNumberOfSundays(m, y)
        {
            var days = new Date(y, m, 0).getDate();
            var sundays = [8 - (new Date(m + '/01/' + y).getDay())];
            for (var i = sundays[0] + 7; i < days; i += 7)
            {
                sundays.push(i);
            }
            return  sundays; 
        }
        

        
        
        function datatable()
        {
           

            $('#studentlist1').DataTable({
                "destroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "processing": true,
                serverSide: true,
                ajax: {
                    url: '<?php echo base_url('feepayment/Report/paymentlog_report'); ?>',
                    type: 'POST',
                    data: {class_id: class_id,
                        section_id: section_id,
                        from_date: from_date,
                        to_date: to_date,
                        collection_center: collection_center,
                        transac_type: transac_type,
                    }
                },
//                "dom": 'Bfrtip',
//                 buttons: [
//                                {
//                                    extend: 'collection',
//                                    text: 'Export',
//                                    buttons: [
////                                        'copy',
//                                        'excel',
//                                        'csv',
//                                        'pdf',
//                                        'print'
//                                    ]
//                                }
//                            ],

            });
        }

    });

        var arrayFromPHP = <?php echo json_encode($saltype); ?>;
        function calc_fun(me,basic,salary) {
            var changeday=me.value;
            var gross_sal=0;
            var totaldeduct=0;
            $.each(arrayFromPHP,function(i,elem){
                if(elem.salary_typ==1) {
                    var sal=Number($(me).closest('tr').find('td[id="earn_'+elem.id+'"]').text());
                    if($.isNumeric(sal)) {
                        var newsal=(sal/30)*changeday;
                        $(me).closest('tr').find('td[id="earn_'+elem.id+'"]').text(newsal.toFixed(0));
                        gross_sal=gross_sal+Number(newsal.toFixed(0));
                    }
                }
                
                if(elem.salary_typ==2) {
                    var sal=Number($(me).closest('tr').find('td[id="deduct_'+elem.id+'"]').text());
                    if($.isNumeric(sal)) {
                        var newsal=(sal/30)*changeday;
                        $(me).closest('tr').find('td[id="deduct_'+elem.id+'"]').text(newsal.toFixed(0));
                        totaldeduct=totaldeduct+Number(newsal.toFixed(0));
                    }
                }
                
            }); 
            $(me).closest('tr').find('td[id="calcgrosssal"]').text(gross_sal); 
            var totaldeduct=totaldeduct+Number($(me).closest('tr').find('input[name^="advance"]').val());  
            $(me).closest('tr').find('td[id="totaldeduct"]').text(totaldeduct);  
            $(me).closest('tr').find('td[id="net_pay_id"]').text(gross_sal-totaldeduct);  
            $(me).closest('tr').find('input[name^="net_pay"]').val(gross_sal-totaldeduct);  
        }

</script>
